<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller
{
    public function articlesList(Request $request)
    {
        $pagination = null;
        $articles = DB::table('articles')
            -> select('articles.id', 'articles.title', 'users.name as author', 'catalogs.name as catalog',
                'articles.createdAt', 'articles.publishedAt', 'articles.weight', 'tags.name as tag')
            -> leftJoin('users', 'users.id', '=', 'articles.authorId')
            -> leftJoin('tags', 'tags.id', '=', 'articles.tagId')
            -> leftJoin('catalogs', 'catalogs.id', '=', 'articles.catalogId')
            -> where('articles.isDelete', 0)
            -> where('articles.inTrash', 0)
            -> where('users.isDelete', 0)
            -> where('tags.isDelete', 0)
            -> where('catalogs.isDelete', 0)
            -> where(function ($query) use ($request) {
                if ($request -> has('title') && $request -> title != '') {
                    $query -> where('articles.title', 'like', '%' .$request -> title. '%');
                }
                if ($request -> has('catalog') && $request -> catalog != 0) {
                    $query -> where('articles.catalogId', $request -> catalog);
                }
                if ($request -> has('tag') && $request -> tag != 0) {
                    $query -> where('articles.tagId', $request -> tag);
                }
                if ($request -> has('start') && $request -> start != '') {
                    $query -> where('articles.publishedAt', '>=', $request -> start . ' 00:00:00');
                }
                if ($request -> has('end') && $request -> end != '') {
                    $query -> where('articles.publishedAt', '<=', $request -> end . ' 23:59:59');
                }
            })
            -> orderBy('articles.weight', 'ASC')
            -> orderBy('articles.createdAt', 'DESC')
            -> paginate(15);
        $tags = $this -> getTags();
        $catalogs = $this -> getCatalogs();
        $defaults = $this -> getSearchConditions($request);
        return view('backend.contents.articlesList', ['articles' => $articles, 'catalogs' => $catalogs,
            'tags' => $tags, 'defaults' => $defaults]);
    }

    public function unStickArticles($id = 0)
    {
        try {
            DB::table('articles')
                -> where('id', $id)
                -> update(['weight' => 1000]);
            return redirect() -> back() -> with('success', '取消文章置顶成功！');
        } catch (\Exception $e) {
            return redirect() -> back() -> with('error', '取消文章置顶失败，原因：' . $e -> getMessage());
        }
    }

    public function stickArticles(Request $request)
    {
        $roles = [
            'id' => 'required|exists:articles,id,isDelete,0',
            'weight' => 'required|numeric|min:0|max:999'
        ];
        $messages = [
            'id.required' => '该文章不存在！',
            'id.exist' => '该文章不存在！',
            'weight.required' => '请输入文章显示权重！',
            'weight.numeric' => '权重应为0-999之间的数字！',
            'weight.min' => '权重应为0-999之间的数字！',
            'weight.max' => '权重应为0-999之间的数字！'
        ];
        $this -> validate($request, $roles, $messages);
        try {
            DB::table('articles')
                -> where('id', $request -> id)
                -> update(['weight' => $request -> weight]);
            return redirect() -> back() -> with('success', '设置文章置顶成功！');
        } catch (\Exception $e) {
            return redirect() -> back() -> with('error', '设置文章置顶失败，原因：' . $e -> getMessage());
        }
    }

    public function moveToTrash($id = 0)
    {
        try {
            DB::table('articles')
                -> where('id', $id)
                -> update(['inTrash' => 1]);
            return redirect() -> back() -> with('success', '删除文章成功，请到回收站中查看！');
        } catch (\Exception $e) {
            return redirect() -> back() -> with('error', '删除文章失败，原因：' . $e -> getMessage());
        }
    }

    public function articleForm($id = 0)
    {
        if ($id !== 0) {
            $article = [];
        } else {
            $article = null;
        }
        return view('backend.contents.articleForm', ['type' => $id, 'article' => $article]);
    }

    private function getTags()
    {
        $tags = ['0' => '请选择'];
        $dbTags = DB::table('tags')
            -> select('id', 'name')
            -> where('isDelete', 0)
            -> get();
        if (count($dbTags) > 0) {
            foreach ($dbTags as $dbTag) {
                $tags[$dbTag -> id] = $dbTag -> name;
            }
        }
        return $tags;
    }

    private function getCatalogs()
    {
        $catalogs = ['0' => '请选择'];
        $dbCatalogs = DB::table('catalogs')
            -> select('id', 'name')
            -> where('isDelete', 0)
            -> where('id', '<>', 1)
            -> get();
        if (count($dbCatalogs) > 0) {
            foreach ($dbCatalogs as $dbCatalog) {
                $catalogs[$dbCatalog -> id] = $dbCatalog -> name;
            }
        }
        return $catalogs;
    }

    private function getSearchConditions(Request $request)
    {
        $default = [];
        $pagination = [];
        $req = $request -> all();
        foreach ($req as $key => $value) {
            if (!is_null($value)) {
                $default[$key] = $value;
                $pagination[$key] = $value;
            }
        }
        return ['default' => $default, 'pagination' => $pagination];
    }
}

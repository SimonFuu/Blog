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
        $tags = $this -> getTags();
        $catalogs = $this -> getCatalogs();
        if ($id !== 0) {
            $article = DB::table('articles')
                -> select('id', 'title', 'catalogId', 'tagId', 'publishedAt', 'abstract as abstractContent', 'content')
                -> where('isDelete', 0)
                -> where('id', $id)
                -> first();
            if (is_null($article)) {
                abort(404);
            }
        } else {
            $article = null;
        }
        return view('backend.contents.articleForm',
            ['type' => $id, 'article' => $article, 'tags' => $tags, 'catalogs' => $catalogs]);
    }

    public function storeArticle(Request $request)
    {
        $roles = [
            'title' => 'required|min:5|max:255',
            'catalogId' => 'required|exists:catalogs,id,isDelete,0',
            'tagId' => 'required|exists:tags,id,isDelete,0',
            'publishedAt' => 'required|date',
            'abstract' => 'sometimes|max:255',
            'content' => 'required|min:50|max:10000',
            'id' => 'sometimes|exists:articles,id,inTrash,0'
        ];
        $messages = [
            'title.required' => '请输入文章标题！',
            'title.min' => '文章标题长度为5-255！',
            'title.max' => '文章标题长度为5-255！',
            'catalogId.required' => '请选择文章目录！',
            'catalogId.exists' => '文章目录不正确！',
            'tagId.required' => '请选择文章标签！',
            'tagId.exists' => '文章标签不正确！',
            'publishedAt.required' => '请选择文章发布时间！',
            'publishedAt.data' => '文章发布时间格式错误！',
            'abstract.sometimes' => '请输入摘要内容',
            'abstract.max' => '文章摘要长度不得大于255！',
            'content.required' => '请输入文章内容！',
            'content.max' => '文章内容长度最低为10000！',
            'content.min' => '文章内容长度最低为50！',
            'id.sometimes' => '文章ID不存在！',
            'id.exists' => '文章不存在或已删除！',
        ];
        $this -> validate($request, $roles, $messages);
        $data = $request -> except('_token');
        dd($data);
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

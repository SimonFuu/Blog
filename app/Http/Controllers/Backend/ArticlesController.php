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

    public function addForm()
    {
        return view('backend.index');
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

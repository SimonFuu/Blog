<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller
{
    public function getArticle($id = 0)
    {
        $article = DB::table('articles')
            -> select(
                'articles.id', 'articles.title', 'articles.content', 'users.name',
                'tags.name as tag', 'articles.tagId', 'catalogs.name as catalog', 'articles.catalogId', 'articles.publishedAt'
            )
            -> leftJoin('users', 'users.id', '=', 'articles.authorId')
            -> leftJoin('catalogs', 'catalogs.id', '=', 'articles.catalogId')
            -> leftJoin('tags', 'tags.id', '=', 'articles.tagId')
            -> where('articles.isDelete', 0)
            -> where('articles.id', $id)
            -> where('articles.publishedAt', '<=', date('Y-m-d H:i:s'))
            -> first();
        if (is_null($article)) {
            abort(404);
        }
        $article -> nextArticle = $this -> getNextArticle($article -> publishedAt);
        $article -> prevArticle = $this -> getPrevArticle($article -> publishedAt);
        return view('frontend.article', ['article' => $article]);
    }

    private function getNextArticle($date = '1990-01-01 00:00:00')
    {
        return DB::table('articles')
            -> select('id', 'title')
            -> where('isDelete', 0)
            -> where('publishedAt', '>', $date)
            -> orderBy('publishedAt', 'ASC')
            -> first();
    }

    private function getPrevArticle($date = '1990-01-01 00:00:00')
    {
        return DB::table('articles')
            -> select('id', 'title')
            -> where('isDelete', 0)
            -> where('publishedAt', '<', $date)
            -> orderBy('publishedAt', 'ASC')
            -> first();
    }
}

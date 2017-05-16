<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\DB;

class IndexController extends FrontendController
{
    public function index()
    {
        $articles = DB::table('articles')
            -> select(
                'articles.id', 'articles.title', 'articles.abstract as abstractContent', 'articles.thumb', 'users.name',
                'tags.name as tag', 'articles.tagId', 'catalogs.name as catalog', 'articles.catalogId', 'articles.publishedAt'
                )
            -> leftJoin('users', 'users.id', '=', 'articles.authorId')
            -> leftJoin('catalogs', 'catalogs.id', '=', 'articles.catalogId')
            -> leftJoin('tags', 'tags.id', '=', 'articles.tagId')
            -> where('articles.inTrash', 0)
            -> where('catalogs.inTrash', 0)
            -> where('tags.inTrash', 0)
            -> where('articles.publishedAt', '<=', date('Y-m-d H:i:s'))
            -> orderBy('articles.publishedAt', 'DESC')
            -> paginate(env('ARTICLES_PAGINATION_COUNT'));
        return view('frontend.index', ['title' => '首页', 'articles' => $articles]);
    }
}

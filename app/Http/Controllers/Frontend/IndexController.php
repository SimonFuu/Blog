<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
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
            -> where('articles.isDelete', 0)
            -> where('articles.publishedAt', '<=', date('Y-m-d H:i:s'))
            -> paginate(env('APP_FRONTEND_PAGINATION_PER_PAGE'));
        return view('frontend.index', ['articles' => $articles]);
    }
}

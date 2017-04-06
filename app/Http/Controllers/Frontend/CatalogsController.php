<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CatalogsController extends Controller
{
    public function getCatalogArticles($id = 0)
    {
        # 首页文章的显示最大字数是185
        $articles = DB::table('articles')
            -> select(
                'articles.id', 'articles.title', 'articles.abstract as abstractContent', 'articles.thumb', 'users.name',
                'tags.name as tag', 'articles.tagId', 'catalogs.name as catalog', 'articles.catalogId', 'articles.publishedAt'
            )
            -> leftJoin('users', 'users.id', '=', 'articles.authorId')
            -> leftJoin('catalogs', 'catalogs.id', '=', 'articles.catalogId')
            -> leftJoin('tags', 'tags.id', '=', 'articles.tagId')
            -> where('articles.isDelete', 0)
            -> where(function ($query) use ($id) {
                if ($id > 1) {
                    $query -> where('articles.catalogId', $id);
                }
            })
            -> where('articles.publishedAt', '<=', date('Y-m-d H:i:s'))
            -> orderBy('articles.publishedAt', 'DESC')
            -> paginate(env('ARTICLES_PAGINATION_COUNT'));
        return view('frontend.index', ['articles' => $articles]);
    }
}

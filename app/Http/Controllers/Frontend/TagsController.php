<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\DB;

class TagsController extends FrontendController
{
    public function getTagArticles($id = 0)
    {
        $count = DB::table('tags') -> where('inTrash', 0) -> where('id', $id) -> count();
        if (!$count) {
            return abort(404);
        }
        # 首页文章的显示最大字数是150
        $articles = DB::table('articles')
            -> select(
                'articles.id', 'articles.title', 'articles.abstract as abstractContent', 'articles.thumb', 'users.name',
                'tags.name as tag', 'articles.tagId', 'catalogs.name as catalog', 'articles.catalogId', 'articles.publishedAt'
            )
            -> leftJoin('users', 'users.id', '=', 'articles.authorId')
            -> leftJoin('catalogs', 'catalogs.id', '=', 'articles.catalogId')
            -> leftJoin('tags', 'tags.id', '=', 'articles.tagId')
            -> where('articles.inTrash', 0)
            -> where('articles.tagId', $id)
            -> where('articles.publishedAt', '<=', date('Y-m-d H:i:s'))
            -> orderBy('articles.publishedAt', 'DESC')
            -> paginate(env('ARTICLES_PAGINATION_COUNT'));
        return view('frontend.index', ['articles' => $articles]);
    }
}

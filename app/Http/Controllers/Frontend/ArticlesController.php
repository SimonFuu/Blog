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
            -> where('tags.isDelete', 0)
            -> where('catalogs.isDelete', 0)
            -> where('articles.inTrash', 0)
            -> where('articles.id', $id)
            -> where('articles.publishedAt', '<=', date('Y-m-d H:i:s'))
            -> first();
        if (is_null($article)) {
            abort(404);
        }
        $comments = DB::table('comments')
            -> select('comments.id', 'comments.uId', 'comments.parentCommentId',
                'comments.baseCommentId', 'comments.content', 'users.name', 'users.avatar', 'comments.createdAt',
                DB::raw('IFNULL((SELECT bl_users.name FROM bl_users WHERE bl_users.id = bl_comments.commentToUId and 
                bl_users.isDelete = 0), "") as `to`'))
            -> leftJoin('users', 'users.id', '=', 'comments.uId')
            -> where('comments.isDelete', 0)
            -> where('comments.articleId', $id)
            -> orderBy('comments.createdAt', 'DESC')
            -> get();
        $counts = count($comments);
        $parentComments = [];
        $replays = [];
        if ($counts > 0) {
            foreach ($comments as $comment) {
                if ($comment -> baseCommentId == 0) {
                    $parentComments[] = $comment;
                } else {
                    if (isset($replays[$comment -> baseCommentId])) {
                        array_unshift($replays[$comment -> baseCommentId], $comment);
                    } else {
                        $replays[$comment -> baseCommentId][] = $comment;
                    }
                }
            }
            foreach ($parentComments as $comment) {
                if (isset($replays[$comment -> id])) {
                    $comment -> replays = $replays[$comment -> id];
                } else {
                    $comment -> replays = null;
                }
            }
        }
        $article -> nextArticle = $this -> getNextArticle($article -> publishedAt);
        $article -> prevArticle = $this -> getPrevArticle($article -> publishedAt);
        return view('frontend.article',
            ['article' => $article, 'comments' => $parentComments, 'commentCount' => $counts]);
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
            -> orderBy('publishedAt', 'DESC')
            -> first();
    }
}

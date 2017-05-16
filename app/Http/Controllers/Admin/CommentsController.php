<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CommentsController extends Controller
{
    public function commentsList(Request $request)
    {
        $comments = DB::table('comments')
            -> select(
                'comments.id as cId',
                'comments.content',
                'articles.id as aId',
                'articles.title',
                'users.name',
                'users.id as uId',
                'comments.createdAt'
            )
            -> leftJoin('users', 'users.id', '=', 'comments.uId')
            -> leftJoin('articles', 'articles.id', '=', 'comments.articleId')
            -> where(function ($query) use ($request) {
                $query -> where('comments.inTrash', 0);
                $query -> where('articles.inTrash', 0);
                if ($request -> has('title')) {
                    $query -> where('articles.title', 'like', '%' . $request -> title . '%');
                }
                if ($request -> has('comment')) {
                    $query -> where('comments.content', 'like', '%' . $request -> comment . '%');
                }
                if ($request -> has('name')) {
                    $query -> where('users.name', 'like', '%' . $request -> name . '%');
                }
            })
            -> orderBy('comments.createdAt', 'DESC')
            -> paginate(15);
        $defaults = $this -> getSearchConditions($request);
        return view('admin.comments.list', ['comments' => $comments, 'defaults' => $defaults]);
    }

    public function deleteComment($cId = 0)
    {
        $comment = DB::table('comments')
            -> select('uId', 'path')
            -> where('inTrash', 0)
            -> where('id', $cId)
            -> first();
        if (is_null($comment)) {
            return redirect() -> back() -> with('error', '您要删除的评论不存在');
        } else {
            $path = $comment -> path == '0' ? '/' . $cId : $comment -> path . '/' . $cId;
            DB::table('comments')
                -> where('id', $cId)
                -> orWhere('path', 'like', $path . '%')
                -> update(['inTrash' => 1]);
            return redirect() -> back() -> with('success', '评论删除成功！');
        }
    }
}

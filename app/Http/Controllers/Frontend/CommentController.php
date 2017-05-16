<?php

namespace App\Http\Controllers\Frontend;

use App\Jobs\SendCommentsNotifyEmailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Log;

class CommentController extends FrontendController
{

    public function __construct()
    {
        $this -> middleware('user');
    }

    public function store(Request $request)
    {
        $data = $request -> except(['_token', '_url']);
        $data['uId'] = Auth::user() -> id;
        if (isset($data['parentCommentId'])) {
            $parentComment = DB::table('comments')
                -> select('id', 'uId', 'parentCommentId', 'baseCommentId', 'path', 'emailMe', 'articleId')
                -> where('inTrash', 0)
                -> where('id', $data['parentCommentId'])
                -> first();
            if (is_null($parentComment)) {
                return redirect() -> back() -> with('error', '评论失败！您要回复的评论不存在！');
            } else {
                $data['commentToUId'] = $parentComment -> uId;
                $data['baseCommentId'] = $parentComment -> baseCommentId == '0' ?
                    $parentComment -> id : $parentComment -> baseCommentId;
                $data['path'] = $parentComment -> path == '0' ?
                    '/' . $parentComment -> id : $parentComment -> path . '/' . $parentComment -> id;
                if ($parentComment -> emailMe) {
                    $toUser = DB::table('users') -> select('email') -> where('inTrash', 0)
                        -> where('id', $parentComment -> uId) -> first();
                    $fromUser = DB::table('users') -> select('name') -> where('inTrash', 0)
                        -> where('id', $data['uId']) -> first();
                    $article = DB::table('articles') -> select('id', 'title') -> where('inTrash', 0)
                        -> where('id', $data['articleId']) -> first();
                    if (!is_null($toUser) && !is_null($article) && !is_null($fromUser)) {
                        dispatch((new SendCommentsNotifyEmailJob(
                            $toUser -> email, $fromUser -> name, $article -> title, $article -> id, $data['content']
                        )) -> onQueue('SendMail'));
                    }
                }
            }
        }
        DB::table('comments')
            -> insert($data);
        return redirect() -> back() -> with('success', '发布评论成功！');
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
            if (Auth::user() -> roleId > 0 || $comment -> uId == Auth::user() -> id) {
                $path = $comment -> path == '0' ? '/' . $cId : $comment -> path . '/' . $cId;
                DB::table('comments')
                    -> where('id', $cId)
                    -> orWhere('path', 'like', $path . '%')
                    -> update(['inTrash' => 1]);
                return redirect() -> back() -> with('success', '评论删除成功！');
            } else {
                return redirect() -> back() -> with('error', '您暂无权限删除该条评论！');
            }
        }
    }
}

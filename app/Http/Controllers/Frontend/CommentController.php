<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;

class CommentController extends Controller
{

    public function __construct()
    {
        $this -> middleware('user');
    }

    public function store(Request $request)
    {
        $data = $request -> except('_token');
        $data['uId'] = Auth::user() -> id;
        if (isset($data['parentCommentId'])) {
            $parentComment = DB::table('comments')
                -> select('id', 'uId', 'parentCommentId', 'baseCommentId', 'path')
                -> where('isDelete', 0)
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
            }
        }
        DB::table('comments')
            -> insert($data);
        return redirect() -> back();
    }

    public function deleteComment($cId = 0)
    {
        $comment = DB::table('comments')
            -> select('uId', 'path')
            -> where('isDelete', 0)
            -> where('id', $cId)
            -> first();
        if (is_null($comment)) {
            return redirect() -> back() -> with('error', '您要删除的评论不存在');
        } else {
            if (Auth::user() -> roleId <= 1 || $comment -> uId == Auth::user() -> id) {
                $path = $comment -> path == '0' ? '/' . $cId : $comment -> path . '/' . $cId;
                DB::table('comments')
                    -> where('id', $cId)
                    -> orWhere('path', 'like', $path . '%')
                    -> update(['isDelete' => 1]);
                return redirect() -> back() -> with('success', '评论删除成功！');
            } else {
                return redirect() -> back() -> with('error', '您暂无权限删除该条评论！');
            }
        }
    }
}

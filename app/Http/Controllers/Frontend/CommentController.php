<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{

    public function __construct()
    {
        $this -> middleware('user');
    }

    public function store(Request $request)
    {
        $data = $request -> except('_token');
        DB::table('comments')
            -> insert($data);
        return redirect() -> back();
    }
}

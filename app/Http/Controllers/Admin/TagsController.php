<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TagsController extends Controller
{
    public function tagsList()
    {
        $tags = DB::table('tags')
            -> select('id', 'name',
                DB::raw('(SELECT count(a.id) FROM bl_articles as a 
                WHERE a.inTrash = 0 AND a.tagId = bl_tags.id) as articlesCount'))
            -> where('inTrash', 0)
            -> get();
        return view('admin.contents.tags.list', ['tags' => $tags]);
    }
}

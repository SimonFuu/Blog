<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CatalogsController extends Controller
{
    public function catalogsList()
    {
        $catalogs = DB::table('catalogs')
            -> select('id', 'name', 'displayWeight',
                DB::raw('(SELECT count(a.id) FROM bl_articles as a 
                WHERE a.inTrash = 0 AND a.catalogId = bl_catalogs.id) as articlesCount'))
            -> where('inTrash', 0)
            -> get();
        return view('admin.contents.catalogs.list', ['catalogs' => $catalogs]);
    }
}

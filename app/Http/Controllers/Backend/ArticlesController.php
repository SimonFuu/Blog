<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticlesController extends Controller
{
    public function articlesList()
    {
        return view('backend.index');
    }

    public function addForm()
    {
        return view('backend.index');
    }
}

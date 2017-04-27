<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class IndexController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
}

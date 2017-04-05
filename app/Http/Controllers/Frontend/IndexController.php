<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class IndexController extends Controller
{
    public function index()
    {
        # 首页文章的显示最大字数是185
        $archives = [
            (object) ['id' => 1, 'author' => '管理员', 'createdAt' => time(), 'catalog' => 'PHP', 'tag' => 'aaa', 'title' => 'title1', 'thumb' => 'https://ss2.baidu.com/6ONYsjip0QIZ8tyhnq/it/u=282319352,3101119549&fm=170&s=410228B860E75FB544302B480300C0F2&w=494&h=301&img.JPEG', 'content' => 'content'],
            (object) ['id' => 1, 'author' => '管理员', 'createdAt' => time(), 'catalog' => 'PHP', 'tag' => 'aaa', 'title' => 'title1', 'thumb' => 'https://ss2.baidu.com/6ONYsjip0QIZ8tyhnq/it/u=282319352,3101119549&fm=170&s=410228B860E75FB544302B480300C0F2&w=494&h=301&img.JPEG', 'content' => 'content'],
            (object) ['id' => 1, 'author' => '管理员', 'createdAt' => time(), 'catalog' => 'PHP', 'tag' => 'aaa', 'title' => 'title1', 'thumb' => 'https://ss2.baidu.com/6ONYsjip0QIZ8tyhnq/it/u=282319352,3101119549&fm=170&s=410228B860E75FB544302B480300C0F2&w=494&h=301&img.JPEG', 'content' => 'content'],
            (object) ['id' => 1, 'author' => '管理员', 'createdAt' => time(), 'catalog' => 'PHP', 'tag' => 'aaa', 'title' => 'title1', 'thumb' => 'https://ss2.baidu.com/6ONYsjip0QIZ8tyhnq/it/u=282319352,3101119549&fm=170&s=410228B860E75FB544302B480300C0F2&w=494&h=301&img.JPEG', 'content' => 'content'],
            (object) ['id' => 1, 'author' => '管理员', 'createdAt' => time(), 'catalog' => 'PHP', 'tag' => 'aaa', 'title' => 'title1', 'thumb' => 'https://ss2.baidu.com/6ONYsjip0QIZ8tyhnq/it/u=282319352,3101119549&fm=170&s=410228B860E75FB544302B480300C0F2&w=494&h=301&img.JPEG', 'content' => 'content'],
            (object) ['id' => 1, 'author' => '管理员', 'createdAt' => time(), 'catalog' => 'PHP', 'tag' => 'aaa', 'title' => 'title1', 'thumb' => 'https://ss2.baidu.com/6ONYsjip0QIZ8tyhnq/it/u=282319352,3101119549&fm=170&s=410228B860E75FB544302B480300C0F2&w=494&h=301&img.JPEG', 'content' => 'content'],
        ];
        return view('frontend.index', ['archives' => $archives]);
    }
}

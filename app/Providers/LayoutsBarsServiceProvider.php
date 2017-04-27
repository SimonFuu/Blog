<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\ServiceProvider;

class LayoutsBarsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        if(strpos($request -> getPathInfo(), '/admin') === false) {
            view() -> composer('frontend.layouts.widgets.sidebar', function ($view) {
                $view -> with('tags', $this -> getTags());
                $view -> with('articles', $this -> getRecommendArticle());
                $view -> with('ads', $this -> getAds());
                $view -> with('comments', $this -> getRecentComments());
                $view -> with('links', $this -> getFriendlyLinks());
            });
            view() -> composer('frontend.layouts.widgets.navigation', function($view) use ($request) {
                $view -> with('catalogs', $this -> getFrontendCatalog());
                $view -> with('uri', $request -> getPathInfo());
            });
        } else {
            $tmpPaths = explode('/', $request -> getPathInfo());
            $path = [];
            foreach ($tmpPaths as $tmpPath) {
                if ($tmpPath != '') {
                    $path[] = $tmpPath;
                }
            }
            $requestPath = '/';
            if (isset($path[1])) {
                $menu = $path[1];
                $requestPath .= $path[1];
                for($i = 2; $i < count($path); $i++) {
                    $requestPath .= '/' . $path[$i];
                }
            } else {
                $menu = 'index';
                $requestPath = '/';
            }
            view() -> composer('admin.layouts.widgets.header', function ($view) use ($menu) {
                $view -> with('catalogs', $this -> getAdminMenus('index'));
                $view -> with('uri', '/' . ($menu == 'index' ? '' : $menu));
            });
            view() -> composer('admin.layouts.widgets.sidebar', function ($view) use ($menu, $requestPath){
                $view -> with('menus', $this -> getAdminMenus($menu));
                $view -> with('url', $requestPath);
            });
        }

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    private function getFrontendCatalog()
    {
        $catalogs = Redis::get('CATALOGS');
        if (!$catalogs) {
            $catalogs = DB::table('catalogs')
                -> select('id', 'name')
                -> where('publishedAt', '<=', date('Y-m-d H:i:s'))
                -> where('isDelete', 0)
                -> orderBy('displayWeight' , 'ASC')
                -> get();
            Redis::set('CATALOGS', $catalogs);
        } else {
            $catalogs = json_decode($catalogs);
        }
        return $catalogs;
    }

    private function getTags()
    {
        return DB::table('tags')
            -> select('id', 'name', 'articlesCount')
            -> where('isDelete', 0)
            -> get();
    }

    private function getRecommendArticle()
    {
        return DB::table('recommend_articles')
            -> select('articles.id', 'articles.title')
            -> leftJoin('articles', 'articles.id', '=', 'recommend_articles.articleId')
            -> where('recommend_articles.isDelete', 0)
            -> where('articles.isDelete', 0)
            -> where('articles.publishedAt', '<=', date('Y-m-d H:i:s'))
            -> orderBy('recommend_articles.displayWeight', 'DESC')
            -> limit(env('ARTICLES_RECOMMEND_COUNT'))
            -> get();
    }

    private function getAds()
    {
        return [];
    }

    private function getRecentComments()
    {
        $comments = DB::table('comments')
            -> select('users.avatar', 'users.name', 'comments.articleId', 'comments.content',
                DB::raw('UNIX_TIMESTAMP(bl_comments.createdAt) as createdAt'), 'articles.title')
            -> leftJoin('users', 'users.id', '=', 'comments.uId')
            -> leftJoin('articles', 'articles.id', '=', 'comments.articleId')
            -> orderBy('comments.createdAt', 'DESC')
            -> where('comments.isDelete', 0)
            -> where('users.isDelete', 0)
            -> where('articles.isDelete', 0)
            -> limit(10)
            -> get();
        if (count($comments) != 0) {
            $now = time();
            foreach ($comments as $comment) {
                $comment -> createdAt = $this -> dateTimeFormat($now, $comment -> createdAt);
                $comment -> title = mb_strlen($comment -> title) > 10 ?
                    sprintf('%s...', mb_substr($comment -> title, 0, 10)) : $comment -> title;
                $comment -> content = mb_strlen($comment -> content) > 30 ?
                    sprintf('%s...', mb_substr($comment -> content, 0, 30)) : $comment -> content;
            }
        }
        return $comments;
    }

    private function getFriendlyLinks()
    {
        return DB::table('friendly_links')
            -> select('name', 'link')
            -> where('status', 1)
            -> where('isDelete', 0)
            -> orderBy('displayWeight', 'DESC')
            -> get();
    }

    private function dateTimeFormat($now = 0, $timestamp = 0)
    {
        $offset = $now - $timestamp;
        if ($offset >= 604800) {
            return date('Y-m-d H:i:s');
        } elseif ($offset >= 86400) {
            return sprintf('%s天前', floor($offset / 86400));
        } elseif ($offset >= 3600) {
            return sprintf('%s小时前', floor($offset / 3600));
        } elseif ($offset >= 60) {
            return sprintf('%s分钟前', floor($offset / 60));
        } else {
            return '刚刚';
        }
    }

    private function getAdminMenus($menu = '')
    {
        $menus = [
            'index' =>  [
                (object)['name' => '首页', 'icon' => 'fa-home', 'url' => '/', 'submenus' => []],
                (object)['name' => '内容管理', 'icon' => 'fa-list', 'url' => '/articles', 'submenus' => []],
                (object)['name' => '评论管理', 'icon' => 'fa-comments', 'url' => '/comments', 'submenus' => []],
                (object)['name' => '用户管理', 'icon' => 'fa-users', 'url' => '/users', 'submenus' => []],
                (object)['name' => '&nbsp;回收站', 'icon' => 'fa-trash', 'url' => '/trash', 'submenus' => []],
                (object)['name' => '网站设置', 'icon' => 'fa-cogs', 'url' => '/settings', 'submenus' => []],
            ],
            'articles' => [
                (object)['name' => '文章管理', 'icon' => 'fa-list', 'url' => '/articles', 'submenus' => [
                    (object)['name' => '文章列表', 'icon' => 'fa-left', 'url' => '/articles'],
                    (object)['name' => '发布文章', 'icon' => 'fa-left', 'url' => '/articles/add']
                ]],
                (object)['name' => '栏目管理', 'icon' => 'fa-list-alt', 'url' => '/catalogs', 'submenus' => [
                    (object)['name' => '栏目列表', 'icon' => 'fa-left', 'url' => '/catalogs'],
                    (object)['name' => '添加栏目', 'icon' => 'fa-left', 'url' => '/catalogs/add']
                ]],
                (object)['name' => '标签管理', 'icon' => 'fa-tags', 'url' => '/tags', 'submenus' => [
                    (object)['name' => '标签列表', 'icon' => 'fa-left', 'url' => '/tags'],
                    (object)['name' => '添加标签', 'icon' => 'fa-left', 'url' => '/tags/add']
                ]],
            ]
        ];
        return isset($menus[$menu]) ? $menus[$menu] : [];
    }
}

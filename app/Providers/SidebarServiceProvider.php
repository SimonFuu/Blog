<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class SidebarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view() -> composer('frontend.layouts.widgets.sidebar', function ($view) {
            $view -> with('tags', $this -> getTags());
            $view -> with('articles', $this -> getRecommendArticle());
            $view -> with('ads', $this -> getAds());
            $view -> with('comments', $this -> getRecentComments());
            $view -> with('links', $this -> getFriendlyLinks());
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

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
        return [
            (object) ['avatar' => 'http://qzapp.qlogo.cn/qzapp/101206152/D4DDDC8FDB84389D261134E5506A5F47/100', 'nickname' => '测试1', 'time' => '1天前', 'comment' => '测试评论内容', 'articleId' => 1, 'articleTitle' => '测试'],
            (object) ['avatar' => 'http://qzapp.qlogo.cn/qzapp/101206152/D4DDDC8FDB84389D261134E5506A5F47/100', 'nickname' => '测试2', 'time' => '2天前', 'comment' => '测试评论内容', 'articleId' => 1, 'articleTitle' => '测试'],
            (object) ['avatar' => 'http://qzapp.qlogo.cn/qzapp/101206152/D4DDDC8FDB84389D261134E5506A5F47/100', 'nickname' => '测试3', 'time' => '3天前', 'comment' => '测试评论内容', 'articleId' => 1, 'articleTitle' => '测试'],
            (object) ['avatar' => 'http://qzapp.qlogo.cn/qzapp/101206152/D4DDDC8FDB84389D261134E5506A5F47/100', 'nickname' => '测试4', 'time' => '4天前', 'comment' => '测试评论内容', 'articleId' => 1, 'articleTitle' => '测试'],
            (object) ['avatar' => 'http://qzapp.qlogo.cn/qzapp/101206152/D4DDDC8FDB84389D261134E5506A5F47/100', 'nickname' => '测试5', 'time' => '5天前', 'comment' => '测试评论内容', 'articleId' => 1, 'articleTitle' => '测试'],
            (object) ['avatar' => 'http://qzapp.qlogo.cn/qzapp/101206152/D4DDDC8FDB84389D261134E5506A5F47/100', 'nickname' => '测试6', 'time' => '6天前', 'comment' => '测试评论内容', 'articleId' => 1, 'articleTitle' => '测试'],
        ];
    }

    private function getFriendlyLinks()
    {
        return [
            (object) ['link' => 'http://www.baidu.com', 'title' => '测试1'],
            (object) ['link' => 'http://www.baidu.com', 'title' => '测试2'],
            (object) ['link' => 'http://www.baidu.com', 'title' => '测试3'],
            (object) ['link' => 'http://www.baidu.com', 'title' => '测试4'],
            (object) ['link' => 'http://www.baidu.com', 'title' => '测试5'],
            (object) ['link' => 'http://www.baidu.com', 'title' => '测试6'],
            (object) ['link' => 'http://www.baidu.com', 'title' => '测试7'],
        ];
    }
}

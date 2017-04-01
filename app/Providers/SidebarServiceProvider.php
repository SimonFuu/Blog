<?php

namespace App\Providers;

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
            $view -> with('archives', $this -> getRecommendArchive());
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
        return [
            (object) ['id' => 1, 'name' => '11', 'archiveCount' => rand(1,10)],
            (object) ['id' => 2, 'name' => '测试2', 'archiveCount' => rand(1,10)],
            (object) ['id' => 3, 'name' => '测试3', 'archiveCount' => rand(1,10)],
            (object) ['id' => 4, 'name' => '测试4', 'archiveCount' => rand(1,10)],
            (object) ['id' => 5, 'name' => '测试5', 'archiveCount' => rand(1,10)],
        ];
    }

    private function getRecommendArchive()
    {
        return [
            (object) ['id' => '1', 'title' => '测试的001'],
            (object) ['id' => '2', 'title' => '测试的002'],
            (object) ['id' => '3', 'title' => '测试的003'],
            (object) ['id' => '4', 'title' => '测试的004'],
            (object) ['id' => '5', 'title' => '测试的005'],
        ];
    }

    private function getAds()
    {
        return [];
    }

    private function getRecentComments()
    {
        return [
            (object) ['avatar' => 'http://qzapp.qlogo.cn/qzapp/101206152/D4DDDC8FDB84389D261134E5506A5F47/100', 'nickname' => '测试1', 'time' => '1天前', 'comment' => '测试评论内容', 'archiveId' => 1, 'archiveTitle' => '测试'],
            (object) ['avatar' => 'http://qzapp.qlogo.cn/qzapp/101206152/D4DDDC8FDB84389D261134E5506A5F47/100', 'nickname' => '测试2', 'time' => '2天前', 'comment' => '测试评论内容', 'archiveId' => 1, 'archiveTitle' => '测试'],
            (object) ['avatar' => 'http://qzapp.qlogo.cn/qzapp/101206152/D4DDDC8FDB84389D261134E5506A5F47/100', 'nickname' => '测试3', 'time' => '3天前', 'comment' => '测试评论内容', 'archiveId' => 1, 'archiveTitle' => '测试'],
            (object) ['avatar' => 'http://qzapp.qlogo.cn/qzapp/101206152/D4DDDC8FDB84389D261134E5506A5F47/100', 'nickname' => '测试4', 'time' => '4天前', 'comment' => '测试评论内容', 'archiveId' => 1, 'archiveTitle' => '测试'],
            (object) ['avatar' => 'http://qzapp.qlogo.cn/qzapp/101206152/D4DDDC8FDB84389D261134E5506A5F47/100', 'nickname' => '测试5', 'time' => '5天前', 'comment' => '测试评论内容', 'archiveId' => 1, 'archiveTitle' => '测试'],
            (object) ['avatar' => 'http://qzapp.qlogo.cn/qzapp/101206152/D4DDDC8FDB84389D261134E5506A5F47/100', 'nickname' => '测试6', 'time' => '6天前', 'comment' => '测试评论内容', 'archiveId' => 1, 'archiveTitle' => '测试'],
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

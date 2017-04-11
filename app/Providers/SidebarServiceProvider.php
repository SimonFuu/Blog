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
}

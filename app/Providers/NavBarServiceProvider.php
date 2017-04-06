<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\ServiceProvider;

class NavBarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        view() -> composer('frontend.layouts.widgets.navigation', function($view) use ($request) {
            $view -> with('catalogs', $this -> getCatalogs());
            $view -> with('uri', $request -> getPathInfo());
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function getCatalogs()
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
}

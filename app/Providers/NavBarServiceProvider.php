<?php

namespace App\Providers;

use Illuminate\Http\Request;
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
            $menus = $this -> getMenus();
            foreach ($menus as $menu) {
                if ($menu -> url == $request -> getRequestUri()) {
                    $menu -> active = true;
                } else {
                    $menu -> active = false;
                }
            }
            $view -> with('menus', $menus);
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

    private function getMenus()
    {
        return [
            (object) ['name' => '菜单1', 'url' => '/'],
            (object) ['name' => '菜单2', 'url' => '/n'],
            (object) ['name' => '菜单3', 'url' => '/h'],
            (object) ['name' => '菜单4', 'url' => '/a'],
        ];
    }
}

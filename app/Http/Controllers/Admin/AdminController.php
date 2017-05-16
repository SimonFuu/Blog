<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 16/05/2017
 * Time: 6:37 PM
 * https://www.fushupeng.com
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected function getSearchConditions(Request $request)
    {
        $default = [];
        $pagination = [];
        $req = $request -> except(['_token', '_url']);
        foreach ($req as $key => $value) {
            if (!is_null($value)) {
                $default[$key] = $value;
                $pagination[$key] = $value;
            }
        }
        return ['default' => $default, 'pagination' => $pagination];
    }
}

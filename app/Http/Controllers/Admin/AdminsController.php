<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminsController extends Controller
{
    public function adminInfo($id = 0)
    {
        $user = DB::table('users')
            -> select('users.id', 'users.username', 'users.name', 'users.email', 'users.avatar', 'roles.name')
            -> leftJoin('roles', 'roles.id', '=', 'users.roleId')
            -> where('users.inTrash', 0)
            -> where('roles.isDelete', 0)
            -> where('users.id', $id)
            -> first();
        if (is_null($user)) {
            return abort(404);
        }

        $oauth = DB::table('oauth')
            -> select('source')
            -> where('inTrash', 0)
            -> where('uId', $id)
            -> get();

        $r = DB::table('roles')
            -> select('id', 'name')
            -> where('inTrash', 0)
            -> get();
        $roles = [];
        if (count($r) > 0) {
            foreach ($r as $v) {
                $roles[$v -> id] = $v -> name;
            }
        }
        $user -> oauth = $oauth;
        dd($user);
        return view('admin.admins.info', ['user' => $user, 'roles' => $roles]);
    }
}

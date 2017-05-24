<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountsController extends AdminController
{
    public function usersList(Request $request)
    {
        $users = DB::table('users')
            -> select('users.id', 'users.username', 'users.name', 'users.email', 'users.createdAt', 'roles.name as rName')
            -> leftJoin('roles', 'roles.id', 'users.roleId')
            -> where(function ($query) use ($request) {
                $query -> where('users.inTrash', 0);
                $query -> where('roles.inTrash', 0);
                if ($request -> has('name')) {
                    $query -> where('users.name', 'like', '%' . $request -> name . '%');
                }
                if ($request -> has('email')) {
                    $query -> where('users.email', $request -> email);
                }
                if ($request -> has('role')) {
                    $query -> where('users.roleId', $request -> role);
                }
            })
            -> paginate(15);
        $roles = $this -> getUserRoles();
        $defaults = $this -> getSearchConditions($request);
        return view('admin.accounts.users.list', ['users' => $users, 'roles' => $roles, 'defaults' => $defaults]);
    }

    public function userForm($id = 0)
    {
        $user = DB::table('users')
            -> select('id', 'username', 'name', 'email', 'roleId')
            -> where('inTrash', 0)
            -> where('id', $id)
            -> first();
        if (is_null($user) && $id != 0) {
            abort(404);
        }
        $roles = $this -> getUserRoles();
        return view('admin.accounts.users.add', ['roles' => $roles, 'user' => $user]);
    }

    public function storeUser(Request $request)
    {
        $roles = [
            'username' => 'required|max:32|unique:users,username' . (isset($request -> id) ? ',' . $request -> id : ''),
            'name' => 'required|max:32',
            'email' => 'required|email|unique:users,email' . ( isset($request -> id)? ',' . $request -> id : ''),
            'roleId' => 'required|exists:roles,id,inTrash,0',
            'password' => 'required_without:id|' .
                (isset($request -> password) && !is_null($request -> password) ? 'min:6' : '') .
                '|max:32|confirmed',
            'id' => 'sometimes|exists:users,id,inTrash,0'
        ];
        $message = [
            'username.required' => '请输入用户名！',
            'username.max' => '用户名长度不能超过32！',
            'username.unique' => '该用户名已存在！',
            'name.required' => '请输入姓名！',
            'name.max' => '姓名长度不能超过32！',
            'email.required' => '请输入用户名！',
            'email.email' => '请输入合法的Email地址！',
            'email.unique' => '该邮箱地址已经存在！',
            'roleId.required' => '请选择用户角色！',
            'roleId.exists' => '用户角色ID不存在！',
            'password.required_without' => '请输入密码！',
            'password.min' => '密码长度不能小于6！',
            'password.max' => '密码长度不能超过32！',
            'password.confirmed' => '两次输入的密码不一致！',
            'id.exists' => '该用户不存在！',
        ];
        $this -> validate($request, $roles, $message);
        $data = $request -> except(['_url', '_token', 'password_confirmation']);
        if (is_null($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }
        if (isset($request -> id)) {
            try {
                DB::table('users') -> where('id', $request -> id) -> update($data);
                return redirect('/admin/accounts/users') -> with('success', '更新用户信息成功！');
            } catch (\Exception $e) {
                return redirect() -> back() -> with('error', '更新用户信息失败！Message: ' . $e -> getMessage());
            }
        } else {
            try {
                DB::table('users') -> insert($data);
                return redirect('/admin/accounts/users') -> with('success', '添加用户成功！');
            } catch (\Exception $e) {
                return redirect() -> back() -> with('error', '添加用户失败！Message: ' . $e -> getMessage());
            }
        }
    }

    private function getUserRoles()
    {
        $r = [];
        $roles = DB::table('roles')
            -> select('id', 'name')
            -> where('inTrash', 0)
            -> get();
        if (count($roles) > 0) {
            foreach ($roles as $role) {
                $r[$role -> id] = $role -> name;
            }
        }
        return $r;
    }
}

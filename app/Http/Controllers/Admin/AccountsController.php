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

    public function deleteUser($id = 0)
    {
        DB::table('users') -> where('id', $id) -> update(['inTrash' => 1, 'roleId' => 0]);
        return redirect('/admin/accounts/users') -> with('success', '已将用户移至回收站！(后台权限已收回)');
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

    public function rolesList(Request $request)
    {
        $roles = DB::table('roles')
            -> select(
                'roles.id',
                'roles.name',
                'roles.description',
                DB::raw('(select COUNT(bl_users.id) from bl_users 
                where bl_users.roleId = bl_roles.id and bl_users.inTrash = 0) as usersCount'),
                'roles.createdAt'
            )
            -> where(function ($query) use ($request) {
                $query -> where('roles.inTrash', 0);
                $query -> where('roles.id', '>', 0);
                if ($request -> has('role')) {
                    $query -> where('roles.id', $request -> role);
                }
            })
            -> paginate(15);
        $allRoles = $this -> getUserRoles();
        unset($allRoles[0]);
        $default = $this -> getSearchConditions($request);
        return view('admin.accounts.roles.list', ['rolesList' => $roles, 'roles' => $allRoles, 'defaults' => $default]);
    }

    public function roleUsers($id = 0)
    {
        if ($id == 0) {
            abort(404);
        }
        $role = DB::table('roles')
            -> select('name', 'description')
            -> where('id', $id)
            -> where('inTrash', 0)
            -> first();
        $users = DB::table('users')
            -> select('id', 'name')
            -> where('inTrash', 0)
            -> where('roleId', $id)
            -> get();
        return view('admin.accounts.roles.users', ['role' => $role, 'users' => $users]);
    }

    public function deleteRoleUsers(Request $request)
    {
        if (!$request -> has('id')) {
            return redirect() -> back() -> with('error', '请提供用户ID');
        }
        DB::beginTransaction();
        try {
            if (is_array($request -> id)) {
                DB::table('users')
                    -> whereIn('id', $request -> id)
                    -> update(['roleId' => 0]);

            } else {
                DB::table('users')
                    -> where('id', $request -> id)
                    -> update(['roleId' => 0]);
            }
            DB::commit();
            return redirect('/admin/accounts/roles') -> with('success', '已收回用户后台权限！');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/admin/accounts/roles') -> with('error', '处理失败，错误信息：' . $e -> getMessage());
        }
    }

    public function deleteRole($id = 0)
    {
        DB::beginTransaction();
        try {
            DB::table('users') -> where('roleId', $id) -> update(['roleId' => 0]);
            DB::table('roles') -> where('id', $id) -> update(['inTrash' => 1]);
            DB::commit();
            return redirect('/admin/accounts/roles') -> with('success', '角色已删除，已收回该角色下所有用户的后台权限！');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/admin/accounts/roles') -> with('error', '处理失败，错误信息：' . $e -> getMessage());
        }
    }
}

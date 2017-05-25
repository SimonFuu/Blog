@extends('admin.layouts.common')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/admin/accounts/roles">用户管理</a></li>
        <li><a href="/admin/accounts/roles">后台角色管理</a></li>
        <li class="active">后台角色列表</li>
    </ol>
@endsection
@section('content')
    <div class="search-header">
        {!! Form::open(['url' => '/admin/accounts/roles', 'method' => 'GET', 'class' => 'form-inline', 'role' => 'form']) !!}
        <!-- class include {'form-horizontal'|'form-inline'} -->
            <!--- Role Field --->
            <div class="form-group">
                {!! Form::label('role', '角色:') !!}
                {!! Form::select('role', $roles, isset($defaults['default']['role']) ? $defaults['default']['role'] : null,
                    ['class' => 'form-control', 'placeholder' => '请选择']) !!}
            </div>
            <button class="btn btn-primary">查询</button>
        {!! Form::close() !!}
    </div>
    <hr>
    <table class="table table-bordered table-striped table-hover table-condensed">
        <thead>
        <tr>
            <th style="width: 100px">
                角色名
            </th>
            <th style="width: 100px">
                描述
            </th>
            <th style="width: 100px">
                用户数量
            </th>
            <th style="width: 100px">
                创建时间
            </th>
            <th style="width: 50px">
                操作
            </th>
        </tr>
        </thead>
        <tbody>
            @foreach($rolesList as $role)
                <tr>
                    <td>
                        {{ $role -> name }}
                    </td>
                    <td>
                        {{ $role -> description }}
                    </td>
                    <td>
                        <a href="/admin/accounts/roles/users/edit/{{ $role -> id }}" title="编辑用户">
                            <i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;{{ $role -> usersCount }}
                        </a>
                    </td>
                    <td>
                        {{ $role -> createdAt }}
                    </td>
                    <td>
                        <a href="/admin/accounts/roles/edit/{{ $role -> id }}" title="编辑"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a href="/admin/accounts/roles/delete/{{ $role -> id }}" title="删除"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pull-right">
        {{ $rolesList -> appends(is_null($defaults['pagination']) ? null : $defaults['pagination']) -> links() }}
    </div>
@endsection
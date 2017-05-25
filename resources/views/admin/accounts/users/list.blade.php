@extends('admin.layouts.common')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/admin/accounts/users">用户管理</a></li>
        <li class="active">用户列表</li>
    </ol>
@endsection
@section('content')
    <div class="search-header">
        {!! Form::open(['url' => '/admin/accounts/users', 'method' => 'GET', 'class' => 'form-inline', 'role' => 'form']) !!}
        <!-- class include {'form-horizontal'|'form-inline'} -->
            <!--- Name Field --->
            <div class="form-group">
                {!! Form::label('name', '用户昵称:', ['class' => 'control-label']) !!}
                {!! Form::text('name', isset($defaults['default']['name']) ? $defaults['default']['name'] : null,
                    ['class' => 'form-control']) !!}
            </div>
            <!--- Email Field --->
            <div class="form-group">
                {!! Form::label('email', '用户邮箱:') !!}
                {!! Form::email('email', isset($defaults['default']['email']) ? $defaults['default']['email'] : null,
                    ['class' => 'form-control']) !!}
            </div>
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
                用户名
            </th>
            <th style="width: 100px">
                昵称
            </th>
            <th style="width: 100px">
                邮箱
            </th>
            <th style="width: 50px">
                角色
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
            @foreach($users as $user)
                <tr>
                    <td>
                        {{ $user -> username }}
                    </td>
                    <td>
                        {{ $user -> name }}
                    </td>
                    <td>
                        {{ $user -> email }}
                    </td>
                    <td>
                        {{ $user -> rName }}
                    </td>
                    <td>
                        {{ $user -> createdAt }}
                    </td>
                    <td>
                        <a href="/admin/accounts/users/edit/{{ $user -> id }}" title=""><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a href="/admin/accounts/users/delete/{{ $user -> id }}" title="删除"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pull-right">
        {{ $users -> appends(is_null($defaults['pagination']) ? null : $defaults['pagination']) -> links() }}
    </div>
@endsection
@extends('admin.layouts.common')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/system/roles">系统管理</a></li>
        <li><a href="/system/roles">系统角色管理</a></li>
        <li class="active">角色用户</li>
    </ol>
@endsection
@section('content')
    <div class="search-header form-inline">
        <div class="form-group">
            {!! Form::label('role', '角色名:', ['class' => 'control-label']) !!}
            {!! Form::text('role', isset($role -> name) ? $role -> name : null,
                ['class' => 'form-control', 'placeholder' => '角色名', 'readonly']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('email', '角色描述:') !!}
            {!! Form::text('role', isset($role -> description) ? $role -> description : null,
            ['class' => 'form-control', 'placeholder' => '角色描述', 'readonly']) !!}
        </div>
        <div class="form-group">
            <a href="/admin/accounts/roles/users/delete/" class="btn btn-danger delete-role-users">删除</a>
        </div>
        <div class="form-group select-all">
            <!--- 全选 Field --->
            <label for="select-all">
                <input type="checkbox" name="select-all" id="select-all">
                &nbsp;全选
            </label>
        </div>
    </div>
    <hr>
    <div class="rows list-table actions-list">
        @foreach($users as $user)
            <div class="col-sm-2">
                <table class="table table-bordered table-striped table-hover table-condensed">
                    <tbody>
                        <tr>
                            <td>
                                @if($user -> id == 1)
                                    <label for="user" class="role-users">
                                        &nbsp;
                                        {{ $user -> name }}
                                    </label>
                                @else
                                    <label for="user-{{ $user -> id }}" class="role-users">
                                        <input type="checkbox" name="user[]" id="user-{{ $user -> id }}" class="user-id" value="{{ $user -> id }}">
                                        &nbsp;
                                        {{ $user -> name }}
                                    </label>
                                    <span class="pull-right">
                                        <a href="/admin/accounts/roles/users/delete/?id={{ $user -> id }}" class="delete-role-user" title="删除">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
@endsection
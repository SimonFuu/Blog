@extends('admin.layouts.common')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/admin/accounts/users">用户管理</a></li>
        <li><a href="/admin/accounts/users">用户列表</a></li>
        <li class="active">{{ is_null($user) ? '添加' : '编辑'}}用户</li>
    </ol>
@endsection
@section('content')
    {!! Form::open(['url' => '/admin/accounts/users/store', 'method' => 'post', 'class' => 'form-horizontal', 'role' => 'form']) !!}
    <!-- class include {'form-horizontal'|'form-inline'} -->
        <!--- Username Field --->
        <div class="form-group {{ $errors -> has('username') ? 'has-error' : ''}}">
            {!! Form::label('username', '用户名:', ['class' => 'control-label col-md-1']) !!}
            <div class="col-md-3">
                {!! Form::text('username', is_null($user) ? null : $user -> username, ['class' => 'form-control', is_null($user) ? '' :'readonly', 'placeholder' => '用户名']) !!}
            </div>
            @if($errors -> has('username'))
                <div class="col-md-5">
                    <span class="help-block">
                        <strong>{{ $errors -> first('username') }}</strong>
                    </span>
                </div>
            @endif
        </div>
        <!--- Name Field --->
        <div class="form-group {{ $errors -> has('name') || $errors -> has('id') ? 'has-error' : ''}}">
            {!! Form::label('name', '姓名:', ['class' => 'control-label col-md-1']) !!}
            <div class="col-md-3">
                {!! Form::text('name', is_null($user) ? null : $user -> name, ['class' => 'form-control', 'placeholder' => '姓名']) !!}
            </div>
            @if($errors -> has('name'))
                <div class="col-md-5">
                    <span class="help-block">
                        <strong>{{ $errors -> first('name') }}</strong>
                    </span>
                </div>
            @elseif($errors -> has('id'))
                <div class="col-md-5">
                    <span class="help-block">
                        <strong>{{ $errors -> first('id') }}</strong>
                    </span>
                </div>
            @endif
        </div>
        <!--- RoleId Field --->
        <div class="form-group {{ $errors -> has('roleId') ? 'has-error' : ''}}">
            {!! Form::label('roleId', '角色:', ['class' => 'control-label col-md-1']) !!}
            <div class="col-md-3">
                {!! Form::select('roleId', $roles, is_null($user) ? null : $user -> roleId, ['class' => 'form-control', 'placeholder' => '请选择']) !!}
            </div>
            @if($errors -> has('roleId'))
                <div class="col-md-5">
                    <span class="help-block">
                        <strong>{{ $errors -> first('username') }}</strong>
                    </span>
                </div>
            @endif
        </div>
        <!--- Email Field --->
        <div class="form-group {{ $errors -> has('email') ? 'has-error' : ''}}">
            {!! Form::label('email', '邮箱:', ['class' => 'control-label col-md-1']) !!}
            <div class="col-md-3">
                {!! Form::email('email', is_null($user) ? null : $user -> email, ['class' => 'form-control', 'placeholder' => '邮箱']) !!}
            </div>
            @if($errors -> has('email'))
                <div class="col-md-5">
                    <span class="help-block">
                        <strong>{{ $errors -> first('email') }}</strong>
                    </span>
                </div>
            @endif
        </div>
        <!--- Password Field --->
        <div class="form-group {{ $errors -> has('password') ? 'has-error' : ''}}">
            {!! Form::label('password', '密码:', ['class' => 'control-label col-md-1']) !!}
            <div class="col-md-3">
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => '密码']) !!}
            </div>
            @if($errors -> has('password'))
                <div class="col-md-5">
                    <span class="help-block">
                        <strong>{{ $errors -> first('password') }}</strong>
                    </span>
                </div>
            @endif
        </div>
        <!--- Password_confirmation Field --->
        <div class="form-group {{ $errors -> has('password') ? 'has-error' : ''}}">
            {!! Form::label('password_confirmation', '确认密码:', ['class' => 'control-label col-md-1']) !!}
            <div class="col-md-3">
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => '确认密码']) !!}
            </div>
            @if($errors -> has('password'))
                <div class="col-md-5">
                    <span class="help-block">
                        <strong>{{ $errors -> first('password') }}</strong>
                    </span>
                </div>
            @endif
        </div>
        <div class="col-md-offset-1 submit-buttons">
            <button class="btn btn-primary" type="submit">提交</button>
            <a href="/admin/accounts/users" class="btn btn-default">返回</a>
        </div>
        @if(!is_null($user))
            <div class="form-group hidden">
                {!! Form::hidden('id', $user -> id, ['class' => 'form-control']) !!}
            </div>
        @endif
    {!! Form::close() !!}
@endsection
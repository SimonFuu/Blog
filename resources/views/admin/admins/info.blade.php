@extends('admin.layouts.common')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#">个人中心</a></li>
        <li class="active">用户信息</li>
    </ol>
@endsection

@section('content')
    {!! Form::open(['url' => '/admin/admins/store', 'method' => 'post', 'class' => 'form-horizontal', 'role' => 'form']) !!}
    <!-- class include {'form-horizontal'|'form-inline'} -->

    <!--- Username Field --->
    <div class="form-group {{ $errors -> has('username') || $errors -> has('id') ? 'has-error' : ''}}">
        {!! Form::label('username', '姓名:', ['class' => 'control-label col-md-1']) !!}
        <div class="col-md-4">
            {!! Form::text('title', $user -> username, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-4">
            <span class="help-block">
                <strong>
                    @if($errors -> has('username'))
                        {{ $errors -> first('username') }}
                    @elseif($errors -> has('id'))
                        {{ $errors -> first('id') }}
                    @endif
                </strong>
            </span>
        </div>
    </div>


    <div class="col-md-offset-2 submit-buttons">
        <button class="btn btn-primary" type="submit">提交</button>
    </div>
    {!! Form::close() !!}
@endsection
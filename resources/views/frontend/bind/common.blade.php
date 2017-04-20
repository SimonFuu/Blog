@extends('frontend.layouts.layouts')
@section('body')
    <div class="container">
        <div class="user-bind-page-header">
            LOGO
        </div>
        <div class="module user-bind-page-body">
            @yield('bind-body')
        </div>
    </div>
@endsection

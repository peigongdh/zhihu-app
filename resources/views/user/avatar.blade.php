@extends('layouts.app')

@section('content')
    <div class="container">
        @include('user.setting_nav')
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">修改头像</div>
                    <div class="panel-body">
                        <user-avatar avatar="{{ user()->avatar }}"></user-avatar>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

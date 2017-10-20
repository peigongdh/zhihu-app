@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">控制面板</div>

                    <div class="panel-body">
                        @if(user()->is_active)
                            您已登录！
                        @else
                            请验证邮箱
                            {{ Auth::logout() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

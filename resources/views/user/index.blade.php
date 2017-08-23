@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">个人资料</h3>
                </div>

                <div class="panel-body">
                    <div class="media">
                        <div class="media-left">
                            <a>
                                <img width="48" class="media-object" src="{{ $user->avatar }}"
                                     alt="{{ $user->name }}">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">
                                {{ $user->name }}
                            </h4>
                        </div>
                    </div>
                </div>

                <ul class="list-group">
                    <li class="list-group-item">现居城市：{{ $user->settings['city'] }}</li>
                    <li class="list-group-item">简介：{{ $user->settings['bio'] }}</li>
                </ul>
            </div>
        </div>
    </div>
    <action-pagination user_id="{{ $user->id }}"></action-pagination>
@endsection

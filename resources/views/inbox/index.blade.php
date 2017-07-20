@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">消息通知</div>
                    <div class="panel-body">
                        @foreach($messages as $dialogId => $messageGroup)
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        @if (Auth::id() == $messageGroup->first()->toUser->id )
                                            <img width="48" src="{{ $messageGroup->first()->fromUser->avatar }}" alt="">
                                        @else
                                            <img width="48" src="{{ $messageGroup->first()->toUser->avatar }}" alt="">
                                        @endif
                                    </a>
                                </div>
                                <div class="media-body {{ $messageGroup->first()->shouldAddUnreadClass() ? 'unread' : '' }}">
                                    <h4 class="media-heading">
                                        <a href="#">
                                            @if (Auth::id() == $messageGroup->first()->toUser->id)
                                                {{ $messageGroup->first()->fromUser->name }}
                                            @else
                                                {{ $messageGroup->first()->toUser->name }}
                                            @endif
                                        </a>
                                    </h4>
                                    <p>
                                        <a href="/index/{{ $dialogId }}">
                                            {{ $messageGroup->first()->body }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

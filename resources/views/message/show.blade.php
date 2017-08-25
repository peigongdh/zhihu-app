@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">对话列表</div>
                    <div class="panel-body">
                        <form action="/message/{{ $dialogId }}/reply" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <textarea name="body" class="form-control"></textarea>
                            </div>
                            <div class="form-group pull-right">
                                <button class="btn btn-success">回复私信</button>
                            </div>
                        </form>
                        <div class="message-list">
                            @foreach($messages as $message)
                                <div class="media">
                                    <div class="media-left">
                                        <a href="{{ route('user', ['id' => $message->fromUser->id]) }}">
                                            <img width="48" src="{{ $message->fromUser->avatar }}" alt="">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            <a href="{{ route('user', ['id' => $message->fromUser->id]) }}">
                                                {{ $message->fromUser->name }}
                                            </a>
                                        </h4>
                                        <p>
                                            {{ $message->body }}
                                        </p>
                                    </div>
                                    <small class="pull-right">
                                        {{ $message->created_at->format('Y-m-d H:i:s') }}
                                    </small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

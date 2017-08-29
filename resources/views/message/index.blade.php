@extends('layouts.app')

@section('content')
    <message-pagination :user_id="{{ Auth::id() }}"></message-pagination>
@endsection

@extends('layouts.app')

@section('content')
    <question-pagination topic="{{ isset($topic) ?: 0 }}"></question-pagination>
@endsection

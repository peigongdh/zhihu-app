@extends('layouts.app')

@section('content')
    <timeline-pagination topic="{{ isset($topic) ?: 0 }}"></timeline-pagination>
@endsection

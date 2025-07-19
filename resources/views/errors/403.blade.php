@extends('web.layouts.master')

@section('title', '403 Forbidden')

@section('content')
<div class="container text-center" style="margin-top: 100px;">
    <h1>403</h1>
    <h2>{{ __('web.forbidden') }}</h2>
    <p>{{ __('web.unauthorized_access') }}</p>
    <a href="{{ route('home') }}" class="btn btn-primary mt-3">{{ __('web.go_home') }}</a>
</div>
@endsection 
@extends('layouts.app')

@section('locale')
@foreach (config('app.available_locales') as $locale)
<li class="nav-item">
    <a class="nav-link" href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), $locale["value"]) }}">
        {{ strtoupper($locale["name"]) }}
    </a>
</li>
@endforeach
@endsection

@section('header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 style="color: #fb8c00;">{{__('main.dashboard')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('welcome', app()->getLocale())}}">{{__('main.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('main.dashboard')}}</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div style="text-align: center;color: #fb8c00; ">
        <img src="https://hostadvice.com/wp-content/uploads/2017/08/dimofinf-logo.png " width="30%"
            class="mt-5" style="opacity: .3;">
    </div>
</div>
@endsection

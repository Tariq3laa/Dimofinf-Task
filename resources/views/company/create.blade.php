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

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">{{__('main.add_company')}}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif @if (session('errors'))
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        @foreach (session('errors')->all() as
                        $error)
                        <ul>
                            <li>{{ $error }}</li>
                        </ul>
                        @endforeach
                    </div>
                    @endif
                    <div class="panel-heading">
                        <div class="panel-body">
                            <form method="post" action="{{ route('company.store', app()->getLocale()) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('main.name')}}</label>
                                    <input type="text" name="name" class="form-control" value="{{old('name')}}" />
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('main.email')}}</label>
                                    <input type="text" name="email" class="form-control" value="{{old('email')}}" />
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('main.website_url')}}</label>
                                    <input type="text" name="url" class="form-control" value="{{old('url')}}" />
                                </div>
                                <label for="" class="text-primary">{{__('main.choose_logo')}}</label><input type="file"
                                    name="logo" class="pl-2 mb-3" accept="image/*" />
                                <div class="col text-center">
                                    <input type="submit" value="{{__('main.create')}}" class="btn btn-primary" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

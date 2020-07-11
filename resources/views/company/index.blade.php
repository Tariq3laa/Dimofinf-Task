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
            <h1 style="color: #fb8c00;">{{__('main.companies')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('welcome', app()->getLocale())}}">{{__('main.home')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('main.companies')}}</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <table id="example" class="table table-striped table-bordered ml-5" style="width:100% ">
        <thead>
            <tr class="text-center">
                <th>{{__('main.name')}}</th>
                <th>{{__('main.email')}}</th>
                <th>{{__('main.website_url')}}</th>
                <th>{{__('main.logo')}}</th>
                <th>{{__('main.delete')}}</th>
                <th>{{__('main.update')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($companies as $company)
            <tr class="text-center">
                <td>{{$company->name}}</td>
                <td>{{$company->email}}</td>
                <td>{{$company->url}}</td>
                <td><img src="{{asset('storage/'.$company->logo)}}" style="height: 50px;" alt=""></td>
                <td>
                    <a class="btn"
                        href="{{ route('company.destroy', ['locale' => app()->getLocale(), 'company' => $company]) }}"
                        onclick="event.preventDefault();
                        document.getElementById('delete-form').submit();">
                        <i class="fas fa-trash" style="color: #fb8c00; font-size: 30px;"></i>
                        <form id="delete-form"
                            action="{{ route('company.destroy', ['locale' => app()->getLocale(), 'company' => $company]) }}"
                            method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </a>
                </td>
                <td>
                    <a class="btn"
                        href="{{ route('company.edit', ['locale' => app()->getLocale(), 'company' => $company]) }}">
                        <i class="fas fa-user-edit"style="color: #fb8c00; font-size: 30px;"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
        @if (count($companies) > 0)
        <tfoot>
            <tr>
                <td colspan="6">
                    {{ $companies->links() }}
                </td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>
@endsection

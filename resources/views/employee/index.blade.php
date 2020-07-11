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
            <h1 style="color: #fb8c00;">{{__('main.employees')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('welcome', app()->getLocale())}}">{{__('main.home')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('main.employees')}}</li>
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
                <th>{{__('main.first_name')}}</th>
                <th>{{__('main.last_name')}}</th>
                <th>{{__('main.company')}}</th>
                <th>{{__('main.email')}}</th>
                <th>{{__('main.phone')}}</th>
                <th>{{__('main.delete')}}</th>
                <th>{{__('main.update')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            @if ($employee->company != null)
            <tr class="text-center">
                <td>{{$employee->first_name}}</td>
                <td>{{$employee->last_name}}</td>
                <td>{{$employee->company->name}}</td>
                <td>{{$employee->email}}</td>
                <td>{{$employee->phone}}</td>
                <td>
                    <a class="btn"
                        href="{{ route('employee.destroy', ['locale' => app()->getLocale(), 'employee' => $employee]) }}"
                        onclick="event.preventDefault();
                        document.getElementById('delete-form').submit();">
                        <i class="fas fa-trash" style="color: #fb8c00; font-size: 30px;"></i>
                        <form id="delete-form"
                            action="{{ route('employee.destroy', ['locale' => app()->getLocale(), 'employee' => $employee]) }}"
                            method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </a>
                </td>
                <td>
                    <a class="btn"
                        href="{{ route('employee.edit', ['locale' => app()->getLocale(), 'employee' => $employee]) }}">
                        <i class="fas fa-user-edit"style="color: #fb8c00; font-size: 30px;"></i>
                    </a>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
        @if (count($employees) > 0)
        <tfoot>
            <tr>
                <td colspan="7">
                    {{ $employees->links() }}
                </td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>
@endsection

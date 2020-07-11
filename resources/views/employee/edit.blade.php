@extends('layouts.app')

@section('locale')
@foreach (config('app.available_locales') as $locale)
<li class="nav-item">
    <a class="nav-link"
        href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), ['locale' => $locale["value"], 'employee' => $employee]) }}">
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
                <div class="card-header text-center">{{__('main.update_employee')}}</div>
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
                            <form method="post" action="{{ route('employee.update',['locale' => app()->getLocale(), 'employee' => $employee]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('main.first_name')}}</label>
                                    <input type="text" name="first_name" class="form-control"
                                        value="{{$employee->first_name}}" />
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('main.last_name')}}</label>
                                    <input type="text" name="last_name" class="form-control"
                                        value="{{$employee->last_name}}" />
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('main.email')}}</label>
                                    <input type="text" name="email" class="form-control"
                                    value="{{$employee->email}}" />
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('main.phone')}}</label>
                                    <input type="text" name="phone" class="form-control"
                                    value="{{$employee->phone}}" />
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">{{__('main.select_company')}}</label>
                                    <select class="form-control" name="company_id">
                                        <option disabled selected>{{__('main.select_company')}}</option>
                                        @foreach ($companies as $company)
                                            <option value="{{$company->id}}">{{$company->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col text-center">
                                    <input type="submit" value="{{__('main.update')}}" class="btn btn-primary" />
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

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ __('main.app_name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{asset('css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style type="text/css">
        body {
            font-family: "Lucida Sans Unicode", "Lucida Grande",
                "HacenJordan", "Hacen Digital Arabia", sans-serif;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('welcome', app()->getLocale())}}" class="nav-link">{{__('main.home')}}</a>
                </li>
            </ul>

            @guest
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ route('login', app()->getLocale()) }}">{{ __('main.login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ route('register', app()->getLocale()) }}">{{ __('main.register') }}</a>
                </li>
                @endif
            </ul>
            @else
            <ul class="navbar-nav ml-auto">
                <li>
                    <a class="btn" href="{{ route('logout', app()->getLocale()) }}"
                        style="color: #fb8c00;font-size: 15px;" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{__('main.logout')}} <i class="fas fa-sign-out-alt"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST"
                        style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
            @endguest

        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{route('welcome', app()->getLocale())}}" class="brand-link">
                <img src="https://hostadvice.com/wp-content/uploads/2017/08/dimofinf-logo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light" style="color: #fb8c00;">Management</span>
            </a>

            <div class="sidebar">
                @auth
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <span style="color: white;" class="d-block">{{auth()->user()->name}}</span>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    {{__('main.our_data')}}
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                <a href="{{route('company.create', app()->getLocale())}}" class="nav-link">
                                        <p>{{__('main.add_company')}}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('company.index', app()->getLocale())}}" class="nav-link">
                                        <p>{{__('main.companies')}}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('company.trashed', app()->getLocale())}}" class="nav-link">
                                        <p>{{__('main.deleted_companies')}}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('employee.create', app()->getLocale())}}" class="nav-link">
                                        <p>{{__('main.add_employee')}}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('employee.index', app()->getLocale())}}" class="nav-link">
                                        <p>{{__('main.employees')}}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('employee.trashed', app()->getLocale())}}" class="nav-link">
                                        <p>{{__('main.deleted_employees')}}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                @endauth

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    {{__('main.languages')}}
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @yield('locale')
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                @yield('header')
            </section>

            <section class="content">
                @yield('content')
            </section>

            <aside class="control-sidebar control-sidebar-dark">
            </aside>
        </div>
        <!-- jQuery -->
        <script src="{{asset('js/jquery.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset('js/adminlte.min.js')}}"></script>
</body>

</html>

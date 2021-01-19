<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Toolpisco</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Favicons -->
    <link href="../template/img/favicon.png" rel="icon">
    <link href="../template/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/skins/_all-skins.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">

    {{-- Select2 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
    {{--
    <link rel="stylesheet" href="/path/to/select2.css">
    <link rel="stylesheet" href="/path/to/select2-bootstrap4.css"> --}}

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

    <!-- Data tables Bootstrap 3 -->
    {{--
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.bootstrap.min.css">
    --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.bootstrap.min.css" />


    {{-- Sweet alert --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">

    {{-- Toastr --}}
    {{--
    <link rel="stylesheet" href="../assets/toastr/toastr.css"> --}}
    <link rel="stylesheet" href="../assets/toastr/toastr.min.css">

    {{-- Full Calendar --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.min.css">

    {{-- daterangeTime --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    {{-- Slider --}}
    {{--
    <link rel="stylesheet" href="../assets/range-slider-master/css/rSlider.min.css"> --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/8.0.0/css/bootstrap-slider.min.css">


    <link rel="stylesheet" href="../css/loading-spinner.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">


    @yield('css')
</head>

<body class="skin-purple-light sidebar-mini">


    @if (!Auth::guest())
        <div class="wrapper">

            <div class="loading" id="loading-spinner" style="display: none;">Loading&#8230;</div>
            {{-- <div class="loader"  id="loading-spinner" style="display: block"></div> --}}
            <!-- Main Header -->
            <header class="main-header">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="logo">
                    <span class="logo-mini"><img src="../img/logo-sm.png" /></span>
                    <span class="logo-lg"><img style="width: 140px" src="../img/logoorilloblanco.png"></span>

                </a>

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            {{-- Notificaciones --}}
                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell"></i>
                                    @if (count(Auth::user()->unreadNotifications) > 0)
                                        <span
                                            class="label label-warning">{{ count(Auth::user()->unreadNotifications) }}</span>
                                    @endif
                                </a>

                                <ul class="dropdown-menu">
                                    @if (count(Auth::user()->unreadNotifications) > 0)
                                        <li class="header"> {{ count(Auth::user()->unreadNotifications) }} nuevas
                                            notificacione(s)
                                        </li>
                                        <li>
                                            @foreach (Auth::user()->unreadNotifications as $key => $notification)
                                                <!-- inner menu: contains the actual data -->
                                                @if ($notification->type == 'App\Notifications\ActividadAsignada')
                                                    <ul class="menu">
                                                        <li>
                                                            <a id="readNotification" data-id="{{ $notification->id }}"
                                                                href="/actividades/{{ $notification->data['id'] }}">
                                                                <i class="mr-3 pull-left fa fa-calendar text-red"></i>
                                                                Nueva actividad | {{ $notification->data['titulo'] }}

                                                                <small
                                                                    class="ml-3 pull-right">{{ $notification->created_at->diffForHumans() }}</small>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                @endif
                                                @if ($notification->type == 'App\Notifications\ActividadPospuesta')
                                                    <ul class="menu">
                                                        <li>
                                                            <a id="readNotification" data-id="{{ $notification->id }}"
                                                                href="/actividades/{{ $notification->data['id'] }}">
                                                                <i class="mr-3 pull-left fa fa-clock text-red"></i>
                                                                Actividad Pospuesta |
                                                                {{ $notification->data['titulo'] }}

                                                                <small
                                                                    class="ml-3 pull-right">{{ $notification->created_at->diffForHumans() }}</small>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                @endif
                                                @if ($notification->type == 'App\Notifications\NuevoComportamiento')
                                                    <ul class="menu">
                                                        <li>
                                                            <a id="readNotification" data-id="{{ $notification->id }}"
                                                                href="/comportamientos/{{ $notification->data['id'] }}">
                                                                <i class="mr-3 pull-left fa fa-file-text text-red"></i>
                                                                Nuevo Comportamiento |
                                                                {{ $notification->data['titulo'] }}

                                                                <small
                                                                    class="ml-3 pull-right">{{ $notification->created_at->diffForHumans() }}</small>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                @endif
                                                @if ($notification->type == 'App\Notifications\NuevoAvances')
                                                    <ul class="menu">
                                                        <li>
                                                            <a id="readNotification" data-id="{{ $notification->id }}"
                                                                href="/comportamientos/{{ $notification->data['id'] }}">
                                                                <i class="mr-3 pull-left fa fa-file-text text-red"></i>
                                                                Nuevo Avances | {{ $notification->data['titulo'] }}

                                                                <small
                                                                    class="ml-3 pull-right">{{ $notification->created_at->diffForHumans() }}</small>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                @endif
                                                <!-- ------------------------------------ -->
                                            @endforeach
                                        </li>
                                        <li class="footer"><a href="{{ route('markAsRead') }}">Marcar como leidas</a>
                                        </li>
                                    @endif

                                    {{-- @if (count(Auth::user()->readNotifications) > 0)
                                        <li class="header">Notificaciones leidas
                                        </li>
                                    @endif
                                    <li>

                                        @foreach (Auth::user()->readNotifications as $key => $notification)
                                            <!-- inner menu: contains the actual data -->
                                            @if ($notification->type == 'App\Notifications\ActividadAsignada')
                                                <ul class="menu">
                                                    <li>
                                                        <a href="/actividades/{{ $notification->data['id'] }}">
                                                            <i class="mr-3 pull-left fa fa-calendar text-red"></i>
                                                            Nueva actividad | {{ $notification->data['titulo'] }}

                                                            <small
                                                                class="ml-3 pull-right">{{ $notification->created_at->diffForHumans() }}</small>
                                                        </a>
                                                    </li>
                                                </ul>
                                            @endif

                                            @if ($notification->type == 'App\Notifications\NuevoComportamiento')
                                                <ul class="menu">
                                                    <li>
                                                        <a href="{{ url('/comportamientos') }}">
                                                            <i class="mr-3 pull-left fa fa-file-text text-red"></i>
                                                            Nuevo Comportamiento | {{ $notification->data['titulo'] }}

                                                            <small
                                                                class="ml-3 pull-right">{{ $notification->created_at->diffForHumans() }}</small>
                                                        </a>
                                                    </li>
                                                </ul>
                                            @endif
                                            <!-- ------------------------------------ -->
                                        @endforeach
                                    </li> --}}
                                </ul>

                            </li>

                            <!-- User Account Menu -->
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- The user image in the navbar-->
                                    <img src="../img/perfil.png" style="background-color: #fff;" class="user-image"
                                        alt="User Image" />
                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <span class="hidden-xs">{!! Auth::user()->name !!}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        <img src="../img/perfil.png" style="background-color: #fff;" class="img-circle"
                                            alt="User Image" />
                                        <p>
                                            {!! Auth::user()->name !!}
                                            <small>Member since {!! Auth::user()->created_at->format('M. Y') !!}</small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="{!!  url('/profile') !!}"
                                                class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{!!  url('/logout') !!}" class="btn btn-default btn-flat"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Salir
                                            </a>
                                            <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                                style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </nav>
            </header>

            <!-- Left side column. contains the logo and sidebar -->
            @include('layouts.sidebar')
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
            </div>

            <!-- Main Footer -->
            <footer class="main-footer" style="max-height: 100px;text-align: center">
                <strong> Todos los derechos reservados © 2020
            </footer>

        </div>
    @else
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{!!  url('/') !!}">
                        InfyOm Generator
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><a href="{!!  url('/home') !!}">Home</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        <li><a href="{!!  url('/login') !!}">Login</a></li>
                        <li><a href="{!!  url('/register') !!}">Register</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    @endif

    @yield('scripts')


</body>

</html>

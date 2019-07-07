<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>
        @section('title')
        | CLUB
        @show
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.styles')
    @yield('styles')
<style type="text/css">
    .logo_header_text{
        color: #fff !important;
        margin-top: 10px !important;
    }
</style>

<body class="skin-josh">
<header class="header">
    <a href="{{ route('home') }}" class="logo">
       <h3 class="logo_header_text">Club</h3>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <div>
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <div class="responsive_nav"></div>
            </a>
        </div>
        <div class="navbar-right toggle">
            <ul class="nav navbar-nav  list-inline">
                <li class=" nav-item dropdown user user-menu">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <img src="{{ asset('assets/images/authors/no_avatar.jpg') }}" alt="img" height="35px" width="35px" class="rounded-circle img-fluid float-left"/>
                        <div class="riot">
                            <div>
                                <p class="user_name_max">{{ Auth::user()->name }}</p>
                                <span>
                                        <i class="caret"></i>
                                    </span>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <img src="{{ asset('assets/images/authors/no_avatar.jpg') }}" alt="img" height="35px" width="35px" class="rounded-circle img-fluid float-left"/>
                            
                            <p class="topprofiletext">{{ Auth::user()->name }}</p>
                        </li>
                        <li role="presentation"></li>
                        @if(app('impersonate')->isImpersonating())
                            <li>
                                <a href="{{ URL::to('logout-other-user') }}">
                                    <i class="livicon" data-name="sign-out" data-s="18"></i>
                                    Logout from {{ Auth::user()->name }}
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ URL::to('logout') }}">
                                <i class="livicon" data-name="sign-out" data-s="18"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="wrapper ">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side ">
        <section class="sidebar ">
            <div class="page-sidebar  sidebar-nav">
                <div class="nav_icons">

                </div>
                <div class="clearfix"></div>
                <!-- BEGIN SIDEBAR MENU -->
                @include('layouts.menu')
                <!-- END SIDEBAR MENU -->
            </div>
        </section>
    </aside>
    <aside class="right-side">
         @yield('content')
    </aside>
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top"
   data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>
@include('layouts.scripts')
@include('layouts.notification')
@yield('scripts')
</body>
</html>

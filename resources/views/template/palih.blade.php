@php
if(session('login')) {
  $userData = ADHhelper::getUserData();
}
@endphp

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <!-- Twitter meta-->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="@@pratikborsadiya">
    <meta property="twitter:creator" content="@@pratikborsadiya">
    <!-- Open Graph Meta-->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Vali Admin">
    <meta property="og:title" content="Vali - Free Bootstrap 4 admin theme">
    <meta property="og:url" content="http://pratikborsadiya.in/blog/vali-admin">
    <meta property="og:image" content="http://pratikborsadiya.in/blog/vali-admin/hero-social.png">
    <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <title>Blank Page - Vali Admin</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript">
      var baseUrl = '{{url('/')}}';
    </script>
    <style type="text/css">
      .vld-overlay.is-full-page {
          z-index: 1051 !important;
      }
    </style>
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('storage/assets')}}/palih/css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="{{asset('storage/assets')}}/font-awesome/css/font-awesome.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body class="app sidebar-mini rtl">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="{{url('/')}}">Vali</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="page-user.html"><i class="fa fa-user fa-lg"></i> Profile</a></li>
            <li><a class="dropdown-item" href="page-login.html"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image">
        <div>
          <p class="app-sidebar__user-name">John Doe</p>
          <p class="app-sidebar__user-designation">Frontend Developer</p>
        </div>
      </div>
      <ul class="app-menu">
        <div id="menu">
          @include('template.menu')
        </div>
      </ul>
    </aside>
    <main class="app-content">
      <div class="app-title">
        <div>
          @yield('title')
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fa fa-home fa-lg"></i></a></li>
          @yield('nav')
        </ul>
      </div>
      <div class="row" id="page">
        <loading :active.sync="isLoading"></loading>
        @yield('content')
      </div>
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="{{asset('storage/assets')}}/palih/js/jquery-3.2.1.min.js"></script>
    <script src="{{asset('storage/assets')}}/palih/js/popper.min.js"></script>
    <script src="{{asset('storage/assets')}}/palih/js/bootstrap.min.js"></script>
    <script src="{{asset('storage/assets')}}/palih/js/main.js"></script>

    <script src="{{ADHhelper::mix('compiled/js/manifest.js')}}"></script>
    <script src="{{ADHhelper::mix('compiled/js/vendor.js')}}"></script>
    @yield('jsbottom')
    <script src="{{ADHhelper::mix('compiled/js/menu.js')}}"></script>
    <script type="text/javascript">
      @if(session('activeMenu'))
      vmenu.activeMenu.push('{{session('activeMenu')}}');
      @endif
    </script>
  </body>
</html>
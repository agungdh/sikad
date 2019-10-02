@php
if(session('login')) {
  $userData = ADHhelper::getUserData();
}
@endphp

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Aplikasi Pengolahan Data Pemilu Pada Kesatuan Bangsa dan Politik Berbasis Web</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <script type="text/javascript">
    var baseUrl = '{{url('/')}}';
  </script>
  <link id="favicon" rel="icon" type="image/x-icon" href="{{asset('storage/assets')}}/logo.ico">

  <link rel="stylesheet" href="{{asset('storage/assets')}}/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('storage/assets')}}/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('storage/assets')}}/AdminLTE/bower_components/Ionicons/css/ionicons.min.css">
  <!-- fullCalendar -->
  <link rel="stylesheet" href="{{asset('storage/assets')}}/AdminLTE/bower_components/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="{{asset('storage/assets')}}/AdminLTE/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('storage/assets')}}/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- SweetAlert -->
  <link rel="stylesheet" href="{{asset('storage/assets')}}/sweetalert/dist/sweetalert.css">

  <link rel="stylesheet" href="{{asset('storage/assets')}}/animate/animate.css">  
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('storage/assets')}}/AdminLTE/bower_components/select2/dist/css/select2.min.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{asset('storage/assets')}}/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Pace style -->
  <link rel="stylesheet" href="{{asset('storage/assets')}}/AdminLTE/plugins/pace/pace.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('storage/assets')}}/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
  <!-- Bootstrap Datetime Picker -->
  <link rel="stylesheet" href="{{asset('storage/assets')}}/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="{{asset('storage/assets')}}/AdminLTE/dist/css/skins/skin-red.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style type="text/css">
    .tulisan_merah {
        color: red !important;
    }
  </style>

  @yield('css')

  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="hold-transition skin-red fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{ route('main.index') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>PML</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>PEMILU</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{asset('storage/assets')}}/logo.png" class="user-image" alt="User Image">
              <span class="hidden-xs">{{$userData->nama}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{asset('storage/assets')}}/logo.png" class="img-circle" alt="User Image">

                <p>
                    {{$userData->username}}
                    <small>{{$userData->level == 'opprov' ? 'Operator Provinsi' : 'Operator Kabupaten'}}</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{route('main.profil')}}" class="btn btn-default">Profil</a>
                </div>
                <div class="pull-right">
                  <a href="{{route('main.logout')}}" class="btn btn-default">Logout</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <div id="menu">
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

          @include('template.menu')

        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
  </div>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @yield('title')
      </h1>
      <ol class="breadcrumb">
        @yield('nav')
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div id="page">
        @yield('content')
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Copyright &copy; {{ date('Y') }} <a href="{{route('main.index')}}">PML</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{asset('storage/assets')}}/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('storage/assets')}}/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- ChartJS -->
<script src="{{asset('storage/assets')}}/AdminLTE/bower_components/chart.js/Chart.js"></script>
<!-- Select2 -->
<script src="{{asset('storage/assets')}}/AdminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- bootstrap datepicker -->
<script src="{{asset('storage/assets')}}/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="{{asset('storage/assets')}}/AdminLTE/bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.id.min.js"></script>
<!-- SweetAlert -->
<script src="{{asset('storage/assets')}}/sweetalert/dist/sweetalert.min.js"></script>
<!-- DataTables -->
<script src="{{asset('storage/assets')}}/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{asset('storage/assets')}}/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- fullCalendar -->
<script src="{{asset('storage/assets')}}/AdminLTE/bower_components/moment/moment.js"></script>
<script src="{{asset('storage/assets')}}/AdminLTE/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="{{asset('storage/assets')}}/AdminLTE/bower_components/fullcalendar/dist/locale/id.js"></script>
<!-- PACE -->
<script src="{{asset('storage/assets')}}/AdminLTE/bower_components/PACE/pace.min.js"></script>
<!-- Slimscroll -->
<script src="{{asset('storage/assets')}}/AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="{{asset('storage/assets')}}/AdminLTE/bower_components/fastclick/lib/fastclick.js"></script>
<!-- Bootstrap Datetime Picker -->
<script src="{{asset('storage/assets')}}/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<!-- Mask Money -->
<script src="{{asset('storage/assets')}}/jqmaskmoney/jquery.maskMoney.min.js"></script>
<script type="text/javascript">
$(function() {
  $('[data-toggle="tooltip"]').tooltip();
  $('.mask_ribuan').maskMoney('mask');
});
$(document).ajaxStart(function () {
  Pace.restart();
})
$('.datatable').DataTable({
  responsive: false,
  "scrollX": true
});
$('.select2').select2();
$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
FastClick.attach(document.body);
$('.datetimepicker').datetimepicker({
    format: 'DD-MM-YYYY HH:mm:ss'
});
$('.datepicker').datetimepicker({
    format: 'DD-MM-YYYY'
});
$('.mask_ribuan').maskMoney({
  thousands:'.',
  decimal: ',',
  precision: 0
});
String.prototype.replaceAll = function(str1, str2, ignore) 
{
    return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
}
Date.prototype.addHours = function(h) {
  this.setTime(this.getTime() + (h*60*60*1000));
  return this;
}
Date.prototype.addMinutes = function(m) {
  this.setTime(this.getTime() + (m*60*1000));
  return this;
}
Date.prototype.addSeconds = function(s) {
  this.setTime(this.getTime() + (s*1000));
  return this;
}
function momentParse(momentObject, format) {
  return momentObject.format(format);
}
function momentParseToDate(momentObject) {
  return momentParse(momentObject, 'YYYY-MM-DD');
}
function momentParseToDateTime(momentObject) {
  return momentParse(momentObject, 'YYYY-MM-DD HH:mm:ss');
}
function getDateTimePickerValue(id) {
  return momentParseToDateTime($("#" + id).data("DateTimePicker").date());
}
function getDatePickerValue(id) {
  return momentParseToDate($("#" + id).data("DateTimePicker").date());
}
</script>
<!-- AdminLTE App -->
<script src="{{asset('storage/assets')}}/AdminLTE/dist/js/adminlte.min.js"></script>
@yield('js')
@if(session('alert'))
<script type="text/javascript">
    swal('{{ session('alert')['title'] }}', '{{ session('alert')['message'] }}', '{{ session('alert')['class'] }}');
</script>
@endif
<script src="{{ADHhelper::mix('compiled/js/manifest.js')}}"></script>
<script src="{{ADHhelper::mix('compiled/js/vendor.js')}}"></script>
@yield('jsvue')
<script src="{{ADHhelper::mix('compiled/js/menu.js')}}"></script>
<script type="text/javascript">
  @if(session('activeMenu'))
  vmenu.{{session('activeMenu')}} = true;
  @endif
</script>
@php
session()->forget('activeMenu');
@endphp
</body>
</html>

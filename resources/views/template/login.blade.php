<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Aplikasi Pengolahan Data Pemilu Pada Kesatuan Bangsa dan Politik Berbasis Web</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link id="favicon" rel="icon" type="image/x-icon" href="{{asset('storage/assets')}}/logo.ico">
  
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('storage/assets')}}/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('storage/assets')}}/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('storage/assets')}}/AdminLTE/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('storage/assets')}}/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- SweetAlert -->
  <link rel="stylesheet" href="{{asset('storage/assets')}}/sweetalert/dist/sweetalert.css">

  <link rel="stylesheet" href="{{asset('storage/assets')}}/animate/animate.css">
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page" style="background-color: green; background-image: url('{{asset("")}}storage/assets/Kesbangpol.jpg'); background-size: cover;">
  <div id="app">

<div class="login-box animated jackInTheBox" style="background-color: red;box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.50); border-radius: 10px; ">
  <div class="login-logo">
    <a href="{{route('main.index')}}"><b style="color: #fff">SELAMAT DATANG</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body" style="">
    <p class="login-box-msg">Aplikasi Pengolahan Data Pemilu Pada Kesatuan Bangsa dan Politik Berbasis Web</p>

    <form action="{{route('main.login')}}" method="post">
      @method('post')
      @csrf
      <div class="form-group has-feedback">
        <input name="username" type="text" class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input name="password" type="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-4 pull-right">
          {{-- <button type="button" @@click="login" class="btn btn-primary btn-block">Login</button> --}}
          <button type="submit" class="btn btn-primary btn-block">Login</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->

</div>
<!-- /.login-box -->
</div>

<!-- jQuery 3 -->
<script src="{{asset('storage/assets')}}/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('storage/assets')}}/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SweetAlert -->
<script src="{{asset('storage/assets')}}/sweetalert/dist/sweetalert.min.js"></script>
@if(session('alert'))
<script type="text/javascript">
    swal('{{ session('alert')['title'] }}', '{{ session('alert')['message'] }}', '{{ session('alert')['class'] }}');
</script>
@endif
{{-- <script src="{{ADHhelper::mix('js/login.js')}}"></script> --}}
</body>
</html>

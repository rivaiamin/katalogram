<!DOCTYPE html>
<html>
  <head>
        <title>.: Katalogram :.</title>
    
        <link rel="icon" href="">
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        
        <link rel="stylesheet" type="text/css" href="{{ elixir('css/admin-css.css') }}">
        
        <link href="/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />


        @yield('head')
  </head>
  <body class="login-page">

    @yield('content')

    <!-- jQuery 2.1.4 -->
    <script src="/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- iCheck -->
    <script src="/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
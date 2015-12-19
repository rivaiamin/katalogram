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


        @yield('head')
    </head>
  <body class="skin-blue sidebar-mini">

    <div class="wrapper">

      <header class="main-header">

    <!-- NAVBAR
    ================================================== -->

        @include('admin.templates.header')

      </header>

      <aside class="main-sidebar">
      
    <!-- SIDEBAR
    ================================================== -->

        @include('admin.templates.aside')

      </aside>


     <!-- CONTENT 
     ================================================= -->
      <div class="content-wrapper">
     
        @yield('content')

      </div>

      <footer class="main-footer">

     <!-- FOOTER 
     ==================================================-->
        @include('admin.templates.footer')
      </footer>

      <aside class="control-sidebar control-sidebar-dark">


     <!-- Control Sidebar 
     ==================================================-->
        @include('admin.templates.controlSidebar')
      
      </aside><!-- /.control-sidebar -->

    </div>

        <script src="{{ elixir('js/admin-js.js') }}"></script>

        <!-- DATA TABES SCRIPT -->
        <script src="/js/admin/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="/js/admin/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
        <!-- SlimScroll -->
        <script src="/js/admin/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <!-- FastClick -->
        <script src='/js/admin/fastclick/fastclick.min.js'></script>
        <!-- AdminLTE App -->
        <script src="/js/admin/app.min.js" type="text/javascript"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="/js/admin/demo.js" type="text/javascript"></script>

        <!-- Page script -->
        @yield('script')

    </body>
</html>
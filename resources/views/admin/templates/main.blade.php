<!DOCTYPE html>
<html>
    <head>
        <title>.: Katalogram :.</title>
    
        <link rel="icon" href="">
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />


        @yield('head')
    </head>
  <body class="skin-blue sidebar-mini">

    <div class="wrapper">


    <!-- NAVBAR
    ================================================== -->

     @include('admin.templates.header')


     <!-- CONTENT 
     ================================================= -->
      <div class="content-wrapper">
     
        @yield('content')

      </div>

     <!-- FOOTER 
     ==================================================-->
     @include('admin.templates.footer')

     <!-- Control Sidebar 
     ==================================================-->
     @include('admin.templates.controlSidebar')

    </div>

        @yield('footer')

    </body>
</html>
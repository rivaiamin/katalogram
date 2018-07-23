@extends('admin.templates.main')

@section('content')

<div  class="heading-bar">
        
    <div class="clearfix">
        <h1 class="float-left"><i class="fa fa-book"></i> User</h1>
        <a href="#" class="btn btn-primary float-right"><i icon class='fa fa-fw fa-plus'></i> Create User</a>
    </div>
</div>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <table id="list-user" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Nama User</th>
            <th>Email</th>
          </tr>
        </thead>

        <tbody>

		@foreach ($user as $users)

          <tr>
            <th>{{$users->user_name}}</th>
            <th>{{$users->email}}</th>
          </tr>

		@endforeach

        </tbody>

        <tfoot>
          <tr>
            <th>Nama User</th>
            <th>Email</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
<section>





@endsection
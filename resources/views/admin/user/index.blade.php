@extends('admin.templates.main')

@section('content')

<div  class="heading-bar">
        
    <div class="clearfix">
        <h1 class="float-left"><i class="fa fa-users"></i> User</h1>
        <a href="{{ route('user.create')}}" class="btn btn-primary float-right"><i icon class='fa fa-fw fa-plus'></i> Create User</a>
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
            <th>Action</th>
          </tr>
        </thead>

        <tbody>

		@foreach ($users as $user)

          <tr>
            <th><a href="{{ route('user.id', $user->id) }}">{{$user->user_name}}</a></th>
            <th>{{$user->email}}</th>
            <th>
              <a href="{{ route('user.id.edit', $user->id) }}" class="btn btn-primary">edit</a>
              <a href="{{ route('user.id.delete', $user->id) }}" class="btn btn-danger">delete</a>
            </th>
          </tr>

		@endforeach

        </tbody>

        <tfoot>
          <tr>
            <th>Nama User</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
<section>





@endsection
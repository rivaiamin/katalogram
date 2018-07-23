@extends('admin.templates.main')

@section('content')

<!-- validation
========================================= -->
@include('errors.list')

<section class="content-header">
  <h1>
    Edit User {{ $user->user_name}}
  </h1>

</section>

<section class="content">

	<div class="row">
	    <div class="col-md-12">
		{!! Form::model($user, ['method' => 'PATCH', 'action' => ['Admin\UserController@update', $user->id]]) !!}

			@include('admin.user.inputForm', ['submitButtonText' => 'Update User'])
	    
		{!! Form::close() !!}
	    </div>



	</div>
</section>

@endsection
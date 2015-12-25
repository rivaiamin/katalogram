@extends('admin.templates.main')

@section('content')

<!-- validation
========================================= -->
@include('errors.list')

<section class="content-header">
  <h1>
    Create New User
  </h1>

</section>

<section class="content">

	<div class="row">
	    <div class="col-md-12">
   		{!! Form::open(['route' => 'user.store']) !!}

			@include('admin.user.inputForm')
		    
		    <div class="form-group">
		        <a href="#" class="btn btn-default pull-left">Cancel</a>
		        {!! Form::submit('Add User', ['class' => 'btn btn-primary pull-right']) !!}
		    </div>
	    
		{!! Form::close() !!}
	    </div>



	</div>
</section>

@endsection
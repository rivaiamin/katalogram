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
	          <div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">User</h3>
	              <div class="box-tools pull-right">
	                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	              </div>
	            </div><!-- /.box-header -->
	            <div class="box-body">

	                <div class="form-group">

	            		{!! Form::label('user_name', 'Name User:') !!}
	            		{!! Form::text('user_name', null, ['class' => 'form-control']) !!}
	
		            </div>

	                <div class="form-group">

	            		{!! Form::label('email', 'Email User:') !!}
	            		{!! Form::email('email', null, ['class' => 'form-control']) !!}
	
		            </div>



	            </div><!-- /.box-body -->
	          </div><!-- /.box -->
		    
		    <div class="form-group">
		        <a href="#" class="btn btn-default pull-left">Cancel</a>
		        {!! Form::submit('Add User', ['class' => 'btn btn-primary pull-right']) !!}
		    </div>
	    
		{!! Form::close() !!}
	    </div>



	</div>
</section>

@endsection
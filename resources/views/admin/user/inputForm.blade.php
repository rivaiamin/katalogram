	          <div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">User</h3>
	              <div class="box-tools pull-right">
	                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	              </div>
	            </div><!-- /.box-header -->
	            <div class="box-body">

	                <div class="form-group">

	            		{!! Form::label('name', 'Name User:') !!}
	            		{!! Form::text('name', null, ['class' => 'form-control']) !!}
	
		            </div>

	                <div class="form-group">

	            		{!! Form::label('email', 'Email User:') !!}
	            		{!! Form::email('email', null, ['class' => 'form-control']) !!}
	
		            </div>



	            </div><!-- /.box-body -->
	          </div><!-- /.box -->
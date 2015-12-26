@if($errors->any())
    <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@elseif(session('flash_message'))
	<diV class="alert alert-success">
		{{ session('flash_message') }}
	</div>
@endif
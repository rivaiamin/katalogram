<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Produk Kreatif {{ $user->name }} </title>
	<meta name="author" content="{{ $user->name }}" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta property="fb:app_id" content="1496399374007633">
	<meta name="google-signin-client_id" content="13356134084-ij596q95of0e79k0qa592btnpo8uvang.apps.googleusercontent.com">
	<base href="/index.html">
	<link rel="shortcut icon" href="{{ $files }}/user/picture/thumb/{{ $user->picture }}" />

	<!--<link rel="stylesheet" type="text/css" href="http://katalogram.dev/css/katalogram.min.css">-->
	<link href="{{ env('APP_URL').'/public/css/kg.user.catalog.min.css' }}" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="ui container uk-margin">
		<div id="catalogList" class="ui five doubling stackable link cards" data-uk-grid>
			<!-- list start -->
			@foreach ($catalogs as $catalog)
			<div class="card uk-text-center">

				<a class="image" href="{{ env('APP_URL').'/catalog/'.$catalog->id.'/view' }}" target="_blank">
				  <div class="ui primary left corner label">
					<i class="kg-icon icon-{{ $categories[$catalog->category_id]->slug }} large icon"></i>
				  </div>
				  @if ($catalog->logo != null)
				  <img src="{{ $files }}/product/logo/{{ $catalog->logo }}">
				  @endif
				  @if ($catalog->logo == null)
				  <div  class="kg-bg-base2 kg-padding">
					<i class="kg-icon icon-{{ $categories[$catalog->category_id]->slug }} inverted massive icon"></i>
				  </div>
				  @endif
				</a>
				<div class="content">
					<div class="kg-heading">
						{{ $catalog->name }}
					</div>
					<div class="ui star large rating" data-rating="3" data-max-rating="5"></div>
					<div><q class="description">
						{{ $catalog->quote }}
					</q></div>

				</div>
				<div class="extra content">
					<span class="left floated like uk-margin-right">
					  <i class="like icon"></i>
					  {{ $catalog->collect_count }}
					</span>
					<span class="right floated">
					  <i class="thumbs down link icon"></i>
					  {{ $catalog->minus_count }}
					</span>
					<span class="right floated uk-margin-right">
					  <i class="thumbs up link icon"></i>
					  {{ $catalog->plus_count }}
					</span>
				</div>
			</div>
			@endforeach
		</div>
	</div>


   <script src="{{ asset('js/export.min.js') }}" type="text/javascript"></script>
   <script> $('.ui.rating').rating(); </script>
</body>
</html>


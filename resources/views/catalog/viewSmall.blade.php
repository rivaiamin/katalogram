<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>.:: katalogram.com (Alpha Version) - Situs Katalogisasi Sosial untuk Ekonomi Kreatif Indonesia ::.</title>
	<meta name="author" content="KarsaKalana" />
	<meta name="description" content="Situs Katalogisasi Sosial (Social Cataloging) untuk Ekonomi Kreatif" />
	<meta name="keyword" content="social cataloging, social, cataloging, site, economy, product, creative, katalogisasi sosial, kreatif, ekonomi, industri, produk, produk kreatif, ekonomi kreatif, industri kreatif, insan kreatif, kreator" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />

	<!--<link rel="stylesheet" type="text/css" href="http://katalogram.dev/css/katalogram.min.css">-->
	<link href="{{ env('APP_URL').'/public/css/export.min.css' }}" rel="stylesheet" type="text/css">
</head>
<body>
   <div class="uk-cover-background uk-position-relative ui image">
		<a class="ui secondary ribbon label uk-text-large"> <i class="kg-icon icon-{{$product->category->slug}}"></i> {{ $product->category->name }}</a>

		<img class="uk-invincible" src="{{ $files }}/product/picture/{{ $product->picture }}" />
	</div>
	<div class="uk-container uk-container-center uk-margin-top">
		<div class="uk-grid uk-grid-small">
			<div class="uk-width-1-1">
				<h2 class="ui header">
				  <img src="{{ $files }}/product/logo/{{ $product->logo }}">
				  <div class="content">
					{{ $product->name }}
					<div class="sub header">{{ $product->quote }}</div>
					<!--<div class="sub header"> </div>-->
				  </div>
				</h2>
			</div>
			<div class="uk-width-2-6">
				<div class="ui horizontal tiny orange statistics">
				  <div class="statistic">
					<div class="value">
					  <i class="heart icon"></i> {{ $product->collect_count }}
					</div>
					<div class="label">
					  Favorit
					</div>
				  </div>
				  <div class="statistic">
					<div class="value">
					  <i class="thumbs up icon"></i> {{ $product->plus_count }}
					</div>
					<div class="label">
					  Plus
					</div>
				  </div>
				  <div class="statistic">
					<div class="value">
					  <i class="thumbs down icon"></i> {{ $product->minus_count }}
					</div>
					<div class="label">
					  Minus
					</div>
				  </div>
				</div>
			</div>
			<div class="uk-width-2-6">
				<input type="text" class="dial" data-min="0" data-max="5" data-width="80%" value="{{$product->rating_avg}}">
			</div>
			<div class="uk-width-2-6">
				<table class="ui unstackable very basic table">
					@foreach ($product->productCriteria as $crit)
					<tr>
						<td>{{ $crit->criteria->name }}</td>
						<td><div class="ui star rating" data-rating="{{$crit->rate_avg}}" data-max-rating="5"></div></td>
					</tr>
					@endforeach
				</table>
			</div>

		</div>
	</div>
	<div class="kg-bg-base" style="height: 105px">
		<div class="uk-container">

			<div class="uk-grid uk-margin-top">
				<div class="uk-width-4-5 uk-margin-top uk-margin-bottom">
					<img src="/img/kg_white.png" alt="" width="40">
					<img src="/img/katalogram.png" alt="" width="100">
				</div>
				<!--<div class="uk-width-3-5">
					<img src="{{$files}}/user/picture/{{ $product->user->picture }}" alt="" class="ui avatar image"> {{ $product->user->name }}
				</div>-->
				<div class="uk-width-1-5">
					<img src="{{ $files.'/product/qrcode/'.$product->id.'.png' }}" width="70" />
				</div>
			</div>
		</div>
	</div>

   <script src="{{ asset('js/export.min.js') }}" type="text/javascript"></script>
</body>
</html>

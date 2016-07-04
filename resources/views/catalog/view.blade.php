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
	<style type="text/css">
		.ui.ribbon.label:after { display: none; }
	</style>
</head>
<body>
   <div class="uk-cover-background uk-position-relative uk-contrast ui image">
		<a class="ui blue ribbon label uk-text-large"> <i class="kg-icon icon-{{$product->category->slug}} inverted"></i> {{ $product->category->name }}</a>
		<img class="uk-invincible" src="{{ $files }}/product/picture/{{ $product->picture }}" height="300" />
		<div class="uk-position-cover uk-flex uk-flex-center uk-flex-bottom" style="padding: 40%; top:-100px">
			<img class="uk-thumbnail uk-border-circle kg-logo-big" src="{{ $files }}/product/logo/{{ $product->logo }}" width="100">
		</div>
	</div>
	<div class="ui compact five item menu kg-font-base uk-margin-remove">
		<a class="item" data-content="tambahkan ke koleksi favorit" kg-popup>
			<i class="red heart link icon"></i> Favorit <span class="ui teal label">{{ $product->collect_count }}</span>
		</a>
		<a class="item" data-content="Total score seluruh kategori" kg-popup>
			<i class="empty star link icon"></i> Rating <span class="ui teal label">{{ $product->rating_avg }}</span>
		</a>
		<a class="item disabled"></a>
		<a class="item" href="#productFeedback" data-content="Berikan tanggapan tentang kelebihan produk" kg-popup>
			<i class="thumbs up outline link icon"></i> Plus <span class="ui teal label">{{ $product->plus_count }}</span>
		</a>
		<a class="item" href="#productFeedback" data-content="Berikan tanggapan tentang kekurangan produk" kg-popup>
			<i class="thumbs down outline link icon"></i> Minus <span class="ui teal label">{{ $product->minus_count }}</span>
		</a>
	</div>
	<div class="uk-container uk-container-center">
		<div class="uk-grid uk-grid-small uk-margin-top uk-text-center">
			<div class="uk-width-1-1 uk-margin-top">
				<h2 class="uk header uk-margin-small-bottom kg-color-base">
				{{ $product->name }}
				</h2>
				<q>{{$product->quote}}</q>
			</div>
			<div class="uk-width-1-1 uk-margin-bottom uk-margin-small-top kg-color-gray">
				@if ($product->user->picture != null)
				<img class="ui avatar image" src="{{$files}}/user/picture/{{ $product->user->picture }}" width="24">
				@endif
				<label><a href="/{{$product->user->name}}">{{ $product->user->name }}</a></label>
			</div>
		</div>
		<div class="uk-grid uk-grid-small uk-grid-collapse">
			<div class="uk-width-2-5">
				<div class="uk-width-1-1 uk-text-center uk-margin-top">
					<!-- <knob knob-data="$product->avg_rate" knob-options="{max:5, width:'100%', height:'100%', readOnly:true }"></knob> -->
					<input type="text" class="dial" data-min="0" data-max="5" value="{{$product->rating_avg}}">
			 </div>
				<div class="uk-width-1-1">
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
			<div class="uk-width-3-5">
				<h3 class="kg-heading"><i class="file text icon"></i> Deskripsi</h3>
				{{$product->desc}}
				<h3 class="kg-heading"><i class="table icon"></i> Data</h3>
				{{$product->data}}
			</div>
		</div>
		<div class="uk-grid uk-grid-divider">
			<div class="uk-width-1-1 uk-text-center">
				<!-- <kg-embedly maxwidth="100%" url="{{ $product->embed }}" apikey="8081dea79e164014bcd7cd7e1ab2363a" style="width:90%"></kg-embedly> -->
				<!--<a href="{{ $product->embed }}" apikey="8081dea79e164014bcd7cd7e1ab2363a" class="embedly-card">Embedly</a>-->
				<span class="ui labeled button" tabindex="0">
					<div class="ui button kg-font-heading">
						<i class="code icon"></i> Konten
					</div>
					<a class="ui basic left pointing label">
						{{ $product->embed }}
					</a>
				</span>
			</div>
			<div class="uk-width-1-1 uk-text-center uk-margin-bottom uk-margin-top">
				@foreach ($product->productTag as $tag)
				<span class="ui tag label teal uk-text-large uk-margin-small-right uk-margin-small-top">
					 {{$tag->tag->name}}
				</span>
				@endforeach
			</div>
			<div id="productFeedback" class="uk-width-1-1 uk-hidden-small uk-margin-bottom">
				<div class="uk-grid-width-1-2 ui two item menu">
				  <a class="item green">
					<i class="thumbs up outline icon"></i>
					<div>Plus <span class="ui label">{{ $product->plus_count }}</span></div>
				  </a>
				  <a class="item red">
					<i class="thumbs down outline icon"></i>
					<div>Minus <span class="ui label">{{ $product->minus_count }}</span></div>
				  </a>
				</div>
			</div>
		</div>
	</div>
	<div class="uk-container-center kg-bg-base">
		<img src="/img/kg_white.png" alt="" width="40">
		<img src="/img/katalogram.png" alt="" width="200">
	</div>

   <script src="{{ asset('js/export.min.js') }}" type="text/javascript"></script>
   <script>
	  /*(function(w, d){
	   var id='embedly-platform', n = 'script';
	   if (!d.getElementById(id)){
	     w.embedly = w.embedly || function() {(w.embedly.q = w.embedly.q || []).push(arguments);};
	     var e = d.createElement(n); e.id = id; e.async=1;
	     e.src = ('https:' === document.location.protocol ? 'https' : 'http') + '://cdn.embedly.com/widgets/platform.js';
	     var s = d.getElementsByTagName(n)[0];
	     s.parentNode.insertBefore(e, s);
	   }
	  })(window, document);*/
	</script>
</body>
</html>

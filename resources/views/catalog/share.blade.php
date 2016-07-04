<!DOCTYPE html>
<html>
	<head>
		<meta name="fb:app_id" content="1496399374007633">
		<meta property="og:title" content="{{ $product->name }}" />
		<meta property="og:description" content="{{ $product->desc }}" />
		<meta property="og:image" content="{{ $files }}/product/logo/{{ $product->logo }}" />
		<meta property="og:image:width" content="256" />
		<meta property="og:image:height" content="256" />
		<meta property="og:url" content="http://katalogram.com/catalog/{{ $product->id }}/view" />
		<!-- etc. -->
	</head>
	<body>
		<p>{{ $product->desc }}</p>
		<img src="{{ $files }}/product/logo/{{ $product->logo }}">
	</body>
</html>

<!DOCTYPE html>
<html>
	<head>
		<meta property="og:title" content="{{ $product->name; }}" />
		<meta property="og:description" content="{{ $product->desc; }}" />
		<meta property="og:image" content="{{ $files }}/product/logo/{{ $product->logo }}" />
		<!-- etc. -->
	</head>
	<body>
		<p>{{ echo $product->desc; }}</p>
		<img src="{{ $files }}/product/logo/{{ $product->logo }}">
	</body>
</html>

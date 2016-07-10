<!DOCTYPE html>
<html>
	<head>
		<meta property="fb:app_id" content="1496399374007633">
		<meta property="og:title" content="{{ $product->name }}" />
		<meta property="og:description" content="{{ $product->desc }}" />
		<meta property="og:image" content="{{ $files }}/product/logo/{{ $product->logo }}" />
		<meta property="og:image:width" content="256" />
		<meta property="og:image:height" content="256" />
		<meta property="og:url" content="http://katalogram.com/catalog/{{ $product->id }}/view" />
		<!-- etc. -->
	</head>
	<body>
		<img id="p2i_demo" src="http://api.page2images.com/directlink?p2i_url=http://katalogram.com/catalog/{{$product->id}}/view&p2i_device=6&p2i_screen=600x0&p2i_size=600x0&p2i_fullpage=1&p2i_imageformat=jpg&p2i_wait=5&p2i_key=f89b84457da1f2c2" />
	</body>
</html>

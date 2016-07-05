<!DOCTYPE html>
<html>
	<head>
		<meta property="fb:app_id" content="1496399374007633">
		<meta property="og:title" content="{{ $category->name }}" />
		<meta property="og:description" content="{{ $category->desc }}" />
		<meta property="og:image:width" content="128" />
		<meta property="og:image:height" content="128" />
		<meta property="og:url" content="http://katalogram.com/category/{{ $category->slug }}/{{ $category->id }}" />
		<!-- etc. -->
	</head>
	<body>
		<p>{{ $category->desc }}</p>
	</body>
</html>

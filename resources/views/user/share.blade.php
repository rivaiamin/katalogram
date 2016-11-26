<!DOCTYPE html>
<html>
	<head>
		<meta property="fb:app_id" content="1496399374007633">
		<meta property="og:title" content="{{ $user->userProfile->fullname }}" />
		<meta property="og:description" content="{{ $user->userProfile->summary }}" />
		<meta property="og:image" content="{{ $files }}/user/picture/{{ $user->picture }}" />
		<meta property="og:image:width" content="256" />
		<meta property="og:image:height" content="256" />
		<meta property="og:url" content="http://katalogram.com/{{ $user->name }}" />
		<!-- etc. -->
	</head>
	<body>
		<h3>{{ $user->userProfile->fullname }}</h3>
		<img src="{{ $files }}/user/picture/{{ $user->picture }}">
		<p>{{ $user->userProfile->profile }}</p>
	</body>
</html>

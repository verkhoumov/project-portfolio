<!DOCTYPE html>

<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">

		<title>{{title}}</title>
		<meta name="description" content="{{description}}">
	
		{{#url}}<meta property="og:url" content= "{{url}}">{{/url}}
		{{#name}}<meta property="og:site_name" content="{{name}}">{{/name}}
		{{#ogtitle}}<meta property="og:title" content="{{ogtitle}}">{{/ogtitle}}
		{{#description}}<meta property="og:description" content="{{description}}">{{/description}}
		{{#image}}<meta property="og:image" content="{{image}}">{{/image}}
		{{#type}}<meta property="og:type" content="{{type}}">{{/type}}
		<meta property="og:locale" content="ru_RU">

		<!-- Favicons -->
		<link rel="image_src" href="/resources/img/favicon/h152.png">
		<meta property="og:image" content="/resources/img/favicon/h152.png">
		<link rel="apple-touch-icon-precomposed" sizes="57x57" href="/resources/img/favicon/h57.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/resources/img/favicon/h72.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/resources/img/favicon/h114.png">
		<link rel="apple-touch-icon-precomposed" sizes="120x120" href="/resources/img/favicon/h120.png">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/resources/img/favicon/h144.png">
		<link rel="apple-touch-icon-precomposed" sizes="152x152" href="/resources/img/favicon/h152.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/resources/img/favicon/h16.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/resources/img/favicon/h32.png">

		<!-- CSS-styles -->
		{{&styles}}

		{{#projects}}
		<script>
		var projectsList = {{{projects}}};
		</script>
		{{/projects}}

		<!-- Оптимизация контента для IE < 9 -->
		<!--[if lt IE 9]><script src="//cdn.jsdelivr.net/g/html5shiv@3.7.3,respond@1.4.2"></script><![endif]-->
	</head>

	<body>
		<header>{{&header}}</header>
		<main>{{&content}}</main>
		<footer>{{&footer}}</footer>

		<!-- Кнопка скроллинга наверх -->
		<div class="scroll-to-top">
			<b class="icon icon-up">Наверх</b>
		</div>

		<!-- JavaScript & jQuery -->
		{{&scripts}}
	</body>
</html>
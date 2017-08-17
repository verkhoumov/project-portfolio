<!DOCTYPE html>

<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">

		<title>{{title}}</title>
		<meta name="description" content="{{description}}">

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
		<link rel="stylesheet" href="/resources/css/error/common.css">

		<!-- Оптимизация контента для IE < 9 -->
		<!--[if lt IE 9]><script src="//cdn.jsdelivr.net/g/html5shiv@3.7.3,respond@1.4.2"></script><![endif]-->
	</head>

	<body class="d-flex align-content-between flex-wrap">
		{{&header}}
		{{&content}}
		{{&footer}}

		<!-- Yandex.Metrika counter -->
		<script type="text/javascript" >
			(function (d, w, c) {
				(w[c] = w[c] || []).push(function() {
					try {
						w.yaCounter45656544 = new Ya.Metrika({
							id:45656544,
							clickmap:true,
							trackLinks:true,
							accurateTrackBounce:true,
							webvisor:true,
							trackHash:true
						});
					} catch(e) { }
				});

				var n = d.getElementsByTagName("script")[0],
					s = d.createElement("script"),
					f = function () { n.parentNode.insertBefore(s, n); };
				s.type = "text/javascript";
				s.async = true;
				s.src = "https://mc.yandex.ru/metrika/watch.js";

				if (w.opera == "[object Opera]") {
					d.addEventListener("DOMContentLoaded", f, false);
				} else { f(); }
			})(document, window, "yandex_metrika_callbacks");
		</script>
		<noscript><div><img src="https://mc.yandex.ru/watch/45656544" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->
	</body>
</html>
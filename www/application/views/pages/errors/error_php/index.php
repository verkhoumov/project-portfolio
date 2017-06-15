<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
body {
	margin: 0;
	padding: 0;
	width: 100%;
	font-family: 'Roboto', -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", "Helvetica Neue", Arial, sans-serif;
	font-weight: 300;
    background-color: #F44336;
    color: #767676;
}

.error-container {
	padding: 40px;
	background-color: #F44336;
    color: #767676;
}

.error-container:nth-of-type(even) {
	background-color: #e83f33;
}

.error-container h1.h1-error {
	color: #fff6f5;
    font-size: 2rem;
    margin: 0;
    font-weight: normal;
}

.error-container h2.h2-error {
	color: #ffd6d3;
	font-size: 1.6em;
	margin: 25px 0 15px;
	font-weight: normal;
}

.error-container p.p-error {
	margin: 0;
	color: #767676;
}

.error-container strong {
    font-weight: 500;
    color: #333;
}

.card-error-wrapper {
	border: 1px solid #d8362a;
}

.error-container .card-error {
	padding: 16px;
    background-color: #fff6f6;
}

.error-container .card-error ~ .card-error {
	border-top: 1px solid #e0e0e0;
}
</style>

<div class="error-container">
	<h1 class="h1-error">{{title}}</h1>

	<h2 class="h2-error">Основная информация</h2>
	<div class="card-error-wrapper">
		<div class="card-error">
			<p class="p-error"><strong>Уровень:</strong> {{severity}}<br>
			<strong>Сообщение:</strong> {{message}}<br>
			<strong>Файл:</strong> {{file}}<br>
			<strong>Строка:</strong> {{line}}</p>
		</div>
	</div>
	
	{{#backtrace.0}}
	<h2 class="h2-error">Backtrace</h2>
	
	<div class="card-error-wrapper">
		{{#backtrace}}
		<div class="card-error">
			<p class="p-error"><strong>Файл:</strong> {{file}}<br>
			<strong>Строка:</strong> {{line}}<br>
			<strong>Функция:</strong> {{function}}</p>
		</div>
		{{/backtrace}}
	</div>
	{{/backtrace.0}}
</div>
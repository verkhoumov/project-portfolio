<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Pagination settigns.
| -------------------------------------------------------------------------
*/
$config['pagination'] = [
	// Страница, поверх которой будет накладываться пагинация.
	// По-умолчанию - главная страница сайта.
	'base_url' => '/',

	// Префикс и постфикс при генерации ссылок на страницы.
	'prefix' => 'page-',
	'suffix' => '',

	// Атрибут, куда будут записаны номера страниц.
	'data_page_attr' => 'data-pagination-page',

	// Чтобы нумерация страниц была 1, 2, 3, а не по количеству материалов 20, 40, 60.
	'use_page_numbers' => TRUE,

	// Общее кол-во материалов и кол-во материалов на одной странице.
	'total_rows' => 0,
	'per_page'   => 50,

	// Атрибуты для ключевых страниц: start, prev, next.
	// Закомментировать, если надо включить их.
	'attributes' => FALSE,

	// Обёртка для пагинации.
	'full_tag_open' => '<div class="pagination-wrapper"><div class="pagination">',
	'full_tag_close' => '</div></div>',

	// Обёртка для элементов пагинации.
	'first_tag_open'  => '<div class="pagination-item" data-pagination-type="start">',
	'first_tag_close' => '</div>',
	'prev_tag_open'   => '<div class="pagination-item" data-pagination-type="previous">',
	'prev_tag_close'  => '</div>',
	'cur_tag_open'    => '<div class="pagination-item" data-pagination-type="current"><strong>',
	'cur_tag_close'   => '</strong></div>',
	'num_tag_open'    => '<div class="pagination-item" data-pagination-type="page">',
	'num_tag_close'   => '</div>',
	'next_tag_open'   => '<div class="pagination-item" data-pagination-type="next">',
	'next_tag_close'  => '</div>',
	'last_tag_open'   => '<div class="pagination-item" data-pagination-type="end">',
	'last_tag_close'  => '</div>',

	// Стандартные имена для ключевых страниц.
	// Чтобы отключить, можно прописать FALSE.
	'first_link' => 'Начало',
	'last_link'  => 'Конец',
	'next_link'  => FALSE,
	'prev_link'  => FALSE
];
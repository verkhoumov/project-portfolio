<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  Обработанные данные.
 *  
 *  @param   array   $data  [Данные]
 *  @return  array
 */
function get_query_data($data = [])
{
	$data = (array) $data;

	$result = get_default_query_data();

	if (isset($data['id']) && $data['id'] > 0)
	{
		$result['id'] = (integer) $data['id'];
	}

	if (isset($data['code']) && $data['code'] != '')
	{
		$result['code'] = get_string($data['code']);
	}

	if (isset($data['name']) && $data['name'] != '')
	{
		$result['name'] = get_string($data['name']);
	}

	if (isset($data['title']) && $data['title'] != '')
	{
		$result['title'] = (string) $data['title'];
	}

	if (isset($data['description']) && $data['description'] != '')
	{
		$result['description'] = (string) $data['description'];
	}

	if (isset($data['type']) && $data['type'] != '')
	{
		$result['type'] = get_string($data['type']);
	}

	return $result;
}

/**
 *  Данные по-умолчанию.
 *  
 *  @return  array
 */
function get_default_query_data()
{
	return [
		'id'          => 0,
		'code'        => NULL,
		'name'        => NULL,
		'title'       => NULL,
		'description' => NULL,
		'type'        => NULL
	];
}

// ------------------------------------------------------------------------

/**
 *  Определение заголовка страницы поиска согласно запросу.
 *  
 *  @param   string  $value   [Подставляемое значение (год, запрос)]
 *  @param   string  $prefix  [Префикс (вместо значения)]
 *  @param   string  $type    [Тип запроса]
 *  @return  string
 */
function get_search_title($value = '', $prefix = NULL, $type = 'default')
{
	$value = get_string($value);

	$prefix = isset($prefix) ? $prefix : default_title_prefix($value, $type);
	
	return get_title_value($prefix, $type);
}

/**
 *  Определение описания страницы поиска согласно запросу.
 *  
 *  @param   string  $value        [Подставляемое значение (год, запрос)]
 *  @param   string  $prefixTitle  [Префикс заголовка (вместо значения)]
 *  @param   string  $prefixDesc   [Префикс описания (вместо значения)]
 *  @param   string  $type         [Тип запроса]
 *  @return  string
 */
function get_search_description($value = '', $prefixTitle = NULL, $prefixDesc = NULL, $type = 'default')
{
	$value = get_string($value);

	$prefix = isset($prefixDesc) ? $prefixDesc : (isset($prefixTitle) ? $prefixTitle : default_description_prefix($value, $type));
	
	return get_description_value($prefix, $type);
}

/**
 *  Префикс заголовка по-умолчанию.
 *  
 *  @param   string  $value  [Подставляемое в префикс значение (год, запрос)]
 *  @param   string  $type   [Тип запроса]
 *  @return  string
 */
function default_title_prefix($value = '', $type = 'default')
{
	$types = [
		'default'  => '', 
		'year'     => ' за %d год',
		'category' => ' категории «%s»',
		'tech'     => ' с технологией «%s»',
		'tag'      => ' с пометкой «%s»',
		'other'    => ' по запросу «%s»'
	];

	return sprintf($types[$type], $value);
}

/**
 *  Префикс описания по-умолчанию.
 *  
 *  @param   string  $value  [Подставляемое в префикс значение (год, запрос)]
 *  @param   string  $type   [Тип запроса]
 *  @return  string
 */
function default_description_prefix($value = '', $type = 'default')
{
	return default_title_prefix($value, $type);
}

/**
 *  Текст заголовка.
 *  
 *  @param   string  $value  [Подставляемая в заголовок строка]
 *  @param   string  $type   [Тип запроса]
 *  @return  string
 */
function get_title_value($value = '', $type = 'default')
{
	$format = 'Все проекты';

	if ($type != 'default')
	{
		$format = 'Проекты%s';
	}

	return sprintf($format, $value);
}

/**
 *  Текст описания.
 *  
 *  @param   string  $value  [Подставляемая в описание строка]
 *  @param   string  $type   [Тип запроса]
 *  @return  string
 */
function get_description_value($value = '', $type = 'default')
{
	$format = 'Список всех завершённых, находящихся в разработке и запланированных на ближайшее время проектов. Здесь представлены веб-приложения, дизайн-работы и многое другое.';

	if ($type != 'default')
	{
		$format = 'Поиск всех проектов%s. Завершённых, находящихся в разработке и запланированных на ближайшее время.';
	}

	return sprintf($format, $value);
}

/* End of file search_helper.php */
/* Location: ./application/helpers/search_helper.php */
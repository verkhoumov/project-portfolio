<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  Обработка документов.
 *  
 *  @param   array   $data  [Документы]
 *  @return  array
 */
function get_documents_data($data = [])
{
	$data = (array) $data;
	
	$result = [];

	if (!empty($data))
	{
		foreach ($data as $key => $value)
		{
			$result[$key] = get_document_data($value);
		}
	}

	return $result;
}

/**
 *  Обработанные данные.
 *  
 *  @param   array   $data  [Данные]
 *  @return  array
 */
function get_document_data($data = [])
{
	$data = (array) $data;

	$result = get_default_document_data();

	if (isset($data['id']) && $data['id'] > 0)
	{
		$result['id'] = (integer) $data['id'];
	}

	if (isset($data['type']) && $data['type'] != '')
	{
		$result['type'] = get_string($data['type']);
	}

	if (isset($data['name']) && $data['name'] != '')
	{
		$result['name'] = get_string($data['name']);
	}

	if (isset($data['link']) && $data['link'] != '')
	{
		$result['link'] = get_document_link($data['link']);
	}

	if (isset($data['visible']) && $data['visible'] > 0)
	{
		$result['visible'] = TRUE;
	}

	return $result;
}

/**
 *  Данные по-умолчанию.
 *  
 *  @return  array
 */
function get_default_document_data()
{
	return [
		'id'      => 0,
		'type'    => NULL,
		'name'    => NULL,
		'link'    => NULL,
		'visible' => FALSE
	];
}

/**
 *  Формирование ссылки на документ.
 *  
 *  @param   string  $link  [Ссылка]
 *  @return  string
 */
function get_document_link($link = '')
{
	$link = get_string($link);

	return "/upload/files/{$link}";
}

/* End of file documents_helper.php */
/* Location: ./application/helpers/data/documents_helper.php */
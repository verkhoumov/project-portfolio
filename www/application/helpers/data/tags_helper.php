<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  Обработка меток.
 *  
 *  @param   array   $data  [Метки]
 *  @return  array
 */
function get_tags_data($data = [])
{
	$data = (array) $data;
	
	$result = [];

	if (!empty($data))
	{
		foreach ($data as $key => $value)
		{
			$result[$key] = get_tag_data($value);
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
function get_tag_data($data = [])
{
	$data = (array) $data;

	$result = get_default_tag_data();

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

	if (isset($data['tooltip']) && $data['tooltip'] != '')
	{
		$result['tooltip'] = get_string($data['tooltip']);
	}

	if (isset($data['created']) && $data['created'] != '')
	{
		$result['created'] = get_string($data['created']);
	}

	return $result;
}

/**
 *  Данные по-умолчанию.
 *  
 *  @return  array
 */
function get_default_tag_data()
{
	return [
		'id'      => 0,
		'code'    => NULL,
		'name'    => NULL,
		'tooltip' => NULL,
		'created' => NULL
	];
}

/* End of file tags_helper.php */
/* Location: ./application/helpers/data/tags_helper.php */
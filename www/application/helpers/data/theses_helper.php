<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  Обработка тезисов.
 *  
 *  @param   array   $data  [Тезисы]
 *  @return  array
 */
function get_theses_data($data = [])
{
	$data = (array) $data;
	
	$result = [];

	if (!empty($data))
	{
		foreach ($data as $key => $value)
		{
			$result[$key] = get_thesis_data($value);
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
function get_thesis_data($data = [])
{
	$data = (array) $data;

	$result = get_default_thesis_data();

	if (isset($data['id']) && $data['id'] > 0)
	{
		$result['id'] = (integer) $data['id'];
	}

	if (isset($data['title']) && $data['title'] != '')
	{
		$result['title'] = get_string($data['title']);
	}

	if (isset($data['text']) && $data['text'] != '')
	{
		$result['text'] = get_string($data['text']);
	}

	if (isset($data['position']) && $data['position'] > 0)
	{
		$result['position'] = (integer) $data['position'];
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
function get_default_thesis_data()
{
	return [
		'id'       => 0,
		'title'    => NULL,
		'text'     => NULL,
		'position' => 0,
		'visible'  => FALSE
	];
}

/* End of file theses_helper.php */
/* Location: ./application/helpers/data/theses_helper.php */
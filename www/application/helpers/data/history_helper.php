<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  Обработка истории.
 *  
 *  @param   array   $data  [История]
 *  @return  array
 */
function get_histories_data($data = [])
{
	$data = (array) $data;
	
	$result = [];

	if (!empty($data))
	{
		foreach ($data as $key => $value)
		{
			$result[$key] = get_history_data($value);
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
function get_history_data($data = [])
{
	$data = (array) $data;

	$result = get_default_history_data();

	if (isset($data['id']) && $data['id'] > 0)
	{
		$result['id'] = (integer) $data['id'];
	}

	if (isset($data['year']) && $data['year'] > 0)
	{
		$result['year'] = (integer) $data['year'];
	}

	if (isset($data['text']) && $data['text'] != '')
	{
		$result['text'] = get_string($data['text']);
	}

	if (isset($data['created']) && $data['created'] != '')
	{
		$result['created'] = get_string($data['created']);
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
function get_default_history_data()
{
	return [
		'id'      => 0,
		'year'    => 0,
		'text'    => NULL,
		'created' => NULL,
		'visible' => FALSE
	];
}

/* End of file history_helper.php */
/* Location: ./application/helpers/data/history_helper.php */
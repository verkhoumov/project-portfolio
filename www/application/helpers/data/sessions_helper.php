<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  Обработка информации переданного списка сессий.
 *  
 *  @param   array   $data  [Список сессий]
 *  @return  array
 */
function get_sessions_data($data = [])
{
	$data = (array) $data;
	
	$result = [];

	if (!empty($data))
	{
		foreach ($data as $key => $value)
		{
			$result[$key] = get_session_data($value);
		}
	}

	return $result;
}

/**
 *  Обработка информации о сессии.
 *  
 *  @param   array   $data  [Информация о сессии]
 *  @return  array
 */
function get_session_data($data = [])
{
	$data = (array) $data;

	$result = get_default_session_data();

	if (isset($data['id']) && $data['id'] > 0)
	{
		$result['id'] = (integer) $data['id'];
	}

	if (isset($data['user_host']) && $data['user_host'] != '')
	{
		$result['user_host'] = get_string($data['user_host']);
	}

	if (isset($data['user_agent']) && $data['user_agent'] != '')
	{
		$result['user_agent'] = get_string($data['user_agent']);
	}

	if (isset($data['created']) && $data['created'] != '')
	{
		$result['created'] = get_string($data['created']);
	}

	if (isset($data['updated']) && $data['updated'] != '')
	{
		$result['updated'] = get_string($data['updated']);
	}

	if (isset($data['session_hash']) && $data['session_hash'] != '')
	{
		$result['session_hash'] = get_string($data['session_hash']);
	}

	if (isset($data['hash_updated']) && $data['hash_updated'] != '')
	{
		$result['hash_updated'] = get_string($data['hash_updated']);
	}

	if (isset($data['status']) && $data['status'] > 0)
	{
		$result['status'] = (integer) $data['status'];
	}

	if (isset($data['status_message']) && $data['status_message'] != '')
	{
		$result['status_message'] = get_string($data['status_message']);
	}

	return $result;
}

/**
 *  Информация о сессии по-умолчанию.
 *  
 *  @return  array
 */
function get_default_session_data()
{
	return [
		'id'             => 0,
		'user_host'      => NULL,
		'user_agent'     => NULL,
		'created'        => NULL,
		'updated'        => NULL,
		'session_hash'   => NULL,
		'hash_updated'   => NULL,
		'status'         => 0,
		'status_message' => NULL
	];
}

/* End of file sessions_helper.php */
/* Location: ./application/helpers/data/sessions_helper.php */
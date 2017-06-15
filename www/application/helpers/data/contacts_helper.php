<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  Обработка контактов.
 *  
 *  @param   array   $data  [Контакты]
 *  @return  array
 */
function get_contacts_data($data = [])
{
	$data = (array) $data;
	
	$result = [];

	if (!empty($data))
	{
		foreach ($data as $key => $value)
		{
			$result[$key] = get_contact_data($value);
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
function get_contact_data($data = [])
{
	$data = (array) $data;

	$result = get_default_contact_data();

	if (isset($data['id']) && $data['id'] > 0)
	{
		$result['id'] = (integer) $data['id'];
	}

	if (isset($data['type']) && $data['type'] != '')
	{
		$result['type'] = get_string($data['type']);
	}

	if (isset($data['code']) && $data['code'] != '')
	{
		$result['code'] = get_string($data['code']);
	}

	if (isset($data['name']) && $data['name'] != '')
	{
		$result['name'] = get_string($data['name']);
	}

	if (isset($data['link']) && $data['link'] != '')
	{
		$result['link'] = get_string($data['link']);
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
function get_default_contact_data()
{
	return [
		'id'       => 0,
		'type'     => NULL,
		'code'     => NULL,
		'name'     => NULL,
		'link'     => NULL,
		'position' => 0,
		'visible'  => FALSE
	];
}

/* End of file contacts_helper.php */
/* Location: ./application/helpers/data/contacts_helper.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  Обработка образования.
 *  
 *  @param   array   $data  [Образование]
 *  @return  array
 */
function get_educations_data($data = [])
{
	$data = (array) $data;
	
	$result = [];

	if (!empty($data))
	{
		foreach ($data as $key => $value)
		{
			$result[$key] = get_education_data($value);
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
function get_education_data($data = [])
{
	$data = (array) $data;

	$result = get_default_education_data();

	if (isset($data['id']) && $data['id'] > 0)
	{
		$result['id'] = (integer) $data['id'];
	}

	if (isset($data['name']) && $data['name'] != '')
	{
		$result['name'] = get_string($data['name']);
	}

	if (isset($data['faculty']) && $data['faculty'] != '')
	{
		$result['faculty'] = get_string($data['faculty']);
	}

	if (isset($data['city']) && $data['city'] != '')
	{
		$result['city'] = get_string($data['city']);
	}

	if (isset($data['specialization']) && $data['specialization'] != '')
	{
		$result['specialization'] = get_string($data['specialization']);
	}

	if (isset($data['image']) && $data['image'] != '')
	{
		$result['image'] = get_string($data['image']);
	}

	$result['image'] = get_image($result['image'], 'education');

	if (isset($data['created']) && $data['created'] != '')
	{
		$result['created'] = get_string($data['created']);
	}

	if (isset($data['started']) && $data['started'] != '')
	{
		$result['started'] = get_string($data['started']);
	}

	if (isset($data['finished']) && $data['finished'] != '')
	{
		$result['finished'] = get_string($data['finished']);
	}

	if (isset($result['started']) && isset($result['finished']))
	{
		$now = time();
		$end = strtotime($result['finished']);

		$result['started'] = get_date($result['started'], '{mm} Y', 'b');
		$result['finished'] = $end < $now ? get_date($result['finished'], '{mm} Y', 'b') : 'По настоящее время';
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
function get_default_education_data()
{
	return [
		'id'             => 0,
		'name'           => NULL,
		'faculty'        => NULL,
		'city'           => NULL,
		'specialization' => NULL,
		'image'          => NULL,
		'created'        => NULL,
		'started'        => NULL,
		'finished'       => NULL,
		'visible'        => FALSE
	];
}

/* End of file education_helper.php */
/* Location: ./application/helpers/data/education_helper.php */
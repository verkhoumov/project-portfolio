<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  Обработка навыков.
 *  
 *  @param   array   $data  [Навыки]
 *  @return  array
 */
function get_skills_data($data = [])
{
	$data = (array) $data;
	
	$result = [];

	if (!empty($data))
	{
		foreach ($data as $key => $value)
		{
			$result[$key] = get_skill_data($value);
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
function get_skill_data($data = [])
{
	$data = (array) $data;

	$result = get_default_skill_data();

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

	if (isset($data['description']) && $data['description'] != '')
	{
		$result['description'] = get_string($data['description']);
	}

	if (isset($data['percent']) && $data['percent'] > 0)
	{
		$result['percent'] = ((float) $data['percent']) * 100;
	}

	if (isset($data['projects']) && $data['projects'] > 0)
	{
		$result['projects'] = (integer) $data['projects'];
	}

	if (isset($result['projects']))
	{
		$result['projects'] = get_noun_word($result['projects'], 'project');
	}

	if (isset($data['image']) && $data['image'] != '')
	{
		$result['image'] = get_string($data['image']);
	}

	$result['image'] = get_image($result['image'], 'skills');

	if (isset($data['color']) && $data['color'] != '')
	{
		$result['color'] = get_string($data['color']);
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
function get_default_skill_data()
{
	return [
		'id'          => 0,
		'type'        => NULL,
		'code'        => NULL,
		'name'        => NULL,
		'description' => NULL,
		'percent'     => 0.00,
		'projects'    => 0,
		'image'       => NULL,
		'color'       => NULL,
		'position'    => 0,
		'visible'     => FALSE
	];
}

/* End of file skills_helper.php */
/* Location: ./application/helpers/data/skills_helper.php */
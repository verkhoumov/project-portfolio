<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  Обработка личной информации.
 *  
 *  @param   array   $data  [Личная информация]
 *  @return  array
 */
function get_profile_data($data = [])
{
	$data = (array) $data;

	$result = get_default_profile_data();

	if (isset($data['name']) && $data['name'] != '')
	{
		$result['name'] = get_string($data['name']);
	}

	if (isset($data['city']) && $data['city'] != '')
	{
		$result['city'] = get_string($data['city']);
	}

	if (isset($data['birthday']) && $data['birthday'] != '')
	{
		$result['birthday'] = get_string($data['birthday']);
	}

	if (isset($result['birthday']))
	{
		$now = new DateTime();
		$birth = new DateTime($result['birthday']);

		// Определяем количество лет, прошедших со дня рождения.
		$years = $birth->diff($now)->format('%y');

		// Формируем строку.
		$result['age'] = get_noun_word($years, 'years');
	}

	if (isset($data['experience']) && $data['experience'] != '')
	{
		$result['experience'] = get_string($data['experience']);
	}

	if (isset($result['experience']))
	{
		$now = new DateTime();
		$exp = new DateTime($result['experience']);

		// Определяем количество лет, прошедших со дня начала получения опыта.
		$years = $exp->diff($now)->format('%y');

		// Формируем строку.
		$result['experience'] = get_noun_word($years, 'years');
		$result['skills_experience'] = get_noun_word($years, ['года', 'лет', 'лет']);
	}

	if (isset($data['skills']) && $data['skills'] > 0)
	{
		$result['skills'] = (integer) $data['skills'];
	}

	if (isset($result['skills']))
	{
		$result['skills'] = get_noun_word($result['skills'], ['уверенного навыка', 'уверенных навыков', 'уверенных навыков']);
	}

	if (isset($data['projects']) && $data['projects'] > 0)
	{
		$result['projects'] = (integer) $data['projects'];
	}

	if (isset($result['projects']))
	{
		$result['projects'] = get_noun_word($result['projects'], 'project');
	}

	if (isset($data['profession']) && $data['profession'] != '')
	{
		$result['profession'] = get_string($data['profession']);
	}

	if (isset($data['email']) && $data['email'] != '')
	{
		$result['email'] = get_string($data['email']);
	}

	if (isset($data['link']) && $data['link'] != '')
	{
		$result['link'] = get_string($data['link']);
	}

	if (isset($data['image']) && $data['image'] != '')
	{
		$result['image'] = get_string($data['image']);
	}

	$result['image'] = get_image($result['image'], 'profile');

	return $result;
}

/**
 *  Данные по-умолчанию.
 *  
 *  @return  array
 */
function get_default_profile_data()
{
	return [
		'name'              => NULL,
		'city'              => NULL,
		'birthday'          => NULL,
		'experience'        => NULL,
		'skills_experience' => NULL,
		'skills'            => 0,
		'projects'          => 0,
		'profession'        => NULL,
		'email'             => NULL,
		'link'              => NULL,
		'image'             => NULL
	];
}

/* End of file profile_helper.php */
/* Location: ./application/helpers/data/profile_helper.php */
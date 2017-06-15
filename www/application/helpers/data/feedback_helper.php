<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  Обработка данных.
 *  
 *  @param   array   $data  [Данные]
 *  @return  array
 */
function get_feedback_data($data = [])
{
	$data = (array) $data;

	$result = get_default_feedback_data();

	if (isset($data['name']) && $data['name'] != '')
	{
		$result['name'] = get_clear_string($data['name']);
	}

	if (isset($data['email']) && $data['email'] != '')
	{
		$result['email'] = get_string($data['email']);
	}

	if (isset($data['message']) && $data['message'] != '')
	{
		$result['message'] = strip_tags(get_clear_string($data['message']));
	}

	return $result;
}

/**
 *  Валидация данных формы обратной связи и формирование ошибок.
 *  
 *  @param   array   $data  [Данные формы]
 *  @return  array
 */
function get_feedback_errors($data = [])
{
	$errors = [];

	if (!isset($data['name']) || mb_strlen($data['name'], 'UTF-8') < 2 || mb_strlen($data['name'], 'UTF-8') > 50)
	{
		$errors['name'] = 'Имя должно быть длинной не менее 2 и не более 50 символов.';
	}

	if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL))
	{
		$errors['email'] = 'Адрес электронной почты указан неверно!';
	}

	if (!isset($data['message']) || mb_strlen($data['message'], 'UTF-8') < 10 || mb_strlen($data['message'], 'UTF-8') > 1000)
	{
		$errors['message'] = 'Длина сообщения должна быть не менее 10 и не более 1000 символов.';
	}

	return $errors;
}

/**
 *  Данные по-умолчанию.
 *  
 *  @return  array
 */
function get_default_feedback_data()
{
	return [
		'name'    => NULL,
		'email'   => NULL,
		'message' => NULL
	];
}

/* End of file feedback_helper.php */
/* Location: ./application/helpers/data/feedback_helper.php */
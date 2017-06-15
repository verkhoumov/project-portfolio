<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  Инициализация 401-ой ошибки.
 *  
 *  @param   string  $reason  [Сообщение об ошибке]
 *  @return  void
 */
function show_401($reason = '')
{
	$_error =& load_class('Exceptions', 'core');
	$_error->show_401($reason);
	exit(1); // EXIT_ERROR
}

/**
 *  Инициализация 403-ей ошибки - доступ запрещён.
 *  
 *  @param   string  $reason  [Сообщение об ошибке]
 *  @return  void
 */
function show_403($reason = '')
{
	$_error =& load_class('Exceptions', 'core');
	$_error->show_403($reason);
	exit(1); // EXIT_ERROR
}

/* End of file exceptions_helper.php */
/* Location: ./application/helpers/exceptions_helper.php */
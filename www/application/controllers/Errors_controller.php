<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errors_controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 *  Страница с 404 ошибкой.
	 *  
	 *  @return  void
	 */
	public function page404()
	{
		// Подключение компонентов.
		$this->load();

		// Вывод страницы с 404 ошибкой.
		show_404();
	}

	/**
	 *  Подключение сторонних компонентов.
	 *  
	 *  @return  void
	 */
	protected function load()
	{
		parent::load();
	}
}

/* End of file Errors_controller.php */
/* Location: ./application/controllers/Errors_controller.php */
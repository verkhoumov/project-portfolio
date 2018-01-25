<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Theses_controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 *  Подключение сторонних компонентов.
	 *  
	 *  @return  void
	 */
	protected function load()
	{
		parent::load();

		// Модель для работы с данными.
		$this->load->model('Theses_model');
	}

	// ------------------------------------------------------------------------

	public function get()
	{
		// Подключение компонентов.
		$this->load();

		// Данные.
		$data = $this->Theses_model->get_list();
		$data = get_theses_data($data);

		// Вывод на экран.
		$this->reply($data);
	}

	# public function put() {}

	# public function delete() {}
}

/* End of file Theses_controller.php */
/* Location: ./application/controllers/Api/Theses_controller.php */
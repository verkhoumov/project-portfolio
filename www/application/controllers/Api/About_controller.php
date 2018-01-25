<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About_controller extends MY_Controller
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
		$this->load->model('History_model');
	}

	// ------------------------------------------------------------------------

	public function get()
	{
		// Подключение компонентов.
		$this->load();

		// Данные.
		$data = $this->History_model->get_list();
		$data = get_histories_data($data);

		// Вывод на экран.
		$this->reply($data);
	}

	# public function put() {}

	# public function delete() {}
}

/* End of file About_controller.php */
/* Location: ./application/controllers/Api/About_controller.php */
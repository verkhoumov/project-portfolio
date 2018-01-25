<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Education_controller extends MY_Controller
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
		$this->load->model('Education_model');
	}

	// ------------------------------------------------------------------------

	public function get()
	{
		// Подключение компонентов.
		$this->load();

		// Данные.
		$data = $this->Education_model->get_list();
		$data = get_educations_data($data);

		// Вывод на экран.
		$this->reply($data);
	}

	# public function put() {}

	# public function delete() {}
}

/* End of file Education_controller.php */
/* Location: ./application/controllers/Api/Education_controller.php */
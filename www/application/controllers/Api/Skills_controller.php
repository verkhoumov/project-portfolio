<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Skills_controller extends MY_Controller
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
		$this->load->model('Skills_model');
	}

	// ------------------------------------------------------------------------

	public function get()
	{
		// Подключение компонентов.
		$this->load();

		// Данные.
		$data = $this->Skills_model->get_list();
		$data = get_skills_data($data);
		$data = group_array($data, 'type');
		$data = array_merge($data['main'], $data['other']);

		// Вывод на экран.
		$this->reply($data);
	}

	# public function put() {}

	# public function delete() {}
}

/* End of file Skills_controller.php */
/* Location: ./application/controllers/Api/Skills_controller.php */
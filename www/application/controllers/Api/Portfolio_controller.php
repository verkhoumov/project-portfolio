<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portfolio_controller extends MY_Controller
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
		$this->load->model('Projects_model');
	}

	// ------------------------------------------------------------------------

	public function get()
	{
		// Подключение компонентов.
		$this->load();

		// Данные.
		$stats = $this->Projects_model->get_stats();
		$data = $this->Projects_model->get_list();
		$data = get_projects_data($data);
		$data = group_projects_list($data, $stats);

		// Объединяем данные в один список.
		$list = [];

		foreach ($data as $year_id => $projects)
		{
			$list = array_merge($list, $projects['items']);
		}

		// Вывод на экран.
		$this->reply($list);
	}

	# public function put() {}

	# public function delete() {}
}

/* End of file Portfolio_controller.php */
/* Location: ./application/controllers/Api/Portfolio_controller.php */
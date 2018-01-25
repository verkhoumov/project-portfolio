<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_controller extends MY_Controller
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
		$this->load->model('Video_model');
	}

	// ------------------------------------------------------------------------

	public function get()
	{
		// Подключение компонентов.
		$this->load();

		// Данные.
		$data = $this->Video_model->get_list();
		$data = get_videos_data($data);

		// Вывод на экран.
		$this->reply($data);
	}

	# public function put() {}

	# public function delete() {}
}

/* End of file Video_controller.php */
/* Location: ./application/controllers/Api/Video_controller.php */
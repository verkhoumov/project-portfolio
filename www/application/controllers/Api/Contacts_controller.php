<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts_controller extends MY_Controller
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
		$this->load->model('Contacts_model');
	}

	// ------------------------------------------------------------------------

	public function get()
	{
		// Подключение компонентов.
		$this->load();

		// Данные.
		$data = $this->Contacts_model->get_list();
		$data = get_contacts_data($data);
		$data = group_array($data, 'type');

		// Вывод на экран.
		$this->reply(array_merge($data['default'], $data['social']));
	}

	# public function put() {}

	# public function delete() {}
}

/* End of file Contacts_controller.php */
/* Location: ./application/controllers/Api/Contacts_controller.php */
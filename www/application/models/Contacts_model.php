<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		// Задаём основную таблицу.
		$this->table = $this->db_contacts;

		// Подключаем хэлпер, необходимый для работы с данной моделью.
		$this->load->helper('data/contacts');
	}

	// ------------------------------------------------------------------------
	
	/**
	 *  Контактные данные.
	 *  
	 *  @return  array
	 */
	public function get_list()
	{
		return $this->get(['visible' => 1], ['position' => 'ASC']);
	}
}

/* End of file Contacts_model.php */
/* Location: ./application/models/Contacts_model.php */
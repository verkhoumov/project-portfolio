<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Theses_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		// Задаём основную таблицу.
		$this->table = $this->db_theses;

		// Подключаем хэлпер, необходимый для работы с данной моделью.
		$this->load->helper('data/theses');
	}

	// ------------------------------------------------------------------------
	
	/**
	 *  Тезисы.
	 *  
	 *  @return  array
	 */
	public function get_list()
	{
		return $this->get(['visible' => 1], ['position' => 'ASC']);
	}
}

/* End of file Theses_model.php */
/* Location: ./application/models/Theses_model.php */
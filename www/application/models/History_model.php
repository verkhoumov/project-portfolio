<?php defined('BASEPATH') OR exit('No direct script access allowed');

class History_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		// Задаём основную таблицу.
		$this->table = $this->db_history;

		// Подключаем хэлпер, необходимый для работы с данной моделью.
		$this->load->helper('data/history');
	}

	// ------------------------------------------------------------------------
	
	/**
	 *  История.
	 *  
	 *  @return  array
	 */
	public function get_list()
	{
		return $this->get(['visible' => 1], ['year' => 'ASC']);
	}
}

/* End of file History_model.php */
/* Location: ./application/models/History_model.php */
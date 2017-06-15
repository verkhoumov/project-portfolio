<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Education_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		// Задаём основную таблицу.
		$this->table = $this->db_education;

		// Подключаем хэлпер, необходимый для работы с данной моделью.
		$this->load->helper('data/education');
	}

	// ------------------------------------------------------------------------
	
	/**
	 *  Образование.
	 *  
	 *  @return  array
	 */
	public function get_list()
	{
		return $this->get(['visible' => 1], ['finished' => 'DESC']);
	}
}

/* End of file Education_model.php */
/* Location: ./application/models/Education_model.php */
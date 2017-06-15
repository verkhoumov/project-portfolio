<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Video_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		// Задаём основную таблицу.
		$this->table = $this->db_video;

		// Подключаем хэлпер, необходимый для работы с данной моделью.
		$this->load->helper('data/video');
	}

	// ------------------------------------------------------------------------
	
	/**
	 *  Видеозаписи.
	 *  
	 *  @return  array
	 */
	public function get_list()
	{
		// Ключевое поле.
		$this->key_field = 'position';

		return $this->get(['visible' => 1], ['position' => 'ASC'], 3);
	}
}

/* End of file Video_model.php */
/* Location: ./application/models/Video_model.php */
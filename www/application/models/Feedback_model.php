<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		// Задаём основную таблицу.
		$this->table = $this->db_feedback;

		// Подключаем хэлпер, необходимый для работы с данной моделью.
		$this->load->helper('data/feedback');
	}
}

/* End of file Feedback_model.php */
/* Location: ./application/models/Feedback_model.php */
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		// Задаём основную таблицу.
		$this->table = $this->db_profile;

		// Подключаем хэлпер, необходимый для работы с данной моделью.
		$this->load->helper('data/profile');
	}

	// ------------------------------------------------------------------------
	
	/**
	 *  Профиль пользователя.
	 *  
	 *  @return  array
	 */
	public function get_data()
	{
		// Дополнительный запрос на получение количества выполненных проектов.
		$this->db->select("*, (SELECT COUNT(`id`) FROM `{$this->db_projects}` WHERE `visible` = 1 AND `finished` < NOW()) AS `projects`, (SELECT COUNT(`id`) FROM `{$this->db_skills}` WHERE `percent` > 0.3) AS `skills`", FALSE);

		return $this->get_one();
	}
}

/* End of file Profile_model.php */
/* Location: ./application/models/Profile_model.php */
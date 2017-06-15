<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tags_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		// Задаём основную таблицу.
		$this->table = $this->db_tags;

		// Подключаем хэлпер, необходимый для работы с данной моделью.
		$this->load->helper('data/tags');
	}

	// ------------------------------------------------------------------------
	
	/**
	 *  Получение метки по коду.
	 *  
	 *  @return  array
	 */
	public function get_by_code($code = '')
	{
		return $this->get_one(['code' => (string) $code]);
	}

	/**
	 *  Список меток, указанных для заданного проекта.
	 *  
	 *  @param   integer  $project_id  [ID проекта]
	 *  @return  array
	 */
	public function get_by_project_id($project_id = 0)
	{
		$project_id = (integer) $project_id;
		
		$result = [];

		if ($project_id > 0)
		{
			$this->db
				->select('`T`.*')
				->from("{$this->db_projects_tags} AS `PT`")
				->join("{$this->db_tags} AS `T`", "`PT`.`project_id` = {$project_id} AND `T`.`id` = `PT`.`tag_id`")
				->order_by('`T`.`name`', 'ASC');

			// Выполняем запрос.
			$result = $this->get_array();

			// Сбрасываем запрос.
			$this->db->reset_query();
		}

		return $result;
	}
}

/* End of file Tags_model.php */
/* Location: ./application/models/Tags_model.php */
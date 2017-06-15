<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Skills_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		// Задаём основную таблицу.
		$this->table = $this->db_skills;

		// Подключаем хэлпер, необходимый для работы с данной моделью.
		$this->load->helper('data/skills');
	}

	// ------------------------------------------------------------------------
	
	/**
	 *  Навыки.
	 *  
	 *  @return  array
	 */
	public function get_list()
	{
		// Дополнительный запрос на подсчёт количества проектов по каждому навыку.
		$this->db->select("*, (SELECT COUNT(`id`) FROM `{$this->db_projects_skills}` WHERE `skill_id` = `{$this->db_skills}`.`id`) AS `projects`", FALSE);

		return $this->get(['visible' => 1], ['position' => 'ASC', 'percent' => 'DESC']);
	}

	/**
	 *  Список технологий, используемых в заданном проекте.
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
				->select('`S`.*')
				->from("{$this->db_projects_skills} AS `PS`")
				->join("{$this->db_skills} AS `S`", "`PS`.`project_id` = {$project_id} AND `S`.`id` = `PS`.`skill_id` AND `S`.`visible` = 1")
				->order_by('`S`.`name`', 'ASC');

			// Выполняем запрос.
			$result = $this->get_array();

			// Сбрасываем запрос.
			$this->db->reset_query();
		}

		return $result;
	}
}

/* End of file Skills_model.php */
/* Location: ./application/models/Skills_model.php */
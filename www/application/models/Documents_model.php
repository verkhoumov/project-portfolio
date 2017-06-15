<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Documents_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		// Задаём основную таблицу.
		$this->table = $this->db_documents;

		// Подключаем хэлпер, необходимый для работы с данной моделью.
		$this->load->helper('data/documents');
	}

	// ------------------------------------------------------------------------

	/**
	 *  Получение списка документов для заданного проекта.
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
				->select('`D`.*')
				->from("{$this->db_projects_documents} AS `PD`")
				->join("{$this->db_documents} AS `D`", "`PD`.`project_id` = {$project_id} AND `D`.`id` = `PD`.`document_id`")
				->order_by('`D`.`name`', 'ASC');

			// Выполняем запрос.
			$result = $this->get_array();

			// Сбрасываем запрос.
			$this->db->reset_query();
		}

		return $result;
	}
}

/* End of file Documents_model.php */
/* Location: ./application/models/Documents_model.php */
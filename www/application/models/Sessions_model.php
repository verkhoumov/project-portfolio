<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		// Задаём основную таблицу.
		$this->table = $this->db_sessions;

		// Подключаем хэлпер, необходимый для работы с данной моделью.
		$this->load->helper('data/sessions');
	}

	// ------------------------------------------------------------------------

	/**
	 *  Запрос на получение информации о сессии.
	 *  
	 *  @param   integer  $session_db_id  [ID записи сессии]
	 *  @param   string   $session_hash   [Хеш идентификатора сессии]
	 *  @return  array
	 */
	public function get_by_db_id($session_db_id = 0, $session_hash = '')
	{
		$session_db_id = (integer) $session_db_id;
		$session_hash = (string) $session_hash;

		$result = [];

		if ($session_db_id > 0 && $session_hash != '')
		{
			$this->db
				->reset_query()
				->from($this->db_sessions)
				->where('id', $session_db_id)
				->where('session_hash', $session_hash);

			// Получение найденной записи.
			$result = $this->get_row();

			// Сбрасываем запрос.
			$this->db->reset_query();
		}

		return $result;
	}
}

/* End of file Sessions_model.php */
/* Location: ./application/models/Sessions_model.php */
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Projects_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		// Задаём основную таблицу.
		$this->table = $this->db_projects;

		// Подключаем хэлпер, необходимый для работы с данной моделью.
		$this->load->helper('data/projects');
		$this->load->helper('search');
	}

	// ------------------------------------------------------------------------
	
	/**
	 *  Получение списка проектов, сгрупированных по года в определённом количестве.
	 *  То есть вывод Х наиболее свежих проектов за последние Y лет.
	 *  
	 *  @param   integer  $offset_years  [Сколько лет надо пропустить]
	 *  @param   integer  $max_years     [Сколько лет надо вывести]
	 *  @param   integer  $max_items     [Сколько проектов за год надо вывести]
	 *  @return  array
	 */
	public function get_list($offset_years = 0, $max_years = 3, $max_items = 6)
	{
		$offset_years = (integer) $offset_years;
		$max_years    = (integer) $max_years;
		$max_items    = (integer) $max_items;

		$result = [];

		if ($max_years > 0 && $max_items > 0)
		{
			if ($offset_years > 0)
			{
				$max_years += $offset_years;
			}

			$set = "
				SET @i = 0, @n = 0, @year = 0, @year_count = 1, @isset = false,
					@max_years = {$max_years}, @max_items = {$max_items}, @offset_years = {$offset_years};
			";

			$query = "
				SELECT `P1`.*, YEAR(`P1`.`finished`) AS `year`
				FROM (
					SELECT `P0`.*, `C0`.`code` AS `category_link`, `C0`.`name` AS `category_name`
					FROM `{$this->db_projects}` AS `P0`
					JOIN `{$this->db_categories}` AS `C0` ON `P0`.`visible` = 1 AND `C0`.`id` = `P0`.`category_id`
					ORDER BY `P0`.`finished` DESC
				) AS `P1` 
				WHERE 
					(IF(@isset, true, (@year := YEAR(`P1`.`finished`)) AND (@isset := true))) AND 
					(@n := IF(@year = YEAR(`P1`.`finished`), @i := @i + 1, (@i := 1) AND (@year := YEAR(`P1`.`finished`)) AND (@year_count := @year_count + 1))) AND 
					@n <= @max_items AND @year_count > @offset_years AND @year_count <= @max_years;
			";

			// Выполняем запрос.
			$set = $this->db->query($set);
			$query = $this->db->query($query);

			foreach ($query->result_array() as $data)
			{
				$result[] = $data;
			}

			// Сбрасываем запрос.
			$this->db->reset_query();
		}

		return (array) $result;
	}

	/**
	 *  Получение общего количества проектов за каждый год.
	 *  
	 *  @return  array
	 */
	public function get_stats()
	{
		// Ключевое поле.
		$this->key_field = 'year';

		$this->db
			->select('YEAR(`finished`) AS `year`, COUNT(`id`) AS `count`', FALSE)
			->group_by('YEAR(`finished`)', FALSE)
			->order_by('finished', 'DESC');

		return $this->get(['visible' => 1]);
	}

	// ------------------------------------------------------------------------

	/**
	 *  Поиск проектов по заданному запросу.
	 *  
	 *  @param   string   $query       [Запрос]
	 *  @param   string   $query_type  [Тип запроса]
	 *  @param   integer  $limit       [Ограничение на количество проектов]
	 *  @param   string   $last_date   [Дата, с которой начинать загрузку]
	 *  @return  array
	 */
	public function search($query = NULL, $query_type = 'default', $limit = 6, $last_date = NULL)
	{
		$limit = (integer) $limit;
		
		// Основное условие.
		$this->db
			->select('`P`.*, YEAR(`P`.`finished`) AS `year`, `C`.`code` AS `category_link`, `C`.`name` AS `category_name`', FALSE)
			->from("{$this->db_projects} AS `P`")
			->join("{$this->db_categories} AS `C`", '`P`.`visible` = 1 AND `C`.`id` = `P`.`category_id`');

		// Целевое условие.
		switch ($query_type)
		{
			case 'year': $this->search_by_year($query); break;
			case 'category': $this->search_by_category($query); break;
			case 'tech': $this->search_by_tech($query); break;
			case 'tag': $this->search_by_tag($query); break;
			case 'other': $this->search_by_query($query); break;
		}

		// Основное условие.
		$this->db
			->group_by('`P`.`id`')
			->order_by('`P`.`finished`', 'DESC');

		// Отсекаем проекты с большей датой, это необходимо
		// для быстрой работы постраничного вывода.
		if (!empty($last_date))
		{
			// NOTE: Может быть баг, если будет много одинаковых дат у разных проектов.
			$this->db->where('`P`.`finished` <=', $last_date);
		}

		// Если указано ограничение, загружаем на 1 проект больше чтобы
		// знать, есть ли проекты на следующей странице или нет.
		if ($limit > 0)
		{
			$this->db->limit($limit + 1);
		}

		// Выполняем запрос.
		$result = $this->get_array();

		// Сбрасываем запрос.
		$this->db->reset_query();
	
		return $result;
	}

	/**
	 *  Условие для поиска проектов по году.
	 *  
	 *  @param   string  $query  [Запрос]
	 *  @return  void
	 */
	public function search_by_year($query = NULL)
	{
		$this->db->where('YEAR(`P`.`finished`)', $query, FALSE);
	}

	/**
	 *  Условие для поиска проектов по категории.
	 *  
	 *  @param   string  $query  [Запрос]
	 *  @return  void
	 */
	public function search_by_category($query = NULL)
	{
		$this->db
			->where('`C`.`code`', $query)
			->or_where('`C`.`name`', $query);
	}

	/**
	 *  Условие для поиска проектов по технологии.
	 *  
	 *  @param   string  $query  [Запрос]
	 *  @return  void
	 */
	public function search_by_tech($query = NULL)
	{
		$this->db
			->join("{$this->db_projects_skills} AS `PS`", "`PS`.`project_id` = `P`.`id`")
			->join("{$this->db_skills} AS `S`", "`S`.`id` = `PS`.`skill_id` AND (`S`.`code` = '{$query}' OR `S`.`name` = '{$query}')");
	}

	/**
	 *  Условие для поиска проектов по метке.
	 *  
	 *  @param   string  $query  [Запрос]
	 *  @return  void
	 */
	public function search_by_tag($query = NULL)
	{
		$this->db
			->join("{$this->db_projects_tags} AS `PT`", '`PT`.`project_id` = `P`.`id`')
			->join("{$this->db_tags} AS `T`", "`T`.`id` = `PT`.`tag_id` AND (`T`.`code` = '{$query}' OR `T`.`name` = '{$query}')");
	}

	/**
	 *  Условие для поиска проектов по строке, содержащейся в информации о проекте.
	 *  
	 *  @param   string  $query  [Запрос]
	 *  @return  void
	 */
	public function search_by_query($query = NULL)
	{
		$like = [
			'`P`.`name`'        => $query,
			'`P`.`title`'       => $query,
			'`P`.`description`' => $query,
			'`P`.`text`'        => $query
		];

		$this->db
			->group_start()
				->or_like($like)
			->group_end();
	}

	// ------------------------------------------------------------------------

	/**
	 *  Получение информации о проекте по ссылке.
	 *  
	 *  @param   string  $link  [Ссылка]
	 *  @return  array
	 */
	public function get_by_link($link = NULL)
	{
		$result = [];

		if (!empty($link))
		{
			$this->db
				->select('`P`.*, YEAR(`P`.`finished`) AS `year`, `C`.`code` AS `category_link`, `C`.`name` AS `category_name`', FALSE)
				->from("{$this->db_projects} AS `P`")
				->join("{$this->db_categories} AS `C`", '`C`.`id` = `P`.`category_id`')
				->where(['`P`.`link`' => $link, '`P`.`visible`' => 1]);

			// Получение одной записи.
			$result = $this->get_row();

			// Сбрасываем запрос.
			$this->db->reset_query();
		}

		return $result;
	}

	/**
	 *  Получение информации о поисковом запросе. Используется
	 *  для определения типа запроса.
	 *
	 *  @param   string  $query  [Запрос]
	 *  @return  array
	 */
	public function get_query_info($query = NULL)
	{
		$result = [];

		if (!empty($query)) 
		{
			// Очищаем строку.
			$query = $this->db->escape($query);

			$query = "
				SELECT * 
				FROM (	
					SELECT `id`, `code`, `name`, `title`, `description`, 'category' as `type` FROM `{$this->db_categories}`
					UNION
					SELECT `id`, `code`, `name`, `title`, `description`, 'tech' as `type` FROM `{$this->db_skills}` WHERE `visible` = 1
					UNION
					SELECT `id`, `code`, `name`, `title`, `description`, 'tag' as `type` FROM `{$this->db_tags}`
				) AS `list`
				WHERE `code` = {$query} OR `name` = {$query}
				LIMIT 1
			";

			$query = $this->db->query($query);
			$result = $query->row_array();

			// Сбрасываем запрос.
			$this->db->reset_query();
		}

		return (array) $result;
	}

	// ------------------------------------------------------------------------

	/**
	 *  Формируем список возможных поисковых запросов согласно списку
	 *  категорий, технологий и меток.
	 *  
	 *  @return  array
	 */
	public function get_search_queries()
	{
		$result = [];

		$query = "
			(
				SELECT `C`.`code`, 'category' AS `type`
				FROM `projects` AS `P`
				JOIN `categories` AS `C` ON `C`.`id` = `P`.`category_id`
				GROUP BY `C`.`id`
			)
			UNION
			(
				SELECT `S`.`code`, 'tech' AS `type`
				FROM `projects_skills` AS `PS`
				JOIN `skills` AS `S` ON `S`.`id` = `PS`.`skill_id`
				GROUP BY `S`.`id`
			)
			UNION
			(
				SELECT `T`.`code`, 'tag' AS `type`
				FROM `projects_tags` AS `PT`
				JOIN `tags` AS `T` ON `T`.`id` = `PT`.`tag_id`
				GROUP BY `T`.`id`
			)
		";

		// Выполняем запрос.
		$query = $this->db->query($query);

		foreach ($query->result_array() as $data)
		{
			$result[] = $data;
		}

		// Сбрасываем запрос.
		$this->db->reset_query();

		return (array) $result;
	}
}

/* End of file Projects_model.php */
/* Location: ./application/models/Projects_model.php */
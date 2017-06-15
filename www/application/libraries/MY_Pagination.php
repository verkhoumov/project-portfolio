<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Pagination extends CI_Pagination
{
	public function __construct($params = [])
	{
		parent::__construct();

		// Дополнительная инициализация.
		$this->initialize($this->config($params));
	}

	/**
	 *  Дополнительные настройки для пагинации.
	 *  
	 *  @param   array   $params  [Настройки пагинации]
	 *  @return  array
	 */
	private function config($params = [])
	{
		// Подключаем конфигурацию пагинации.
		$this->CI->config->load('pagination');

		// Извлекаем параметры.
		$config = $this->CI->config->item('pagination');

		// Формируем итоговый конфиг.
		$config = $params + $config;

		// Дополнительные настройки под текущий проект.
		$addon = [
			'first_link' => 1,
			'last_link'  => $this->get_pages_count($config['total_rows'], $config['per_page'])
		];

		return $addon + $config;
	}

	/**
	 *  Подсчёт кол-ва страниц по кол-ву материалов и 
	 *  ограничению материалов на одну страницу.
	 *  
	 *  @param   integer  $count  [Количество материалов]
	 *  @param   integer  $limit  [Ограничение на одну страницу]
	 *  @return  integer
	 */
	public function get_pages_count($total_rows = 0, $per_page = 0)
	{
		return (integer) ceil($total_rows / $per_page);
	}

	/**
	 *  Начиная со второй страницы необходимо блокировать индексацию
	 *  контента, чтобы предотвратить дублирование. Переход по ссылкам
	 *  при этом разрешается.
	 *  
	 *  @return  boolean
	 */
	public function is_page_noindex()
	{
		return $this->cur_page > 1 ? TRUE : FALSE;
	}

	/**
	 *  Ссылка на предыдущую страницу пагинации.
	 *  
	 *  @return  string
	 */
	public function get_previous_link()
	{
		$result = '';

		if ($this->cur_page > 1)
		{
			$i = $this->cur_page - 1;
			$base_url = trim($this->base_url);
			$result = site_url($base_url);

			if ($i > 1)
			{
				$result = site_url([$base_url, $this->prefix.$i.$this->suffix]);
			}
		}

		return $result;
	}

	/**
	 *  Ссылка на следующую страницу пагинации.
	 *  
	 *  @return  string
	 */
	public function get_next_link()
	{
		$pages = (integer) $this->last_link;

		$result = '';

		if ($this->cur_page > 0 && $this->cur_page < $pages)
		{
			$i = $this->cur_page + 1;
			$base_url = trim($this->base_url);
			$result = site_url([$base_url, $this->prefix.$i.$this->suffix]);
		}

		return $result;
	}
}

/* End of file MY_Pagination.php */
/* Location: ./application/libraries/MY_Pagination.php */
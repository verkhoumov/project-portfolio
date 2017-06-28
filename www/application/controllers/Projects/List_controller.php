<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class List_controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 *  Подключение сторонних компонентов.
	 *  
	 *  @return  void
	 */
	protected function load()
	{
		parent::load();

		$this->load->helper('search');
	}

	// ------------------------------------------------------------------------

	/**
	 *  Главная страница.
	 *  
	 *  @return  void
	 */
	public function index()
	{
		// Подключение компонентов.
		$this->load();

		// Обработка поискового запроса.
		$query = $this->get_search_query();
		$query_data = get_query_data();
		
		// Изменяем регистр запроса.
		$_query = mb_strtolower($query, 'UTF-8');

		// Тип запроса.
		$query_type = is_null($query) ? 'default' : NULL;
		$query_type = is_null($query_type) ? (is_numeric($query) && $query >= 1990 && $query <= 2050 ? 'year' : NULL) : $query_type;
		$query_type = is_null($query_type) ? (strpos($_query, 'личн') !== FALSE || strpos($_query, 'person') !== FALSE ? 'personal' : NULL) : $query_type;
		$query_data = is_null($query_type) ? $this->get_search_query_data($query) : $query_data;
		$query_type = is_null($query_type) ? (is_null($query_data['type']) ? 'other' : $query_data['type']) : $query_type;

		// Данные.
		$profile  = $this->get_profile();
		$projects = $this->search_projects($query, $query_type);

		// Прочие данные.
		$title = get_search_title(in_array($query_type, ['year', 'other']) ? $query : $query_data['name'], $query_data['title'], $query_type);
		$description = get_search_description(in_array($query_type, ['year', 'other']) ? $query : $query_data['name'], $query_data['title'], $query_data['description'], $query_type);

		// Данные для подстановки в шаблоны.
		$data = [
			'index' => [
				'this' => [
					'title'       => $this->get_title($title),
					'ogtitle'     => $title,
					'description' => $description,
					'url'         => site_url(uri_string(), 'https'),
					'name'        => $this->cfg['title'],
					'image'       => $profile['image'],
					'type'        => FALSE,
					'projects'    => json_encode($projects, JSON_UNESCAPED_UNICODE)
				],
				'styles' => [
					'version' => $this->cfg['version']
				],
				'header' => [
					'this'  => [
						'projects' => TRUE
					],
					'menu'  => $profile,
					'card'  => [
						'title'       => $title,
						'description' => $description
					]
				],
				'content' => [
					'this' => [],
					'portfolio' => [
						'this' => [
							'portfolio' => $projects,
							'queryType' => $query_type
						],
						'search' => [
							'query' => $query
						],
						'list' => $projects,
					]
				],
				'footer' => $profile,
				'scripts' => [
					'version'   => $this->cfg['version'],
					'templates' => [
						'projects' => $this->Mustache->load('pages/main/elements/list', TRUE)
					]
				]
			]
		];

		// Компоновка итогового шаблона.
		$this->Mustache->parse('index', $this->get_index_components($data['index']));
	}

	// ------------------------------------------------------------------------

	/**
	 *  REBUILD/Компоненты от шапки.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  array
	 */
	protected function get_header_components($data = [])
	{
		return $data['this'] + [
			'menu'  => $this->get_menu_render($data['menu']),
			'card'  => $this->get_card_render($data['card'])
		];
	}

	/**
	 *  REBUILD/Меню.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_menu_render($data = [])
	{
		return $this->Mustache->parse('pages/projects/list/elements/menu', $data, TRUE);
	}

	/**
	 *  REBUILD/Основная информация.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_card_render($data = [])
	{
		return $this->Mustache->parse('pages/projects/list/elements/card', $data, TRUE);
	}

	/**
	 *  REBUILD/Контент.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_content_render($data = [])
	{
		return $this->Mustache->parse('pages/projects/list/index', $this->get_content_components($data), TRUE);
	}

	/**
	 *  REBUILD/Компоненты от контента.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  array
	 */
	protected function get_content_components($data = [])
	{
		return $data['this'] + [
			'portfolio' => $this->get_portfolio_render($data['portfolio'])
		];
	}

	/**
	 *  REBUILD/Шаблон для списка проектов.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_portfolio_render($data = [])
	{
		return $this->Mustache->parse('pages/projects/list/templates/portfolio', $this->get_portfolio_components($data), TRUE);
	}

	/**
	 *  REBUILD/Компоненты от списка проектов.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_portfolio_components($data = [])
	{
		return $data['this'] + [
			'search' => $this->get_search_render($data['search']),
			'list'   => $this->get_list_render($data['list'])
		];
	}

	/**
	 *  Поиск.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_search_render($data = [])
	{
		return $this->Mustache->parse('pages/projects/list/templates/search', $data, TRUE);
	}

	// ------------------------------------------------------------------------

	/**
	 *  Обработка поискового запроса.
	 *  
	 *  @return  string
	 */
	private function get_search_query()
	{
		$result = NULL;

		// Получаем GET-запрос.
		$get = $this->input->get();

		// Проверяем наличие параметра 'q', в котором хранится поисковая строка.
		if (isset($get['q']))
		{
			// Очищаем поисковой запрос от грязи.
			$result = get_clear_string($get['q']);			

			if ($result == '')
			{
				redirect('/projects', 'refresh');
			}
		}

		return $result;
	}

	/**
	 *  Получение информации о поисковом запросе.
	 *  
	 *  @param   string  $query  [Запрос]
	 *  @return  array
	 */
	private function get_search_query_data($query = NULL)
	{
		$this->load->model('Projects_model');

		$data = [];

		if (!empty($query))
		{
			$data = $this->Projects_model->get_query_info($query);
		}

		return get_query_data($data);
	}
}

/* End of file List_controller.php */
/* Location: ./application/controllers/Projects/List_controller.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View_controller extends MY_Controller
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
	}

	// ------------------------------------------------------------------------

	/**
	 *  Главная страница.
	 *  
	 *  @return  void
	 */
	public function index($link = NULL)
	{
		// Подключение компонентов.
		$this->load();

		// Основная информация о проекте.
		$project = $this->get_project($link);

		// Вывод ошибки, если проект не найден.
		if ($project['id'] == 0)
		{
			show_404();
		}

		// Дополнительная информация.
		$profile   = $this->get_profile();
		$techs     = $this->get_project_techs($project['id']);
		$documents = $this->get_project_documents($project['id']);
		$tags      = $this->get_project_tags($project['id']);

		// Основной материал.
		$text = $project['text'];

		// Основной материал из файла.
		if ($project['file'])
		{
			$text = $this->Mustache->parse('pages/special/'.$project['id'].'/index', $project, TRUE);
		}

		// Данные для подстановки в шаблоны.
		$data = [
			'index' => [
				'this' => [
					'title'       => $this->get_title([$project['title'], 'Проекты']),
					'ogtitle'     => $project['title'],
					'description' => $project['description'],
					'url'         => site_url(uri_string(), 'https'),
					'name'        => $this->cfg['title'],
					'image'       => $project['image'],
					'type'        => FALSE
				],
				'styles' => [
					'version' => $this->cfg['version']
				],
				'header' => [
					'this'  => [
						'projects' => TRUE
					],
					'menu'  => $profile,
					'card'  => $project,
					'stats' => $project
				],
				'content' => [
					'this' => [],
					'project' => [
						'info'  => $project,
						'text'  => $text,
						'techs' => $techs,
						'tags'  => $tags,
						'files' => $documents
					]
				],
				'footer' => $profile,
				'scripts' => [
					'version' => $this->cfg['version']
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
			'card'  => $this->get_card_render($data['card']),
			'stats' => $this->get_stats_render($data['stats'])
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
		return $this->Mustache->parse('pages/projects/view/elements/menu', $data, TRUE);
	}

	/**
	 *  REBUILD/Основная информация.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_card_render($data = [])
	{
		return $this->Mustache->parse('pages/projects/view/elements/card', $data, TRUE);
	}

	/**
	 *  REBUILD/Статистика.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_stats_render($data = [])
	{
		return $this->Mustache->parse('pages/projects/view/elements/stats', $data, TRUE);
	}

	/**
	 *  REBUILD/Контент.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_content_render($data = [])
	{
		return $this->Mustache->parse('pages/projects/view/index', $this->get_content_components($data), TRUE);
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
			'project' => $this->get_project_render($data['project'])
		];
	}

	/**
	 *  REBUILD/Проект.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_project_render($data = [])
	{
		return $this->parse_code_in_text($this->Mustache->parse('pages/projects/view/templates/project', $data, TRUE));
	}

	// ------------------------------------------------------------------------

	/**
	 *  Получение информации о проекте.
	 *  
	 *  @param   string  $link  [Ссылка на проект]
	 *  @return  array
	 */
	private function get_project($link = NULL)
	{
		$this->load->model('Projects_model');

		$data = $this->Projects_model->get_by_link($link);
		$data = get_project_data($data);

		return $data;
	}

	/**
	 *  Список технологий проекта.
	 *  
	 *  @param   integer  $project_id  [ID проекта]
	 *  @return  array
	 */
	private function get_project_techs($project_id = 0)
	{
		$this->load->model('Skills_model');

		$data = $this->Skills_model->get_by_project_id($project_id);
		$data = get_skills_data($data);

		return $data;
	}

	/**
	 *  Список документов и файлов проекта.
	 *  
	 *  @param   integer  $project_id  [ID проекта]
	 *  @return  array
	 */
	private function get_project_documents($project_id = 0)
	{
		$this->load->model('Documents_model');

		$data = $this->Documents_model->get_by_project_id($project_id);
		$data = get_documents_data($data);

		return $data;
	}

	/**
	 *  Список меток проекта.
	 *  
	 *  @param   integer  $project_id  [ID проекта]
	 *  @return  array
	 */
	private function get_project_tags($project_id = 0)
	{
		$this->load->model('Tags_model');

		$data = $this->Tags_model->get_by_project_id($project_id);
		$data = get_tags_data($data);

		return $data;
	}

	// ------------------------------------------------------------------------

	/**
	 *  Обработка вставок кода таким образом, чтобы они воспринимались
	 *  как обычные строки. Это необходимо, чтобы плагин для подсветки
	 *  кода адекватно воспринимал вставки с HTML-кодом.
	 *  
	 *  @param   string  $text  [Контент]
	 *  @return  string
	 */
	private function parse_code_in_text($text = '')
	{
		$list = [];
		$iterator = 0;

		// Анонимная функция для парсинга вставок с кодом.
		$parser = function($matches = []) use (&$list, &$iterator)
		{
			// Запоминаем код для последующей вставки.
			$list[$iterator] = trim($matches[2]);
			
			// Возвращаем шаблон для будушей подстановки.
			return $matches[1].'{{'.($iterator++).'}}'.$matches[3];
		};

		$text = preg_replace_callback('#(<code[^>]*>)(.*?)(</code>)#uis', $parser, $text);
		$text = $this->Mustache->parse_string($text, $list, TRUE);

		return $text;
	}
}

/* End of file View_controller.php */
/* Location: ./application/controllers/Projects/View_controller.php */
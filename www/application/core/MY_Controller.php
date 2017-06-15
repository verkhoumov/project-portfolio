<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	/**
	 *  Параметры сайта.
	 *  
	 *  @var  array
	 */
	public $cfg = [];

	/**
	 *  Инициализация исходного контроллера.
	 */
	public function __construct()
	{
		parent::__construct();

		// Конфиги.
		$this->cfg = $this->config->item('site');
	}

	/**
	 *  Подключение всех обязательных зависимостей,
	 *  необходимых для работы сайта.
	 *  
	 *  @return  void
	 */
	protected function load()
	{
		// Парсинг шаблонов.
		$this->load->library('external/Mustache', NULL, 'Mustache');

		// Обработка сессии.
		$this->load->library('Sessions', NULL, 'Session');
		$this->Session->start();
	}

	/**
	 *  Вывод данных в формате JSON.
	 *  
	 *  @param   array    $data    [Данные]
	 *  @param   integer  $status  [Статус-код]
	 *  @return  void
	 */
	public function reply($data = [], $status = 200)
	{
		$data = (array) $data;
		$status = (integer) $status;

		$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($data))
			->_display();

		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 *  Заголовок страницы.
	 *  
	 *  @param   string/array  $data  [Один или несколько заголовков]
	 *  @return  string
	 */
	protected function get_title($title)
	{
		return get_title($title, $this->cfg['title'], $this->cfg['title_separator']);
	}

	/**
	 *  Описание страницы.
	 *  
	 *  @return  string
	 */
	protected function get_description()
	{
		return $this->cfg['description'];
	}

	// ------------------------------------------------------------------------

	/**
	 *  Компоненты главной страницы.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  array
	 */
	protected function get_index_components($data = [])
	{
		return $data['this'] + [
			'styles'  => $this->get_styles_render($data['styles']),
			'header'  => $this->get_header_render($data['header']),
			'content' => $this->get_content_render($data['content']),
			'footer'  => $this->get_footer_render($data['footer']),
			'scripts' => $this->get_scripts_render($data['scripts'])
		];
	}

	// ------------------------------------------------------------------------

	/**
	 *  Стили.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  array
	 */
	protected function get_styles_render($data = [])
	{
		return $this->Mustache->parse('styles', $data, TRUE);
	}

	// ------------------------------------------------------------------------

	/**
	 *  Шапка.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_header_render($data = [])
	{
		return $this->Mustache->parse('header', $this->get_header_components($data), TRUE);
	}

	/**
	 *  Компоненты от шапки.
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
	 *  Меню.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_menu_render($data = [])
	{
		return $this->Mustache->parse('menu', $data, TRUE);
	}

	/**
	 *  Основная информация.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_card_render($data = [])
	{
		return $this->Mustache->parse('pages/main/elements/card', $data, TRUE);
	}

	/**
	 *  Статистика.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_stats_render($data = [])
	{
		return $this->Mustache->parse('pages/main/elements/stats', $data, TRUE);
	}

	// ------------------------------------------------------------------------

	/**
	 *  Контент.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_content_render($data = [])
	{
		return $this->Mustache->parse('pages/main/index', $this->get_content_components($data), TRUE);
	}

	/**
	 *  Компоненты от контента.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  array
	 */
	protected function get_content_components($data = [])
	{
		return $data['this'] + [
			'about'     => $this->get_about_render($data['about']),
			'skills'    => $this->get_skills_render($data['skills']),
			'portfolio' => $this->get_portfolio_render($data['portfolio']),
			'whyiam'    => $this->get_whyiam_render($data['whyiam']),
			'feedback'  => $this->get_feedback_render($data['feedback'])
		];
	}

	/**
	 *  Блок "Обо мне".
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_about_render($data = [])
	{
		return $this->Mustache->parse('pages/main/templates/about', $data, TRUE);
	}

	/**
	 *  Блок "Навыки".
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_skills_render($data = [])
	{
		return $this->Mustache->parse('pages/main/templates/skills', $data, TRUE);
	}

	/**
	 *  Блок "Портфолио".
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_portfolio_render($data = [])
	{
		return $this->Mustache->parse('pages/main/templates/portfolio', $this->get_portfolio_components($data), TRUE);
	}

	/**
	 *  Компоненты от портфолио.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_portfolio_components($data = [])
	{
		return $data['this'] + [
			'list' => $this->get_list_render($data['list'])
		];
	}

	/**
	 *  Список проектов.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_list_render($data = [])
	{
		return $this->Mustache->parse('pages/main/elements/list', $data, TRUE);
	}

	/**
	 *  Блок "Почему я?".
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_whyiam_render($data = [])
	{
		return $this->Mustache->parse('pages/main/templates/whyiam', $data, TRUE);
	}

	/**
	 *  Блок "Обратная связь & Контакты".
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_feedback_render($data = [])
	{
		return $this->Mustache->parse('pages/main/templates/feedback', $data, TRUE);
	}

	// ------------------------------------------------------------------------

	/**
	 *  Подвал.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_footer_render($data = [])
	{
		return $this->Mustache->parse('footer', $data + ['year' => get_year()], TRUE);
	}

	// ------------------------------------------------------------------------

	/**
	 *  Скрипты.
	 *  
	 *  @param   array   $data  [Данные для подстановки в шаблоны]
	 *  @return  string
	 */
	protected function get_scripts_render($data = [])
	{
		return $this->Mustache->parse('scripts', $data, TRUE);
	}

	// ------------------------------------------------------------------------

	/**
	 *  Поиск проектов по заданному запросу.
	 *  
	 *  @param   string  $query       [Запрос]
	 *  @param   string  $query_type  [Тип запроса: год, технология и т.п.]
	 *  @param   string  $date        [Крайняя дата (для постраничного вывода)]
	 *  @return  array
	 */
	protected function search_projects($query = NULL, $query_type = 'default', $date = NULL)
	{
		$this->load->model('Projects_model');

		$stats = $this->Projects_model->get_stats();
		$data = $this->Projects_model->search($query, $query_type, $this->cfg['projects_per_page'], $date);
		$data = get_projects_data($data);
		$data = group_projects_search($data, $stats, $this->cfg['projects_per_page']);

		return $data;
	}

	/**
	 *  Получение информации о владельце сайта.
	 *  
	 *  @return  array
	 */
	protected function get_profile()
	{
		$this->load->model('Profile_model');

		$data = $this->Profile_model->get_data();
		$data = get_profile_data($data);

		return $data;
	}
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
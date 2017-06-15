<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap_controller extends MY_Controller
{
	/**
	 *  Пароль для доступа к обработчику.
	 *  
	 *  @var  string
	 */
	private $password = PRIVATE_SITEMAP_PASS;

	/**
	 *  Каталог, куда будут загружаться дочерние sitemap-файлы.
	 *  
	 *  @var  string
	 */
	private $sitemap_path = 'sitemap/';

	/**
	 *  Каталог, куда будет сохраняться основной sitemap-файл.
	 *  
	 *  @var  string
	 */
	private $sitemap_path_index = '';

	/**
	 *  Имя для sitemap-файлов.
	 *  
	 *  @var  string
	 */
	private $sitemap_name = 'sitemap';

	/**
	 *  Используется ли GZIP? (Адрес файлов будет другой)
	 *  
	 *  @var  boolean
	 */
	private $sitemap_gzip = FALSE;

	/**
	 *  Максимальное время выполнения скрипта - 10 минут.
	 */
	const SITEMAP_TIMELIMIT = 600;

	/**
	 *  Конструктор.
	 */
	public function __construct()
	{
		parent::__construct();
	}
   
	/**
	 *  Генерация карты сайта.
	 *  
	 *  @return  void
	 */
	public function index($password = '')
	{
		$this->load();

		if ($password != $this->password)
		{
			show_403();
		}

		$this->start();
	}

	/**
	 *  Инициализация построения карты сайта.
	 *  
	 *  @return  void
	 */
	private function start()
	{
		$this
			->Sitemap
			->setPath($this->get_path())               // Расположение основных sitemap-файлов.
			->setIndexPath($this->get_path_index())    // Расположение индексного sitemap-файла.
			->setFilename($this->get_sitemap_name())   // Имя для sitemap-файлов.
			->setGzipStatus($this->get_gzip_status())  // Файлы будут заархивированы, поэтому в индексном sitemap.xml надо указать ссылки на архивы.
			->clearSitemapFiles();                     // Удаление старых sitemap-файлов.

		// Генерация страниц сайта для sitemap-файлов.
		$this
			->get_main_pages()
			->get_projects_pages()
			->get_search_pages();
	
		// Создание sitemap-index-файла.
		// Первый параметр - путь до основных sitemap-файлов.
		$this->Sitemap->createSitemapIndex(site_url(NULL, 'https') . $this->get_path(), 'Today');
	}

	// ------------------------------------------------------------------------

	/**
	 *  Добавление основных страниц сайта в Sitemap.
	 *  
	 *  @return  $this
	 */
	private function get_main_pages()
	{
		// Главная страница.
		$this->Sitemap->addItem('', '1.0', 'weekly', 'Today');

		// Остальные страницы.
		$this->Sitemap->addItem('projects', '0.85', 'weekly', 'Today');

		return $this;
	}

	/**
	 *  Добавление страниц со списком проектов.
	 *  
	 *  @return  $this
	 */
	private function get_projects_pages()
	{
		$projects = $this->get_projects();

		if (!empty($projects))
		{
			foreach ($projects as $project)
			{
				if (empty($project['link']))
				{
					continue;
				}

				$this->Sitemap->addItem('projects/'.$project['link'], '0.75', 'monthly', $project['created']);
			}
		}

		return $this;
	}

	/**
	 *  Добавление страниц с поисковыми запросами (категории, технологии, метки).
	 *  
	 *  @return  $this
	 */
	private function get_search_pages()
	{
		$queries = $this->get_search_queries();

		if (!empty($queries))
		{
			foreach ($queries as $query)
			{
				if (empty($query['code']))
				{
					continue;
				}

				$this->Sitemap->addItem('projects?q='.$query['code'], '0.5', 'weekly', 'Today');
			}
		}

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 *  Загрузка списка проектов из базы данных.
	 *  
	 *  @return  array
	 */
	private function get_projects()
	{
		return $this->Projects_model->get(['visible' => 1], ['finished' => 'DESC']);
	}

	/**
	 *  Загрузка списка поисковых запросов из базы данных.
	 *  
	 *  @return  array
	 */
	private function get_search_queries()
	{
		return $this->Projects_model->get_search_queries();
	}

	// ------------------------------------------------------------------------

	/**
	 *  Где будут хранится основные карты сайта.
	 *  
	 *  @return string
	 */
	protected function get_path()
	{
		return (string) $this->sitemap_path;
	}

	/**
	 *  Где будет хранится индексная карта сайта.
	 *  
	 *  @return string
	 */
	protected function get_path_index()
	{
		return (string) $this->sitemap_path_index;
	}

	/**
	 *  Имя для карты сайта.
	 *  
	 *  @return string
	 */
	protected function get_sitemap_name()
	{
		return (string) $this->sitemap_name;
	}

	/**
	 *  Включён ли GZIP.
	 *  
	 *  @return boolean
	 */
	protected function get_gzip_status()
	{
		return (boolean) $this->sitemap_gzip;
	}

	// ------------------------------------------------------------------------
	
	/**
	 *  Подключение зависимостей.
	 *  
	 *  @return  void
	 */
	protected function load()
	{
		// Ограничение по времени.
		set_time_limit(self::SITEMAP_TIMELIMIT);

		// Подключение библиотеки для создания Sitemap.xml.
		$this->load->library('external/Sitemap', ['url' => site_url(NULL, 'https')], 'Sitemap');

		// Модель для работы с проектами и поисковыми запросами.
		$this->load->model('Projects_model');
	}
}

/* End of file Sitemap_controller.php */
/* Location: ./application/controllers/Cron/Sitemap_controller.php */
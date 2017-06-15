<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  Добавлен хулпер с дополнительными функциями вызова
 *  страниц с ошибками.
 */
class MY_Exceptions extends CI_Exceptions
{
	/**
	 *  Параметры сайта.
	 *  
	 *  @var  array
	 */
	protected $config = [];

	/**
	 *  Mustache handler.
	 *  
	 *  @var  link
	 */
	protected $Mustache;

	/**
	 *  Параметры Mustache.
	 *  
	 *  @var  array
	 */
	protected $mustache_config = [];

	/**
	 *  Шаблон для вывода ошибки.
	 *  
	 *  @var  string
	 */
	protected $content_file = 'pages/errors/error_general/index';

	/**
	 *  Инициализация исходного контроллера.
	 */
	public function __construct()
	{
		parent::__construct();

		// Подключение сторонних компонентов.
		$this->load();
	}

	/**
	 *  Подключение всех обязательных зависимостей,
	 *  необходимых для обработки запроса.
	 *  
	 *  @return  void
	 */
	protected function load()
	{
		// Параметры сайта.
		$this->config = $this->get_config();

		// Основной хелпер.
		$this->get_helper();

		// Шаблонизатор Mustache.
		$this->mustache();
	}

	// ------------------------------------------------------------------------

	/**
	 *  Обработчик для вывода ошибки об ошибке сервера.
	 *  
	 *  @param   string  $reason  [Причина]
	 *  @return  void
	 */
	public function show_401($reason = '')
	{
		// Параметры страницы.
		$heading = 'Нет авторизации';
		$message = 'Во время авторизации произошла неизвестная ошибка. Если ошибка повторится, пожалуйста, свяжитесь со мной через форму <a href="/#feedback" class="underline">обратной связи</a>.';

		// Изменением причины на пользовательскую.
		if (!empty($reason))
		{
			$message = $reason;
		}

		// Вывод ошибки на экран.
		echo $this->show_error($heading, $message, 'error_401', 401);
		exit(1); // EXIT_ERROR
	}

	/**
	 *  Обработчик для вывода ошибки о запрете
	 *  доступа к странице (Forbidden).
	 *  
	 *  @param   string  $reason  [Причина]
	 *  @return  void
	 */
	public function show_403($reason = '')
	{
		// Параметры страницы.
		$heading = 'Доступ запрещён';
		$message = 'Доступ к запрашиваемой странице запрещён на общих или специальных основаниях.';

		// Изменением причины на пользовательскую.
		if (!empty($reason))
		{
			$message = $reason;
		}

		// Вывод ошибки на экран.
		echo $this->show_error($heading, $message, 'error_403', 403);
		exit(1); // EXIT_ERROR
	}

	/**
	 *  Обработчик для вывода уведомления о том, что страницы
	 *  не была найдена.
	 *  
	 *  @param   string   $page       [Адрес страницы]
	 *  @param   boolean  $log_error  [Логирование]
	 *  @return  void
	 */
	public function show_404($page = '', $log_error = TRUE)
	{
		// Параметры страницы.
		$heading = 'Страница не найдена';
		$message = 'Запрашиваемвая страница не найдена. Возможно страница удалена или ещё не была создана.';

		// Логирование ошибки.
		if ($log_error)
		{
			log_message('error', 'Page not found: '.$page);
		}

		// Вывод ошибки на экран.
		echo $this->show_error($heading, $message, 'error_404', 404);
		exit(4); // EXIT_UNKNOWN_FILE
	}

	// ------------------------------------------------------------------------

	/**
	 *  Подготовка данных, создание сообщения об ошибке.
	 *  
	 *  @param   string         $heading      [Заголовок]
	 *  @param   string|array   $message      [Сообщение]
	 *  @param   string         $template     [Шаблон]
	 *  @param   integer        $status_code  [Код ошибки]
	 *  @return  string
	 */
	public function show_error($heading, $message, $template = 'error_general', $status_code = 500)
	{
		// Код ошибки.
		set_status_header($status_code);

		// Параметры страницы.
		$page = [
			'title' => $this->get_title($heading),
			'description' => strip_tags($this->remove_path_name((is_array($message) ? implode(' ', $message) : $message)))
		];

		// Данные для подстановки.
		$data = [
			'header' => [
				'image' => $this->config['profile']['image'],
				'name' => $this->config['profile']['name'],
				'profession' => $this->config['profile']['profession']
			],
			'content' => [
				'title' => $heading,
				'description' => $this->remove_path_name((is_array($message) ? implode('</p><p>', $message) : $message))
			],
			'footer' => [
				'link' => $this->config['profile']['link'],
				'name' => $this->config['profile']['name'],
				'year' => get_year()
			]
		];

		return $this->set_content_file($template)->get_index_render($page, $data);
	}

	/**
	 *  Вывод исключений.
	 *  
	 *  @param   Exception  $exception  [Исключение]
	 *  @return  void
	 */
	public function show_exception($exception)
	{
		// Данные для подстановки.
		$data = [
			'title'     => 'Произошло исключение',
			'type'      => get_class($exception),
			'message'   => $this->remove_path_name($exception->getMessage()),
			'file'      => $this->remove_path_name($exception->getFile()),
			'line'      => $exception->getLine(),
			'backtrace' => $this->get_backtrace($exception->getTrace())
		];

		echo $this->set_content_file('error_exception')->get_content_render($data);
	}

	/**
	 *  Вывод стандартных ошибок интерпретатора.
	 *  
	 *  @param   integer  $severity  [Важность]
	 *  @param   string   $message   [Сообщение]
	 *  @param   string   $filepath  [Файл]
	 *  @param   integer  $line      [Строка]
	 *  @return  void
	 */
	public function show_php_error($severity, $message, $filepath, $line)
	{
		// Данные для подстановки.
		$data = [
			'title'     => 'Произошла ошибка',
			'severity'  => $severity,
			'message'   => $this->remove_path_name($message),
			'file'      => $this->remove_path_name($filepath),
			'line'      => $line,
			'backtrace' => $this->get_backtrace(debug_backtrace())
		];

		$result = $this->set_content_file('error_php')->get_content_render($data);

		if (strpos($result, 'Fatal') === FALSE)
		{
			echo $result;
		}
	}

	/**
	 *  Формирование бэктрейса ошибки.
	 *  
	 *  @param   Exception|debug_backtrace()  $exception  [Исключение]
	 *  @return  array
	 */
	private function get_backtrace($exception)
	{
		$result = [];

		if (!empty($exception) && defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE)
		{
			foreach ($exception as $error)
			{
				if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0)
				{
					$result[] = [
						'file'     => $this->remove_path_name($error['file']),
						'line'     => $error['line'],
						'function' => $error['function']
					];
				}
			}
		}

		return $result;
	}

	/**
	 *  Очистка строки от имени корневого каталога.
	 *  
	 *  @param   string  $string  [Строка]
	 *  @return  string
	 */
	private function remove_path_name($string = '')
	{
		return str_replace(get_site_path(), '', $string);
	}

	// ------------------------------------------------------------------------

	/**
	 *  Установка пути до шаблона для вывода ошибки.
	 *  
	 *  @param  string  $template  [Имя шаблона]
	 */
	private function set_content_file($template = '')
	{
		$this->content_file = "pages/errors/{$template}/index";

		return $this;
	}

	/**
	 *  Сборка основного шаблона.
	 *  
	 *  @param   array   $data  [Данные для подстановки]
	 *  @return  string
	 */
	private function get_index_render($page = [], $data = [])
	{
		return $this->parse('pages/errors/index', $page + $this->template($data));
	}

	/**
	 *  Основные компоненты страницы.
	 *  
	 *  @param   array   $data  [Данные для подстановки]
	 *  @return  array
	 */
	private function template($data = [])
	{
		return [
			'header'  => $this->get_header_render($data['header']),
			'content' => $this->get_content_render($data['content']),
			'footer'  => $this->get_footer_render($data['footer'])
		];
	}

	// ------------------------------------------------------------------------

	/**
	 *  Шаблон ошибки.
	 *  
	 *  @param   array   $data  [Данные для подстановки]
	 *  @return  string
	 */
	private function get_content_render($data = [])
	{
		return $this->parse($this->content_file, $data);
	}

	/**
	 *  Шаблон шапки сайта.
	 *  
	 *  @param   array   $data  [Данные для подстановки]
	 *  @return  string
	 */
	private function get_header_render($data = [])
	{
		return $this->parse('pages/errors/header', $this->_get_header_render($data));
	}

	private function _get_header_render($data = [])
	{
		return $data;
	}

	/**
	 *  Шаблон подвала сайта.
	 *  
	 *  @param   array   $data  [Данные для подстановки]
	 *  @return  string
	 */
	private function get_footer_render($data = [])
	{
		return $this->parse('pages/errors/footer', $this->_get_footer_render($data));
	}

	private function _get_footer_render($data = [])
	{
		return $data;
	}

	// ------------------------------------------------------------------------

	/**
	 *  Получение параметров сайта из конфига.
	 *  
	 *  @return  array
	 */
	private function get_config()
	{
		$config = [];

		require APPPATH.'config/site.php';

		return $config['site'];
	}

	/**
	 *  Подключение основного хелпера.
	 *  
	 *  @return  void
	 */
	private function get_helper()
	{
		if (!function_exists('_site_helper_load_before_exception'))
		{
			require APPPATH.'helpers/site_helper.php';
		}
	}

	/**
	 *  Заголовок страницы.
	 *  
	 *  @param   string/array  $data  [Один или несколько заголовков]
	 *  @return  string
	 */
	protected function get_title($title)
	{
		return get_title($title, $this->config['title'], $this->config['title_separator']);
	}

	// ------------------------------------------------------------------------

	/**
	 *  Подключение компонентов Mustache.
	 *  
	 *  @return  void
	 */
	private function mustache()
	{
		// Подключение обработчика библиотеки Mustache.
		require_once APPPATH.'third_party/Mustache/Autoloader.php';

		// Запуск Mustache.
		Mustache_Autoloader::register();

		// Объект для работы с библиотекой Mustache.
		$this->Mustache = new Mustache_Engine($this->mustache_config);
	}

	/**
	 *  Парсинг шаблона с помощью библиотеки Mustache.
	 *  
	 *  @param   string  $template  [Шаблон]
	 *  @param   array   $data      [Данные для подстановки]
	 *  @return  string
	 */
	private function parse($template = '', $data = [])
	{
		// Шаблон.
		$template = $this->get_template_file($template);

		// Парсинг шаблона с помощью Mustache.
		$template = $this->Mustache->render($template, $data);

		// Возвращение обработанного шаблона в переменную.
		return $template;
	}

	/**
	 *  Получение содержимого шаблона для последующего парсинга.
	 *  
	 *  @param   string  $template  [Шаблон]
	 *  @return  string
	 */
	private function get_template_file($template = '')
	{
		$template_path = VIEWPATH.$template.'.php';

		// Уровень буферизации.
		if (ob_get_level() > $this->ob_level + 1)
		{
			ob_end_flush();
		}

		// Буферизация.
		ob_start();

		// Подключение шаблона в буфер для вывода в строку.
		include($template_path);

		// Содержимое шаблона.
		$buffer = ob_get_contents();

		ob_end_clean();

		// Возвращение загруженного файла.
		return $buffer;
	}
}

/* End of file MY_Exceptions.php */
/* Location: ./application/core/MY_Exceptions.php */
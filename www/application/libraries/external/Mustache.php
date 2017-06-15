<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  Класс для подмены стандартного парсера CodeIgniter
 *  на мультиязычный шаблонизатор Mustache.
 */
class Mustache
{
	/**
	 *  CodeIgniter handler.
	 *  
	 *  @var  $this
	 */
	protected $CodeIgniter;

	/**
	 *  Mustache handler.
	 *  
	 *  @var  $this
	 */
	protected $Mustache;

	/**
	 *  Mustache config data.
	 *  
	 *  @var  array
	 */
	protected $config = [];

	/**
	 *  Library constructor.
	 */
	public function __construct($config = [])
	{
		$this->CodeIgniter = &get_instance();

		$this->config = (array) $config;

		// Инициализация
		$this->start();
	}

	/**
	 *  Парсер шаблонов через библиотеку Mustache.
	 *  
	 *  @param   string   $template  [Шаблон]
	 *  @param   array    $data      [Данные для подскановки]
	 *  @param   boolean  $return    [Надо ли вернуть шаблон в виде строки?]
	 *  @return  string/boolean
	 */
	public function parse($template, $data = [], $return = FALSE)
	{
		$template = $this->CodeIgniter->load->view($template, $data, TRUE);

		return $this->_parse($template, $data, $return);
	}

	/**
	 *  Парсер текста через библиотеку Mustache.
	 *  
	 *  @param   string   $string    [Строка]
	 *  @param   array    $data      [Данные для подскановки]
	 *  @param   boolean  $return    [Надо ли вернуть шаблон в виде строки?]
	 *  @return  string/boolean
	 */
	public function parse_string($string, $data = [], $return = FALSE)
	{
		return $this->_parse($string, $data, $return);
	}

	public function load($template, $return = FALSE)
	{
		return $this->CodeIgniter->load->view($template, NULL, $return);
	}

	// ------------------------------------------------------------------------
	
	/**
	 *  Инициализация библиотеки.
	 *  
	 *  @return  void
	 */
	private function start()
	{
		$this->mustache();
	}

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
		$this->Mustache = new Mustache_Engine($this->config);
	}

	/**
	 *  Парсер.
	 *  
	 *  @param   string   $template  [Шаблон]
	 *  @param   array    $data      [Данные для подскановки]
	 *  @param   boolean  $return    [Надо ли вернуть шаблон в виде строки?]
	 *  @return  string/boolean
	 */
	private function _parse($template, $data = [], $return = FALSE)
	{
		if ($template === '')
		{
			return FALSE;
		}

		// Парсинг шаблона с помощью Mustache.
		$template = $this->Mustache->render($template, $data);

		// Добавление обработанного шаблона в поток для
		// последующего вывода на экран.
		if ($return === FALSE)
		{
			$this->CodeIgniter->output->append_output($template);
		}

		// Возвращение обработанного шаблона в переменную.
		return $template;
	}
}

/* End of file Mustache.php */
/* Location: ./application/libraries/Mustache.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Проверяем, загружался ли уже данный хелпер.
if (function_exists('_site_helper_load_before_exception'))
{
	return;
}

/**
 *  Специальная функция, по которой можно узнать был ли загружен
 *  данный хелпер до выброса исключения.
 *  
 *  @return  void
 */
function _site_helper_load_before_exception() {}

/**
 *  Получение данных из файла конфигурации.
 *  
 *  @return  array
 */
function config($key = NULL)
{
	$CodeIgniter = &get_instance();

	// Параметры конфига.
	$result = $CodeIgniter->config->item('site');

	if (isset($key) && is_string($key) && array_key_exists($key, $result))
	{
		$result = $result[$key];
	}

	return $result;
}

/**
 *  Генерация заголовка страницы.
 *  
 *  @param   string/array  $page_title  [Заголовок текущей страницы]
 *  @param   string        $site_title  [Бренд]
 *  @param   string        $separator   [Разделитель]
 *  @return  string
 */
function get_title($title, $brand = '', $separator = ' — ')
{
	$title_list = [];
	$result = 'Страница не определена';

	// Обработка заголовка текушей страницы.
	if (!empty($title))
	{
		if (is_string($title) || is_numeric($title))
		{
			$title_list[] = get_clear_string($title);
		}
		elseif (is_array($title))
		{
			foreach ($title as $value)
			{
				$title_list[] = get_clear_string($value);
			}
		}
	}

	// Обработка названия бренда.
	if (!empty($brand))
	{
		$title_list[] = get_clear_string($brand);
	}

	// Формирование итогового заголовка страницы.
	if (!empty($title_list))
	{
		$result = implode($separator, $title_list);
	}

	return $result;
}

/**
 *  Обработка строки.
 *  
 *  @param   string  $string  [Строка]
 *  @return  string
 */
function get_string($string = '')
{
	$string = (string) $string;

	return trim($string);
}

/**
 *  Очистка строки.
 *  
 *  @param   string  $string  [Строка]
 *  @return  string
 */
function get_clear_string($string = '')
{
	return htmlspecialchars(get_string($string), ENT_QUOTES);
}

/**
 *  Текущий год.
 *  
 *  @return  string
 */
function get_year()
{
	$date = new DateTime();

	return $date->format('Y');
}

/**
 *  Основной каталог проекта.
 *
 *  @return  string
 */
function get_site_path()
{
	return str_replace('system/', '', BASEPATH);
}

/**
 *  Сравнение двух массивов, поиск отличий. В качестве ответа
 *  возвращает список параметров, которые есть в $new, но нету в $old.
 *  
 *  @param   array   $new  [Массив с новой информацией]
 *  @param   array   $old  [Массив со старой информацией]
 *  @return  array
 */
function get_array_changes($new = [], $old = [])
{
	$new = (array) $new;
	$old = (array) $old;

	if (!empty($new))
	{
		foreach ($new as $key => $value)
		{
			if (is_array($value))
			{
				if (!isset($old[$key]))
				{
					$difference[$key] = $value;
				}
				elseif (!is_array($old[$key]))
				{
					$difference[$key] = $value;
				}
				else
				{
					$new_diff = get_array_changes($value, $old[$key]);

					if ($new_diff != FALSE)
					{
						$difference[$key] = $new_diff;
					}
				}
			}
			elseif (!isset($old[$key]) || $old[$key] != $value)
			{
				$difference[$key] = $value;
			}
		}
	}

	return isset($difference) ? $difference : [];
}

/**
 *  Фильтрация данных массива по переданному списку ключей.
 *  Функция возвращает массив только с теми элементами, которые
 *  перечислены в аргументе `$filter_by`.
 *
 *  @example   filter_array(['a' => 1, 'b' => 2, 'c' => 3], ['b', 'c']) => ['b' => 2, 'c' => 3]
 *  
 *  @param   array   $data       [Массив]
 *  @param   array   $filter_by  [Ключи массива, которые надо оставить]
 *  @return  array
 */
function filter_array($data = [], $filter_by = [])
{
	$data = (array) $data;
	$filter_by = (array) $filter_by;

	$result = [];

	if (!empty($data) && !empty($filter_by))
	{
		foreach ($filter_by as $key)
		{
			if (array_key_exists($key, $data))
			{
				$result[$key] = $data[$key];
			}
		}
	}

	return $result;
}

/**
 *  Группировка массива по заданному полю.
 *  
 *  @param   array   $data      [Исходный массив]
 *  @param   string  $group_by  [Имя поля, по которому будет выполняться группировка]
 *  @param   string  $identity  [Имя поля, по которому будет строится массив в группе]
 *  @return  array
 */
function group_array($data = [], $group_by = '', $identity = '')
{
	$data = (array) $data;
	$group_by = (string) $group_by;
	$identity = (string) $identity;

	$result = [];

	if (!empty($data) && $group_by != '')
	{
		foreach ($data as $key => $value)
		{
			// Если массив не содержит запрашиваемый ключ, отменяем группировку.
			if (!array_key_exists($group_by, $value))
			{
				break;
			}

			// При группировке можно также указать поле, которое будет
			// использоваться как ключ записи.
			if ($identity != '')
			{
				$result[$value[$group_by]][$value[$identity]] = $value;
			}
			else
			{
				$result[$value[$group_by]][] = $value;
			}
		}
	}

	return $result;
}

/**
 *  Замена ключей массива на новые.
 *  
 *  @param   array   $array  [Исходный массив]
 *  @param   array   $keys   [Ключи]
 *  @return  array
 */
function array_keys_changer($array = [], $keys = [])
{
	$array = (array) $array;
	$keys = (array) $keys;

	if (!empty($array) && !empty($keys))
	{
		foreach ($keys as $old_key => $new_key)
		{
			if (isset($array[$old_key]))
			{
				// Перезаписываем данные под новым ключем.
				$array[$new_key] = $array[$old_key];

				// Удаляем старый ключ.
				unset($array[$old_key]);
			}
		}
	}

	return $array;
}

/**
 *  Проверка на наличие нескольких ключей в массиве.
 *  
 *  @param   array    $keys   [Список ключей]
 *  @param   array    $array  [Масив]
 *  @return  boolean
 */
function array_keys_exists($keys = [], $array = [])
{
	$keys = (array) $keys;
	$array = (array) $array;

	if (!empty($keys) && !empty($array))
	{
		foreach ($keys as $key)
		{
			if (!array_key_exists($key, $array))
			{
				return FALSE;
			}
		}
	}
	else
	{
		return FALSE;
	}

	return TRUE;
}

/**
 *  Склонение слова по указанному числу.
 *
 *  NOTE: {n} - число, {w} - слово.
 *  
 *  @param   integer  $number  [Число]
 *  @param   string   $words   [Список слов или формат по-умолчанию]
 *  @param   string   $format  [Формат построения результата]
 *  @return  [type]
 */
function get_noun_word($number = 0, $words = 'ruble', $format = '{n} {w}')
{
	$number = (float) $number;

	// Список доступных по-умолчанию наборов слов.
	$words_list = [
		'ruble'   => ['рубль', 'рубля', 'рублей'],
		'project' => ['проект', 'проекта', 'проектов'],
		'years'   => ['год', 'года', 'лет']
	];

	if (is_string($words))
	{
		$words = $words_list[$words];
	}
	else
	{
		$words = (array) $words;
	}	

	// Округляем число в меньшую сторону и определяем индекс
	// слова в списке слов.
	$_number = floor($number);
	$index = get_noun_word_index($_number);

	// Шаблон, по которому будут произведены замены.
	$pattern = [
		'{n}' => $number,
		'{w}' => $words[$index]
	];

	foreach ($pattern as $key => $value)
	{
		$format = str_replace($key, $value, $format);
	}

	return $format;
}

/**
 *  Выбор склонения слова по числу.
 *  
 *  @param   integer  $number  [Число]
 *  @return  integer
 */
function get_noun_word_index($number = 0)
{
	$number = (integer) $number;

	$result = 2;

	// Результат: 5 яблок.
	$number %= 100;

	if ($number >= 5 && $number <= 20)
	{
		$result = 2;
	}

	// Результат: 1 яблоко.
	$number %= 10;

	if ($number == 1)
	{
		$result = 0;
	}

	// Результат: 2 яблока.
	if ($number >= 2 && $number <= 4)
	{
		$result = 1;
	}

	return $result;
}

/**
 *  Обработчик даты на русском языке.
 *  
 *  @param   string  $date    [Дата в любом формате]
 *  @param   string  $format  [Формат итоговой даты]
 *  @return  string
 */
function get_date($date = '', $format = 'j {m} в H:i', $size = 's')
{
	$date   = (string) $date;
	$format = (string) $format;

	$time = $date != '' ? strtotime($date) : time();

	$monthsA = [1 => 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
	$monthsB = [1 => 'январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь'];

	// Кастомные шаблоны.
	$pattern = [
		'{m}'  => $monthsA[date('n', $time)], 
		'{mm}' => $monthsB[date('n', $time)]
	];

	// Если надо сделать название месяца с большой буквы.
	if ($size == 'b')
	{
		foreach ($pattern as $key => $value)
		{
			$pattern[$key] = mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
		}
	}

	// Обработка кастомных шаблонов.
	foreach ($pattern as $key => $value)
	{
		$format = str_replace($key, $value, $format);
	}
	
	return date($format, $time);
}

/**
 *  Проверка, является ли строка ссылкой.
 *  
 *  @param   string   $string  [Строка]
 *  @return  boolean
 */
function is_image_link($string = '')
{
	$string = (string) $string;

	if (strpos($string, 'http://') !== FALSE)
	{
		return TRUE;
	}

	return FALSE;
}

/**
 *  Проверка, является переданная строка именем изображения.
 *  
 *  @param   string   $string  [Имя изображения]
 *  @return  boolean
 */
function is_image_name($string = '')
{
	$string = (string) $string;

	$formats = ['.jpg', '.png', '.gif'];

	foreach ($formats as $format)
	{
		if (strpos($string, $format) !== FALSE)
		{
			return TRUE;
		}
	}

	return FALSE;
}

/**
 *  Генерация ссылки на изображение.
 *  
 *  @param   string  $image  [Изображение]
 *  @param   string  $type   [Тип изображения]
 *  @return  string
 */
function get_image($image = '', $type = '')
{
	$image = get_clear_string($image);
	$type  = get_clear_string($type);

	// Если изображение представлено ссылкой.
	if (is_image_link($image))
	{
		return $image;
	}

	// Изображение по-умолчанию.
	$path = 'resources/img/default.png';

	// Валидные типы изображений.
	$types = ['education', 'skills', 'profile', 'projects', 'video'];

	// Проверка изображения.
	if (is_image_name($image) && in_array($type, $types))
	{
		$path = "upload/images/{$type}/{$image}";
	}

	return site_url(NULL, 'https').$path;
}

/* End of file site_helper.php */
/* Location: ./application/helpers/site_helper.php */
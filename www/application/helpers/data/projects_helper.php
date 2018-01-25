<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  Обработка информации о проектах.
 *  
 *  @param   array   $data  [Проекты]
 *  @return  array
 */
function get_projects_data($data = [])
{
	$data = (array) $data;
	
	$result = [];

	if (!empty($data))
	{
		foreach ($data as $key => $value)
		{
			$result[$key] = get_project_data($value);
		}
	}

	return $result;
}

/**
 *  Обработанные данные.
 *  
 *  @param   array   $data  [Данные]
 *  @return  array
 */
function get_project_data($data = [])
{
	$data = (array) $data;

	$result = get_default_project_data();

	if (isset($data['id']) && $data['id'] > 0)
	{
		$result['id'] = (integer) $data['id'];
	}

	if (isset($data['category_id']) && $data['category_id'] > 0)
	{
		$result['category_id'] = (integer) $data['category_id'];
	}

	if (isset($data['category_link']) && $data['category_link'] != '')
	{
		$result['category_link'] = get_category_link($data['category_link']);
	}

	if (isset($data['category_name']) && $data['category_name'] != '')
	{
		$result['category_name'] = get_string($data['category_name']);
	}

	if (isset($data['name']) && $data['name'] != '')
	{
		$result['name'] = get_string($data['name']);
	}

	if (isset($data['title']) && $data['title'] != '')
	{
		$result['title'] = get_string($data['title']);
	}

	if (isset($data['description']) && $data['description'] != '')
	{
		$result['description'] = get_string($data['description']);
	}

	if (isset($data['link']) && $data['link'] != '')
	{
		$result['link'] = get_project_link($data['link']);
	}

	if (isset($data['text']) && $data['text'] != '')
	{
		$result['text'] = get_string($data['text']);
	}

	if (isset($data['file']) && $data['file'] > 0)
	{
		$result['file'] = TRUE;
	}

	if (isset($data['image']) && $data['image'] != '')
	{
		$result['image'] = get_string($data['image']);
	}

	$result['image'] = get_image($result['id'].'/'.$result['image'], 'projects');

	if (isset($data['year']) && $data['year'] > 0)
	{
		$result['year'] = (integer) $data['year'];
	}

	if (isset($data['started']) && $data['started'] != '')
	{
		$result['started'] = get_string($data['started']);
	}

	if (isset($data['finished']) && $data['finished'] != '')
	{
		$result['finished'] = get_string($data['finished']);

		// Исходная дата завершения проекта, используемая для
		// постраничного поиска материалов.
		$result['_finished'] = $result['finished'];
	}

	if (isset($result['started']) && isset($result['finished']))
	{
		$now = time();
		$start = strtotime($result['started']);
		$finish = strtotime($result['finished']);

		// Заменяем даты на нормальные.
		$result['started'] = get_date($result['started'], 'j {m}, Y');
		$result['finished'] = get_date($result['finished'], 'j {m}, Y');

		// Определяем прогресс выполнения проекта.
		if ($now < $finish)
		{
			$result['percent'] = $now < $start ? 0 : floor(($now - $start) / ($finish - $start) * 100);
			$result['progress'] = $result['percent'] > 0 ? 'Выполнен на '.$result['percent'].'%' : 'Разработка запланирована на '.$result['started'];
		}
	}

	if (isset($data['personal']) && $data['personal'] > 0)
	{
		$result['personal'] = TRUE;
	}

	if (isset($data['example']) && $data['example'] != '')
	{
		$result['example'] = get_string($data['example']);
	}

	if (isset($data['github']) && $data['github'] != '')
	{
		$result['github'] = get_string($data['github']);
		$result['githubName'] = get_github_name($result['github']);
	}

	if (isset($data['login']) && $data['login'] != '')
	{
		$result['login'] = get_string($data['login']);
	}

	if (isset($data['password']) && $data['password'] != '')
	{
		$result['password'] = get_string($data['password']);
	}

	if (isset($data['created']) && $data['created'] != '')
	{
		$result['created'] = get_string($data['created']);
	}

	if (isset($result['created']))
	{
		$result['created'] = get_date($result['created'], 'j {m} в H:i');
	}

	if (isset($data['visible']) && $data['visible'] > 0)
	{
		$result['visible'] = TRUE;
	}

	return $result;
}

/**
 *  Данные по-умолчанию.
 *  
 *  @return  array
 */
function get_default_project_data()
{
	return [
		'id'            => 0,
		'category_id'   => 0,
		'category_link' => NULL,
		'category_name' => NULL,
		'name'          => NULL,
		'title'         => NULL,
		'description'   => NULL,
		'link'          => NULL,
		'text'          => NULL,
		'file'          => FALSE,
		'image'         => NULL,
		'year'          => 0,
		'started'       => NULL,
		'finished'      => NULL,
		'_finished'     => NULL,
		'percent'       => 0,
		'progress'      => FALSE,
		'personal'      => FALSE,
		'example'       => NULL,
		'github'        => NULL,
		'githubName'    => NULL,
		'login'         => NULL,
		'password'      => NULL,
		'created'       => NULL,
		'visible'       => FALSE
	];
}

// ------------------------------------------------------------------------

/**
 *  Группировка списка проектов для главной страницы.
 *  
 *  @param   array   $data   [Список проектов]
 *  @param   array   $stats  [Количество проектов за каждый год]
 *  @return  array
 */
function group_projects_list($data = [], $stats = [])
{
	$data = (array) $data;
	$stats = (array) $stats;

	$result   = [];
	$years    = [];
	$iterator = -1;

	if (!empty($data))
	{
		foreach ($data as $key => $value)
		{
			$value = filter_array($value, [
				'category_link', 'category_name', 'name', 'link', 'image', 'year', 
				'created', 'description', 'text', '_finished', 'finished', 'percent', 'progress', 'personal'
			]);

			// Общее количество проектов за год.
			$projects_count = $stats[$value['year']]['count'];

			// Проверяем наличие года в списке.
			if (!array_key_exists($value['year'], $years))
			{
				++$iterator;

				$result[$iterator] = [
					'year'  => $value['year'],
					'count' => get_noun_word($projects_count, 'project'),
					'items' => [],
					'loadMore' => [
						'status' => $projects_count > 5 ? TRUE : FALSE,
						'count'  => $projects_count > 5 ? get_noun_word($projects_count - 5, 'project') : 0
					]
				];

				$result[$iterator]['items'][] = $value;
				$years[$value['year']] = $iterator;
			}
			else
			{
				// Предотвращаем добавление 6-ого проекта, так как он
				// нужен только для детектирования возможности загрузки
				// других проектов.
				if (count($result[$iterator]['items']) >= 5)
				{
					continue;
				}

				$result[$iterator]['items'][] = $value;
			}
		}
	}

	return $result;
}

/**
 *  Группировка списка проектов для страницы поиска.
 *  
 *  @param   array    $data   [Списко проектов]
 *  @param   array    $stats  [Количество проектов за каждый год]
 *  @param   integer  $limit  [Ограничение проектов за 1 запрос]
 *  @return  array
 */
function group_projects_search($data = [], $stats = [], $limit = 0)
{
	$data = (array) $data;
	$stats = (array) $stats;

	$result = [
		'projects' => [],
		'more' => [
			'status' => FALSE,
			'date'   => NULL
		]
	];

	$years    = [];
	$iterator = -1;
	$counter  = 0;

	if (!empty($data))
	{
		foreach ($data as $value)
		{
			$value = filter_array($value, [
				'category_link', 'category_name', 'name', 'description', 'link', 'image', 'year', 
				'_finished', 'finished', 'percent', 'progress', 'personal'
			]);

			// Предотвращаем добавление последнего проекта, так как он
			// нужен только для детектирования возможности загрузки
			// ещё одной страницы.
			if ($limit > 0 && ++$counter > $limit)
			{
				$result['more'] = [
					'status' => TRUE,
					'date'   => $value['_finished']
				];

				break;
			}

			// Общее количество проектов за год.
			$projects_count = $stats[$value['year']]['count'];

			// Проверяем наличие года в списке.
			if (!array_key_exists($value['year'], $years))
			{
				++$iterator;

				$result['projects'][$iterator] = [
					'year'  => $value['year'],
					'count' => get_noun_word($projects_count, 'project'),
					'items' => []
				];

				$result['projects'][$iterator]['items'][] = $value;
				$years[$value['year']] = $iterator;
			}
			else
			{
				$result['projects'][$iterator]['items'][] = $value;
			}
		}
	}

	return $result;
}

/**
 *  Формирование ссылки на проект.
 *  
 *  @param   string  $link  [Ссылка]
 *  @return  string
 */
function get_project_link($link = '')
{
	$link = get_string($link);

	return "/projects/{$link}";
}

/**
 *  Формирование ссылки на категорию.
 *  
 *  @param   string  $link  [Ссылка]
 *  @return  string
 */
function get_category_link($link = '')
{
	$link = get_string($link);

	return "/projects?q={$link}";
}

/**
 *  Формирование имени для ссылки на проект в GitHub.
 *  
 *  @param   string  $link  [Ссылка]
 *  @return  string
 */
function get_github_name($link = '')
{
	$array = explode('/', $link);
	$project = array_pop($array);

	if (empty($project))
	{
		$project = array_pop($array);
	}

	return "/{$project}";
}

/* End of file projects_helper.php */
/* Location: ./application/helpers/data/projects_helper.php */
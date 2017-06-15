<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  Обработка видеозаписей.
 *  
 *  @param   array   $data  [Видеозаписи]
 *  @return  array
 */
function get_videos_data($data = [])
{
	$data = (array) $data;
	
	$result = [];

	if (!empty($data))
	{
		foreach ($data as $key => $value)
		{
			$result[$key] = get_video_data($value);
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
function get_video_data($data = [])
{
	$data = (array) $data;

	$result = get_default_video_data();

	if (isset($data['id']) && $data['id'] > 0)
	{
		$result['id'] = (integer) $data['id'];
	}

	if (isset($data['title']) && $data['title'] != '')
	{
		$result['title'] = get_string($data['title']);
	}

	if (isset($data['video']) && $data['video'] != '')
	{
		$result['video'] = get_string($data['video']);
	}

	if (isset($data['preview']) && $data['preview'] != '')
	{
		$result['preview'] = get_string($data['preview']);
	}

	$result['preview'] = get_video_image($result['preview'], $result['video']);

	if (isset($data['duration']) && $data['duration'] > 0)
	{
		$result['duration'] = get_duration($data['duration']);
	}

	if (isset($data['created']) && $data['created'] != '')
	{
		$result['created'] = get_string($data['created']);
	}

	if (isset($data['position']) && $data['position'] > 0)
	{
		$result['position'] = (integer) $data['position'];
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
function get_default_video_data()
{
	return [
		'id'       => 0,
		'title'    => NULL,
		'video'    => NULL,
		'preview'  => NULL,
		'duration' => 0,
		'created'  => NULL,
		'position' => 0,
		'visible'  => FALSE
	];
}

// ------------------------------------------------------------------------

/**
 *  Конвертация длительности видео из общего количества секунд 
 *  в формат ЧЧ:ММ:СС или ММ:СС.
 *  
 *  @param   integer  $duration  [Длительность видео]
 *  @return  string
 */
function get_duration($duration = 0)
{
	$duration = (integer) $duration;

	// Обработка времени в DateTime.
	$time = new DateTime("@{$duration}");

	// Форматирование.
	return $duration >= 3600 ? $time->format('H:i:s') : $time->format('i:s');
}

/**
 *  Генерация изображения для урока.
 *
 *  Варианты разрешения: default, hqdefault, mqdefault, sddefault, maxresdefault.
 *  
 *  @param   string  $image       [Ссылка на изображение]
 *  @param   string  $video       [Ссылка на видео]
 *  @param   string  $resolution  [Разрешение]
 *  @return  string
 */
function get_video_image($image = '', $video = '', $resolution = 'mqdefault')
{
	$image = get_image($image, 'video');

	if (strpos($image, 'default.png') !== FALSE && !empty($video) && !empty($resolution) && preg_match('#\?v=([^\&\/]+)#i', $video, $matches))
	{
		$code = $matches[1];
		$image = "https://i.ytimg.com/vi/{$code}/{$resolution}.jpg";
	}

	return $image;
}

/* End of file video_helper.php */
/* Location: ./application/helpers/data/video_helper.php */
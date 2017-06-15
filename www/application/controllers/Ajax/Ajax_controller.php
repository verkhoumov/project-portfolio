<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  Открытое API для запросов пользователей (AJAX).
 */
class Ajax_controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 *  Постраничная загрузка проектов.
	 *
	 *  Статусы:
	 *  200 - запрос успешно выполнен
	 *  400 - общая ошибка запроса.
	 *  	401 - запрос использует незащищённый канал (http).
	 *  	402 - дата для фильтрации отсутствует либо содержит ошибки.
	 *  
	 *  @return  void
	 */
	public function get_projects()
	{
		$this->load();

		if ($this->is_ajax_request() && $this->is_https_request())
		{
			$query      = get_clear_string($this->input->post('query'));
			$query_type = get_clear_string($this->input->post('queryType'));
			$date       = get_string($this->input->post('lastDate'));

			if ($this->is_valid_date($date))
			{
				$projects = $this->search_projects($query, $query_type, $date);

				$this->reply([
					'status' => 200,
					'data'   => $projects
				]);
			}
		}
	}

	/**
	 *  Обработка сообщений из формы обратной связи.
	 *
	 *  Статусы:
	 *  200 - запрос успешно выполнен
	 *  400 - общая ошибка запроса.
	 *  	401 - запрос использует незащищённый канал (http).
	 *  	402 - сообщение является спамом, так как отсутствует специальное поле.
	 *  	403 - форма обратной связи содержит ошибки.
	 *  	404 - не удалось создать запись в базе данных.
	 *  	405 - не удалось отправить сообщение на почту владельца сайта.
	 *  
	 *  @return  void
	 */
	public function feedback()
	{
		$this->load();

		if ($this->is_ajax_request() && $this->is_https_request())
		{
			$form = $this->input->post('feedback');

			// Проверяем наличие специального поля.
			if (!array_key_exists('security', $form) || $form['security'] != 'success')
			{
				$this->reply([
					'status' => 402
				]);
			}

			// Обработка и валидация формы.
			$data = get_feedback_data($form);
			$errors = get_feedback_errors($data);

			if (empty($errors))
			{
				// Сохраняем сообщения в бд.
				if ($message_id = $this->Feedback_model->add($data))
				{
					// Отправляем администратору.
					$profile = $this->get_profile();
					$site = site_url(NULL, 'https');

					// Текст сообщения.
					$message = $this->Mustache->parse('email/feedback', $data + ['site' => $site], TRUE);

					// Настройки для отправки почты.
					$this->email->initialize([
						'mailtype' => 'html',
						'protocol' => 'sendmail'
					]);

					$this->email->from($this->cfg['noreply']['email'], $this->cfg['noreply']['name']);
					$this->email->to($profile['email']);
					$this->email->subject('Обращение через форму обратной связи на сайте '.$site);
					$this->email->message(nl2br($message));
					
					// Отправка.
					if ($this->email->send())
					{
						// Обновляем статус отправки.
						$this->Feedback_model->update(['status' => 1], ['id' => $message_id]);

						// Возвращаем ответ.
						$this->reply(['status' => 200]);
					}
					else
					{
						$this->reply(['status' => 405]);
					}
				}
				else
				{
					$this->reply(['status' => 404]);
				}
			}
			else
			{
				$this->reply([
					'status' => 403,
					'errors' => $errors
				]);
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 *  Проверка, является ли входящий запрос AJAX-ом?
	 *  
	 *  @param   integer  $status  [Статус ошибки]
	 *  @return  boolean
	 */
	private function is_ajax_request($status = 400)
	{
		if (!$this->input->is_ajax_request())
		{
			$this->reply(['status' => (int) $status]);
		}

		return TRUE;
	}

	/**
	 *  Проверка, является ли входящий запрос защищённым (https)?
	 *  
	 *  @param   integer  $status  [Статус ошибки]
	 *  @return  boolean
	 */
	private function is_https_request($status = 401)
	{
		if (!is_https())
		{
			$this->reply(['status' => (int) $status]);
		}

		return TRUE;
	}

	/**
	 *  Проверка даты на валидность.
	 *  
	 *  @param   string   $date    [Дата]
	 *  @param   integer  $status  [Статус ошибки]
	 *  @return  boolean
	 */
	private function is_valid_date($date = NULL, $status = 402)
	{
		if (!preg_match('#^[\d]{4}-[\d]{2}-[\d]{2}$#', $date))
		{
			$this->reply(['status' => (int) $status]);
		}

		return TRUE;
	}

	// ------------------------------------------------------------------------

	/**
	 *  Подключение зависимостей.
	 *  
	 *  @return  void
	 */
	protected function load()
	{
		parent::load();

		$this->load->model('Feedback_model');
		$this->load->library('email');
	}
}

/* End of file Ajax_controller.php */
/* Location: ./application/controllers/Ajax/Ajax_controller.php */
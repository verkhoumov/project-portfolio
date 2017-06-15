<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_controller extends MY_Controller
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
	public function index()
	{
		// Подключение компонентов.
		$this->load();

		// Данные.
		$profile   = $this->get_profile();
		$history   = $this->get_history();
		$education = $this->get_education();
		$skills    = $this->get_skills();
		$projects  = $this->get_projects();
		$theses    = $this->get_theses();
		$video     = $this->get_video();
		$contacts  = $this->get_contacts();

		// Данные для подстановки в шаблоны.
		$data = [
			'index' => [
				'this' => [
					'title'       => $this->get_title($profile['profession']),
					'ogtitle'     => $profile['profession'],
					'description' => $this->get_description(),
					'url'         => site_url(uri_string(), 'https'),
					'name'        => $this->cfg['title'],
					'image'       => $profile['image'],
					'type'        => 'website'
				],
				'styles' => [
					'version' => $this->cfg['version'],
					'skills'  => $this->get_skills_style_render(['skills' => $skills])
				],
				'header' => [
					'this'  => [],
					'menu'  => $profile,
					'card'  => $profile,
					'stats' => $profile + ['contacts' => $contacts]
				],
				'content' => [
					'this' => [],
					'about' => [
						'history'   => $history,
						'education' => $education
					],
					'skills' => [
						'skills'     => $skills,
						'count'      => $profile['skills'],
						'experience' => $profile['skills_experience']
					],
					'portfolio' => [
						'this' => [],
						'list' => [
							'projects' => $projects
						]
					],
					'whyiam' => [
						'theses' => $theses,
						'video'  => $video
					],
					'feedback' => [
						'feedback' => [],
						'contacts' => $contacts
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
	 *  История автора сайта.
	 *  
	 *  @return  array
	 */
	private function get_history()
	{
		$this->load->model('History_model');

		$data = $this->History_model->get_list();
		$data = get_histories_data($data);

		return $data;
	}

	/**
	 *  Образование автора.
	 *  
	 *  @return  array
	 */
	private function get_education()
	{
		$this->load->model('Education_model');

		$data = $this->Education_model->get_list();
		$data = get_educations_data($data);

		return $data;
	}

	/**
	 *  Профессиональные навыки.
	 *  
	 *  @return  array
	 */
	private function get_skills()
	{
		$this->load->model('Skills_model');

		$data = $this->Skills_model->get_list();
		$data = get_skills_data($data);
		$data = group_array($data, 'type');

		return $data;
	}

	/**
	 *  Список последних проектов, сгрупированных по годам.
	 *  
	 *  @return  array
	 */
	private function get_projects()
	{
		$this->load->model('Projects_model');

		$stats = $this->Projects_model->get_stats();
		$data = $this->Projects_model->get_list();
		$data = get_projects_data($data);
		$data = group_projects_list($data, $stats);

		return $data;
	}

	/**
	 *  Список тезисов.
	 *  
	 *  @return  array
	 */
	private function get_theses()
	{
		$this->load->model('Theses_model');

		$data = $this->Theses_model->get_list();
		$data = get_theses_data($data);

		return $data;
	}

	/**
	 *  Видеоролики с ошибками сторонних проектов.
	 *  
	 *  @return  array
	 */
	private function get_video()
	{
		$this->load->model('Video_model');

		$data = $this->Video_model->get_list();
		$data = get_videos_data($data);

		return $data;
	}

	/**
	 *  Контактная информация.
	 *  
	 *  @return  array
	 */
	private function get_contacts()
	{
		$this->load->model('Contacts_model');

		$data = $this->Contacts_model->get_list();
		$data = get_contacts_data($data);
		$data = group_array($data, 'type');

		return $data;
	}

	// ------------------------------------------------------------------------

	/**
	 *  Файл стилей для карты навыков.
	 *  
	 *  @param   array   $data  [Информация о ключевых навыках]
	 *  @return  string
	 */
	protected function get_skills_style_render($data = [])
	{
		return $this->Mustache->parse('skills', $data, TRUE);
	}
}

/* End of file Main_controller.php */
/* Location: ./application/controllers/Main_controller.php */
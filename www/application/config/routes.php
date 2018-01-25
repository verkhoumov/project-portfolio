<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

// Главная страница.
$route['default_controller'] = 'Main_controller';

// Страница с 404 ошибкой.
$route['404_override'] = 'Errors_controller/page404';

// Надстройка.
$route['translate_uri_dashes'] = FALSE;

/**
 *  Файлы.
 */
$route['(.*)\.html$'] = 'Files_controller/$1';

/**
 *  Основные страницы.
 */
$route['projects$'] = 'Projects/List_controller';
$route['projects/(:any)$'] = 'Projects/View_controller/index/$1';

/**
 *  AJAX.
 */
$route['ajax/projects/get$'] = 'Ajax/Ajax_controller/get_projects';
$route['ajax/feedback$'] = 'Ajax/Ajax_controller/feedback';

/**
 *  CRON.
 */
$route['cron/sitemap/(:any)$'] = 'Cron/Sitemap_controller/index/$1';

/**
 *  API.
 */
$route['api/profile/(get|put|delete)$']   = 'Api/Profile_controller/$1';
$route['api/about/(get|put|delete)$']     = 'Api/About_controller/$1';
$route['api/theses/(get|put|delete)$']    = 'Api/Theses_controller/$1';
$route['api/video/(get|put|delete)$']     = 'Api/Video_controller/$1';
$route['api/education/(get|put|delete)$'] = 'Api/Education_controller/$1';
$route['api/skills/(get|put|delete)$']    = 'Api/Skills_controller/$1';
$route['api/portfolio/(get|put|delete)$'] = 'Api/Portfolio_controller/$1';
$route['api/contacts/(get|put|delete)$']  = 'Api/Contacts_controller/$1';
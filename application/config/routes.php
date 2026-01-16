<?php

defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'recipes';
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';
$route['ingredients'] = 'ingredients/index';
$route['ingredients/create'] = 'ingredients/create';
$route['recipes'] = 'recipes/index';
$route['recipes/create'] = 'recipes/create';
$route['recipes/(:num)'] = 'recipes/show/$1';
$route['recipes/(:num)/label'] = 'labels/preview/$1';
$route['recipes/(:num)/fop'] = 'labels/fop/$1';
$route['config-anvisa'] = 'config/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

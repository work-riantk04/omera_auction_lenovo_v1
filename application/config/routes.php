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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*
| -------------------------------------------------------------------------
| Authentication Routes
| -------------------------------------------------------------------------
*/
$route['auth/login'] = 'auth/login';
$route['auth/register'] = 'auth/register';
$route['auth/logout'] = 'auth/logout';
$route['auth/reset_password'] = 'auth/reset_password';

/*
| -------------------------------------------------------------------------
| Admin Routes
| -------------------------------------------------------------------------
*/
$route['admin/dashboard'] = 'admin/dashboard';
$route['admin/events'] = 'admin/events';
$route['admin/items'] = 'admin/items';
$route['admin/items_detail/(:num)'] = 'admin/items_detail/$1';
$route['admin/items_verify/(:num)'] = 'admin/items_verify/$1';
$route['admin/invoices'] = 'admin/invoices';
$route['admin/shipping'] = 'admin/shipping';
$route['admin/disbursements'] = 'admin/disbursements';
$route['admin/notifications'] = 'admin/notifications';
$route['admin/users'] = 'admin/users';
$route['admin/users_create'] = 'admin/users_create';
$route['admin/users_edit/(:num)'] = 'admin/users_edit/$1';
$route['admin/users_delete/(:num)'] = 'admin/users_delete/$1';
$route['admin/users_toggle/(:num)'] = 'admin/users_toggle/$1';
$route['admin/settings'] = 'admin/settings';

/*
| -------------------------------------------------------------------------
| Titipers Routes
| -------------------------------------------------------------------------
*/
$route['titipers/dashboard'] = 'titipers/dashboard';
$route['titipers/items'] = 'titipers/items';
$route['titipers/events'] = 'titipers/events';
$route['titipers/shipping'] = 'titipers/shipping';
$route['titipers/notifications'] = 'titipers/notifications';
$route['titipers/profile'] = 'titipers/profile';

/*
| -------------------------------------------------------------------------
| Bidders Routes
| -------------------------------------------------------------------------
*/
$route['bidders/dashboard'] = 'bidders/dashboard';
$route['bidders/events'] = 'bidders/events';
$route['bidders/bids'] = 'bidders/bids';
$route['bidders/invoices'] = 'bidders/invoices';
$route['bidders/notifications'] = 'bidders/notifications';
$route['bidders/profile'] = 'bidders/profile';

/*
| -------------------------------------------------------------------------
| API Routes
| -------------------------------------------------------------------------
*/
$route['api/bid'] = 'api/bid';
$route['api/countdown'] = 'api/countdown';

/*
| -------------------------------------------------------------------------
| Frontend Routes
| -------------------------------------------------------------------------
*/
$route['about'] = 'welcome/about';
$route['contact'] = 'welcome/contact';
$route['events/list'] = 'welcome/events';
$route['event/detail/(:num)'] = 'welcome/event_detail/$1';

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
$route['default_controller'] = 'rms';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['project/data'] = 'rms/project';
$route['project/replas'] = 'rms/replas';
$route['project/view/(:any)'] = 'rms/view_project/$1';
$route['truck/view/(:any)'] = 'rms/view_truck/$1';
$route['vendor/view/(:any)'] = 'rms/view_vendor/$1';
$route['sparepart/view/(:any)'] = 'rms/view_sparepart/$1';
$route['supir/view/(:any)'] = 'rms/view_supir/$1';
$route['invoice/generate'] = 'rms/generate_invoice';
$route['truck'] = 'rms/truck';
$route['invoice/data'] = 'rms/invoice';
$route['perbaikan'] = 'rms/perbaikan';
$route['vendor'] = 'rms/vendor';
$route['sparepart'] = 'rms/sparepart';
$route['supir'] = 'rms/supir';
$route['tujuan'] = 'rms/tujuan';
$route['klien'] = 'rms/klien';
$route['keuangan'] = 'rms/keuangan';
$route['setting'] = 'rms/setting';
$route['project/kwitansi/(:any)'] = 'rms/kwitansi/$1';
$route['dashboard'] = 'rms/dashboard';
$route['invoice/view/(:any)'] = 'rms/view_invoice/$1';
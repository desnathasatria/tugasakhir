<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
$route['default_controller'] = 'Front_page';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['dashboard'] = 'Dashboard_admin';
$route['admin'] = 'Admin';
$route['logout'] = 'Admin/logout';
$route['manage-category-gallery'] = 'Manage_category_gallery';
$route['manage-gallery'] = 'Manage_gallery';
$route['manage-carousel'] = 'Manage_carousel';
$route['message-user'] = 'Manage_message';
$route['profil-admin'] = 'Manage_user';
$route['manage-company-profile'] = 'Manage_company_profile';
$route['manage-category-product'] = 'Manage_category_product';
$route['manage-product'] = 'Manage_product';
$route['manage-promo'] = 'Manage_promo';
$route['manage-supplier'] = 'Manage_supplier';
$route['manage-purchase'] = 'Manage_purchase';
$route['manage-shipping'] = 'Manage_shipping';
$route['manage-history'] = 'Manage_history';
$route['registrasi'] = 'Auth_user/register';
$route['login'] = 'Auth_user';
$route['logout_1'] = 'Auth_user/logout';
$route['profile'] = 'Front_page/profile';
$route['history'] = 'Front_page/history';
$route['cek-ongkir'] = 'RajaongkirController/index';
$route['payments'] = 'MidtransController/notification';
$route['provinces'] = 'RajaongkirController/provinces';
$route['export-pdf-history'] = 'Manage_history/export_pdf';
$route['checkout_keranjang'] = 'Front_page/checkout_keranjange';
//$route['cities/(:num)'] = 'RajaongkirController/cities/$1';
//$route['cost'] = 'RajaongkirController/cost';
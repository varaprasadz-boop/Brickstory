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

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['pages/(:any)'] = "Home/index/$1";
$route['aboutus'] = "Home/index/about";
$route['search'] = "Home/nearme";
$route['search/(:num)'] = "Home/nearme/$1";
$route['dashboard/(:num)'] = "Dashboard/index/$1";
$route['dashboard/myhomes/(:num)'] = "Dashboard/index/$1";
$route['dashboard/turn-off-notification/(:num)'] = "Dashboard/turnOffNotification/$1";
//$route['nearme'] = "Home/nearme";
$route['contactus'] = "Home/contactus";
$route['photosnhistory'] = "Home/photosnhistory";
$route['photosnhistory/(:num)'] = "Home/photosnhistory/$1";
$route['houseshistory'] = "Home/houses";
$route['houseshistory/(:num)'] = "Home/houses/$1";
$route['peoples'] = "Home/peoples";
$route['peoples/(:num)'] = "Home/peoples/$1";
$route['details/view/(:num)'] = "Home/details/$1";
$route['details/story/(:num)'] = "Home/details/$1";
$route['details/people/(:num)'] = "Home/details/$1";
$route['details/timeline/(:num)'] = "Home/details/$1";
$route['dashboard/myhomes'] = "dashboard/index";
$route['resize/(:num)/(:num)/(:any)'] = 'image/resize/$1/$2/$3';
$route['dashboard/update_people_image'] = "dashboard/update_people_image";

// ------- Admin Routes -------
$url_perfix = "brickstoryadmin/";
$route[$url_perfix.'login'] = $url_perfix."/account/login";
$route['send_sms']['GET']     = 'Home/send_sms';


// ----------- Web Services ------------
$route['api/login']['POST']             = 'api/user/login';
$route['api/register']['POST']          = 'api/user/register';
$route['api/profile']['POST']           = 'api/user/profile';
$route['api/forgot_password']['POST']   = 'api/user/forgot_password';

$route['api/add_home']['POST']          = 'api/homeService/add_home';
$route['api/update_home']['POST']          = 'api/homeService/update_home';
$route['api/add_home/params']['GET']    = 'api/homeService/get_params';

$route['api/home/listings']['GET']      = 'api/homeService/home_page_listing';
$route['api/home/listings/(:any)']['GET']      = 'api/homeService/home_page_listing/$1';

$route['api/home/nearme']['GET']        = 'api/homeService/nearme';
$route['api/home/nearme/(:any)']['GET']        = 'api/homeService/nearme/$1';

$route['api/home/houses']['GET']        = 'api/homeService/houses';
$route['api/home/houses/(:any)']['GET']        = 'api/homeService/houses/$1';

$route['api/contactus']['POST']         = 'api/homeService/contactus';

$route['api/home/peoples']['GET']       = 'api/homeService/peoples';
$route['api/home/peoples/(:any)']['GET']       = 'api/homeService/peoples/$1';

$route['api/home/photosnhistory']['GET']= 'api/homeService/photosnhistory';
$route['api/home/photosnhistory/(:any)']['GET']= 'api/homeService/photosnhistory/$1';

$route['api/home/details/(:any)']['GET'] = 'api/homeService/details/$1';
$route['api/home/timeline/(:any)']['GET'] = 'api/User/my_timeline/$1';
$route['api/home/home_detail_timeline/(:any)/(:any)']['GET'] = 'api/homeService/home_timeline/$1';


$route['api/home/i_lived_here']['POST'] = 'api/homeService/i_lived_here';

$route['api/home/add_people_to_property']['POST'] = 'api/homeService/add_people_to_property';
$route['api/home/update_people_to_property']['POST'] = 'api/homeService/update_people_to_property';


$route['api/home/add_photo_story_to_property']['POST'] = 'api/homeService/add_photo_story_to_property';
$route['api/home/update_photo_story_to_property']['POST'] = 'api/homeService/update_photo_story_to_property';

$route['api/home/updateInfo']['POST'] = 'api/homeService/updateInfo';
$route['api/home/banners']['GET'] = 'api/homeService/banners';

$route['api/home/monitor_home']['POST'] = 'api/homeService/monitor_home';
$route['api/home/turn-off-notification/(:num)']['GET'] = "api/homeService/turnOffNotification/$1";

$route['api/pages/(:any)']['GET'] = "api/homeService/pages/$1";



// $route['api/products/(:num)']['GET'] = 'api/products/show/$1';
// $route['api/products']['POST'] = 'api/products/store';
// $route['api/products/(:num)']['PUT'] = 'api/products/update/$1';
// $route['api/products/(:num)']['DELETE'] = 'api/products/destroy/$1';

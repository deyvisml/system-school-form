<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

 /* --------------------------------------------------------------------
    (:any)      Coincidirá con cualquier carácter que pasemos a través de la URL.
    (:segment)  Igual que el anterior excluyendo el /.
    (:num)      Match con cualquier entero.
    (:alpha)    Match con cualquier carácter del alfabeto.
    (:alphanum) Match con cualquier carácter del alfabeto o número.
    (:hash)
 -------------------------------------------------------------------- */


// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'Login::index');
$routes->get('/login', 'Login::index');
$routes->post('/logearse', 'Login::verificar');
$routes->get('/application', 'Application::index');

$routes->post('/accesos', 'Application::accesos');
$routes->post('/getroles', 'Application::getroles');
$routes->post('/asignarol', 'Application::asignarol');
$routes->post('/setpass', 'Application::setpass');
$routes->add('/cerrarsesion', 'Application::salir');
$routes->add('/testing', 'Application::testing');

// * ----------------------------- WORKING --------------------------------------

$routes->post('/formularios', 'FormController::index_own');
$routes->post('/formularios/create-form', 'FormController::store');

$routes->post('/forms/(:num)/config-aspects', 'FormController::config_aspects/$1');
$routes->post('/formularios/(:num)/config-items', 'FormController::config_items/$1');
$routes->post('/formularios/(:num)/show', 'FormController::show');
$routes->post('/formularios/(:num)/users', 'FormController::manage_users');
$routes->post('/forms/delete', 'FormController::delete');
$routes->post('/forms/get-data-by-id', 'FormController::get_data_by_id');
$routes->post('/forms/update', 'FormController::update/$1');
$routes->post('/forms/(:num)/asign-institutions', 'FormController::asign_institutions/$1');
$routes->post('/forms/(:num)/just-view-form', 'FormController::just_view_form/$1');
$routes->post('/forms/update-form-title-value', 'FormController::update_form_title_value');
$routes->post('/forms/update-form-description-value', 'FormController::update_form_description_value');

$routes->post('/formularios/create-aspect', 'AspectController::store');
$routes->post('/aspects/update-name', 'AspectController::update_name');
$routes->post('/aspects/delete', 'AspectController::delete');
$routes->post('/aspects/update-order', 'AspectController::update_order');

$routes->post('/items/create', 'ItemController::create');
$routes->post('/items/delete', 'ItemController::delete');
$routes->post('/items/update-mandatory', 'ItemController::update_mandatory');
$routes->post('/items/update-item-type-id', 'ItemController::update_item_type_id');
$routes->post('/items/update-item-value', 'ItemController::update_item_value');
$routes->post('/items/update-items-order', 'ItemController::update_items_order');

$routes->post('/alternatives/create', 'AlternativeController::create');
$routes->post('/alternatives/delete', 'AlternativeController::delete');
$routes->post('/alternatives/update-alternative-value', 'AlternativeController::update_alternative_value');
$routes->post('/alternatives/update-alternatives-order', 'AlternativeController::update_alternatives_order');

$routes->post('/institucion-form/create', 'InstitucionFormController::store');

$routes->post('/formularios-asignados', 'InstitucionController::asign_forms');
$routes->post('/instituciones/(:num)/formularios-asignados/(:num)/show', 'FormController::show_form/$1/$2');
$routes->post('/instituciones/(:num)/formularios-asignados/(:num)/submit-form', 'FormController::submit_form/$1/$2');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	//Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
	Router::connect('/', array('controller' => 'orders', 'action' => 'index', 'index'));
        
        // strona home Cakephp
        Router::connect('/cake', array('controller' => 'pages', 'action' => 'display', 'home'));
        
        // phpinfo()
        Router::connect('/info', array('controller' => 'pages', 'action' => 'display', 'info'));
        
        // etykiety
        Router::connect('/etykiety', array('controller' => 'tasks', 'action' => 'label'));

        // Handlowe po nowemu, special search        
        Router::connect('/szukaj', array('controller' => 'disposals', 'action' => 'index'));

        // Handlowe - nowe zamówienie i edycja with webix (26.09.2018 => przenosimy się do WebixesController)
        Router::connect('/handlowe/dodaj', array('controller' => 'requests', 'action' => 'dodaj'));
        Router::connect('/handlowe/edytuj/*', array('controller' => 'requests', 'action' => 'edytuj'));

        Router::connect(webixCustomersURL, array('controller' => 'webixes', 'action' => 'index'));

/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
        
        Router::parseExtensions('json', 'pdf');
        /* tego pdf przedtem tu nie było a generowanie pdf było ok
         *  po wprowadzeniu tylko json generowanie pdf pada
         *  po dopisaniu pdf jest ok
         */

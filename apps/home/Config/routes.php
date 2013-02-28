<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
 
	if (Configure::read('Site.maintenance')) {
		Router::connect('/', array('controller' => 'pages', 'action' => 'maintenance'));
		Router::connect('/*', array('controller' => 'pages', 'action' => 'maintenance'));
	} else {
		Router::connect('/', array('controller' => 'pages', 'action' => 'index'));
		Router::connect('/home', array('controller' => 'pages', 'action' => 'home'));
		Router::connect('/member/*', array('controller' => 'users', 'action' => 'detail'));
		Router::connect('/admin/dashboard', array('controller' => 'admin', 'action' => 'dashboard', 'admin' => TRUE));
		/*Router::connect('/about', array('controller' => 'pages', 'action' => 'about'));*/
		Router::connect('/pages/testing', array('controller' => 'pages', 'action' => 'display', 'testing'));
		
		/* sitemap */
		Router::connect('/sitemap', array('controller' => 'sitemaps', 'action' => 'index'));
		Router::connect('/member-sitemap', array('controller' => 'sitemaps', 'action' => 'member'));
		Router::connect('/send_sitemap', array('controller' => 'sitemaps', 'action' => 'send_sitemap'));
		Router::connect('/sitemap/:action/*', array('controller' => 'sitemaps'));
		
		Router::connect('/robots/:action/*', array('controller' => 'sitemaps', 'action' => 'robot'));
		Router::connect('/robots.txt', array('controller' => 'sitemaps', 'action' => 'robot'));
		Router::parseExtensions('rss', 'xml'); 
	
	}
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	//Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';

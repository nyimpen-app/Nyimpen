<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
	
	//public $components = array('Auth', 'Session', 'Facebook.Connect');
	public $components = array('Session',
		'Auth',
		//'Facebook.Connect' => array('model' => 'User'),
		'Session'
	);
	public $helpers = array('Html', 'Session', 'Form','Facebook.Facebook');
	
	public $option;
	public $user_data;
	
	function beforeFilter() {
	
		$this->Auth->allow('index', 'view', 'about');
		//Configure AuthComponent
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'admin' => FALSE, 'plugin' => FALSE);
        $this->Auth->logoutRedirect = array('controller' => 'pages', 'action' => 'index', 'admin' => FALSE, 'plugin' => FALSE);
        $this->Auth->loginRedirect = array('controller' => 'pages', 'action' => 'home', 'admin' => FALSE);
		
		//$this->layout = 'aurelius';
		 if ($this->Auth->login()) {
			$this->user_data = $this->Auth->user();
		}
		
	
		
		
		
		//$settings = $this->Setting->getOption();
		//foreach($settings as $item) {
			//$this->option[$item['Setting']['unique_name']] = $item['Setting']['value'];
		//}	
	}
	
	function beforeRender() {
		
		$this->set('user_data', $this->user_data);
	}
}

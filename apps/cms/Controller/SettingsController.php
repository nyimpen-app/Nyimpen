<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class SettingsController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Settings';

/**
 * Default helper
 *
 * @var array
 */
	public $helpers = array('Html', 'Session', 'Paging', 'Time');

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Bookmark', 'Role', 'Setting');
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('*');
		
		$this->layout = 'admin';
	}
	
	public function admin_option() {
		
		if ($this->request->is('post') || $this->request->is('put')) {
			//dpr($this->request->data);
			$this->request->data['Setting']['type'] = 'general_option';
			if ($this->Setting->save($this->request->data)) {
				$this->Session->setFlash('The Setting has been saved', 'success_msg');
				$this->redirect(array('action' => 'option'));
			} else {
				$this->Session->setFlash(__('The setting could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Setting->getOption();
			
		
		}
		
	
		
	}

}

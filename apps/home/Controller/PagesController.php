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
class PagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Pages';

/**
 * Default helper
 *
 * @var array
 */
	public $helpers = array('Html', 'Session', 'Paging', 'Solvemedia', 'Time');

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Bookmark', 'Role');
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('display', 'index', 'about', 'terms', 'coba', 'privacy', 'maintenance');
	}
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}
	
	
	public function index() {
		$this->layout = 'front';
		
		 if ($this->Auth->login()) {
            return $this->redirect($this->Auth->redirect());
        }
		
		$this->set('title_for_layout', 'Nyimpen | Your Online Bookmarking Service');
		$this->set('desc_for_layout', 'Nyimpen.tk is a simple online bookmarking service, you can bookmark your url at anytime and save and manage your link for future');
		//redirect('/home');
	
	}
	
	public function home() {
	
		$this->layout = 'front';
		$data = array();
		$bookmarks = $this->Bookmark->getUserBookmark($this->Auth->user('_id'));
		
		##### paging##########
		$offset = 0;
		if(isset($this->params['named']['page'])) 
			$current_page = $this->params['named']['page'];
		else
			$current_page = 1;
		
		
		$item_perpage = 20;
		
		if($current_page > 1) {
			$offset = $item_perpage * ($current_page -1 );
		}
		
		$this->set('total', sizeof($bookmarks));
		$this->set('item_perpage', $item_perpage);
		$this->set('current_page', $current_page);
		##### end Paging ######

		if(!empty($bookmarks))
			$data = array_slice($bookmarks, $offset, $item_perpage);
		
		################# SEO ########################
		
		$this->set('bookmarks', $data);
		$this->set('title_for_layout', 'Nyimpen | My Profile | Your Online Bookmarkinh Service');
		$this->set('desc_for_layout', 'Nyimpen.tk is a simple online bookmarking service, its free to use, you can save your link easy and free forever.');
		
		
	}
	
	public function about() {
		$this->layout = 'front';
		
		$this->set('title_for_layout', 'About NyimpeN.tk | Nyimpen - Your Online Bookmarking Service');
		$this->set('desc_for_layout', 'Nyimpen is a simple online bookmarking service, its free to use, you can save your link easy and free forever.');
	}
	
	public function terms() {
		$this->layout = 'front';
		
		$this->set('title_for_layout', 'NyimpeN.tk Terms Of Service | Nyimpen - Your Online Bookmarkinh Service');
		$this->set('desc_for_layout', "Welcome to nyimpen.tk. This website is owned and operated by nyimpen.tk. By visiting our website and accessing the information, resources, services, products, and tools we provide, you understand and agree to accept and adhere to the following terms and conditions as stated in this policy.");
		
	}
	
	public function privacy() {
		$this->layout = 'front';
		
		$this->set('title_for_layout', 'NyimpeN.tk Privacy Policy | Nyimpen - Your Online Bookmarkinh Service');
		$this->set('desc_for_layout', "nyimpen.tk collect information from you when you register on our site, subscribe to our newsletter, fill out a form or save a link. When ordering or registering on our site, as appropriate, you may be asked to enter your: name or e-mail address. You may, however, visit our site anonymously..");
	}
	
	public function maintenance () {
		$this->layout = 'maintenance';
	}
}

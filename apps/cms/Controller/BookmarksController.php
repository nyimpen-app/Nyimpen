<?php
App::uses('AppController', 'Controller');
/**
 * Bookmarks Controller
 *
 * @property Bookmark $Bookmark
 */
class BookmarksController extends AppController {
	
	
	
	function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->allow('*');
		$role_id = $this->user_data['role_id']['$id']->__toString();
		$this->user_data['role'] = $this->Role->field('name', array('_id' => $role_id));
	
	
		if ($this->Auth->login()== FALSE && 
			$role_name !== strtolower('administrator') &&
			$role_id !== '4fc5a6d0b3686a0039000001'
		)
			{ 
			throw new NotFoundException(__('Pages Not Found'));
		}
		
		$this->layout = 'admin';
	}

/**
 * admin_public method
 *
 * @return void
 */
	public function admin_public() {
		
		
		$bookmarks = $this->Bookmark->getPublic();
		$this->set('bookmarks', $bookmarks);
	}
	
/**
 * admmin_index method
 *
 * @return void
 */
	public function admin_index() {
		$bookmarks = $this->Bookmark->getAll();
		$this->set('bookmarks', $bookmarks);
	}

/**
 * admmin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->Auth->login() && $this->user_data['role_id'] !== 1) {
			throw new NotFoundException(__('Pages Not Found'));
		}
		
		if ($this->request->is('post')) {
			$this->Bookmark->create();
			if ($this->Bookmark->save($this->request->data)) {
				$this->Session->setFlash(__('The bookmark has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bookmark could not be saved. Please, try again.'));
			}
		}
		$users = $this->Bookmark->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admmin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if ($this->Auth->login() && $this->user_data['role_id'] !== 1) {
			throw new NotFoundException(__('Pages Not Found'));
		}
		
		$this->Bookmark->id = $id;
		if (!$this->Bookmark->exists()) {
			throw new NotFoundException(__('Invalid bookmark'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Bookmark->save($this->request->data)) {
				$this->Session->setFlash(__('The bookmark has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bookmark could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Bookmark->read(null, $id);
		}
		$users = $this->Bookmark->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admmin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if ($this->Auth->login() && $this->user_data['role_id'] !== 1) {
			throw new NotFoundException(__('Pages Not Found'));
		}
		
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Bookmark->id = $id;
		if (!$this->Bookmark->exists()) {
			throw new NotFoundException(__('Invalid bookmark'));
		}
		if ($this->Bookmark->delete()) {
			$this->Session->setFlash(__('Bookmark deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Bookmark was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	private function getUrlData($url)
	{
		$result = false;
		$contents = $this->getUrlContents($url);
	 
		if (isset($contents) && is_string($contents))
		{
			$title = null;
			$metaTags = null;
	 
			preg_match('/<title>([^>]*)<\/title>/si', $contents, $match );
	 
			if (isset($match) && is_array($match) && count($match) > 0)
			{
				$title = strip_tags($match[1]);
			}
	 
			preg_match_all('/<[\s]*meta[\s]*name="?' . '([^>"]*)"?[\s]*' .'[lang="]*[^>"]*["]*'.'[\s]*content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $contents, $match);
			if (isset($match) && is_array($match) && count($match) == 3)
			{
				$originals = $match[0];
				$names = $match[1];
				$values = $match[2];
	 
				if (count($originals) == count($names) && count($names) == count($values))
				{
					$metaTags = array();
	 
					for ($i=0, $limiti=count($names); $i < $limiti; $i++)
					{
						$metaname=strtolower($names[$i]);
						$metaname=str_replace("'",'',$metaname);
						$metaname=str_replace("/",'',$metaname);
						$metaTags[$metaname] = array (
						'html' => htmlentities($originals[$i]),
						'value' => $values[$i]
						);
					}
				}
			}
			if(sizeof($metaTags)==0) {
				preg_match_all('/<[\s]*meta[\s]*content="?' . '([^>"]*)"?[\s]*' .'[lang="]*[^>"]*["]*'.'[\s]*name="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $contents, $match);
	 
				if (isset($match) && is_array($match) && count($match) == 3)
				{
					$originals = $match[0];
					$names = $match[2];
					$values = $match[1];
		 
					if (count($originals) == count($names) && count($names) == count($values))
					{
						$metaTags = array();
		 
						for ($i=0, $limiti=count($names); $i < $limiti; $i++)
						{
							$metaname=strtolower($names[$i]);
							$metaname=str_replace("'",'',$metaname);
							$metaname=str_replace("/",'',$metaname);
							$metaTags[$metaname] = array (
								'html' => htmlentities($originals[$i]),
								'value' => $values[$i]
							);
						}
					}
				}
			}
	 
			$result = array (
				'title' => $title,
				'metaTags' => $metaTags
			);
		}

		return $result;
	}
	
	private function getUrlContents($url, $maximumRedirections = null, $currentRedirection = 0)
	{
		$result = false;
		$contents = file_get_contents($url);
	 
		if (isset($contents) && is_string($contents))
		{
			preg_match_all('/<[\s]*meta[\s]*http-equiv="?REFRESH"?' . '[\s]*content="?[0-9]*;[\s]*URL[\s]*=[\s]*([^>"]*)"?' . '[\s]*[\/]?[\s]*>/si', $contents, $match);
	 
			if (isset($match) && is_array($match) && count($match) == 2 && count($match[1]) == 1)
			{
				if (!isset($maximumRedirections) || $currentRedirection < $maximumRedirections)
				{
					return $this->getUrlContents($match[1][0], $maximumRedirections, ++$currentRedirection);
				}
	 
				$result = false;
			}
			else
			{
				$result = $contents;
			}
		}
	 
		return $contents;
	}
}

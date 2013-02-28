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

	}


/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->layout = 'empty';
		if ($this->request->is('post')) {
			if(empty($this->request->data['Bookmark']['url'])) {
				$this->Session->setFlash('Url cannot be empty', 'error_form');
				$this->redirect(array('controller' => 'pages', 'action' => 'home'));
			}
			$result = $this->getUrlData($this->request->data['Bookmark']['url']);
	
			if($result['title']=="") {
				$title="No Data Available";
			} else {
				$title=$result['title'];
			}
			
			if(!empty($result['metaTags']['description'])) {
				if($result['metaTags']['description']['value']=="") {
					$description="No Data Available";
				} else {
					$description=$result['metaTags']['description']['value'];
				}
			}
			/*if($result['metaTags']['keywords']['value']=="") {
				$keywords="No Data Available";
			} else {
				$keywords=$result['metaTags']['keywords']['value'];
			}*/
			
			//$meta_tags = get_meta_tags();
			//$title = $this->getTitle($this->request->data['Bookmark']['url']);
			$user_id = $this->Auth->user('_id');
			$m_id = new MongoId($user_id); 
			$ref = array(
				'$ref' => 'users',
				'$id'	=> $m_id
				);
				
			$save['Bookmark']['user_id'] = $ref;
			$save['Bookmark']['url'] = urlencode($this->request->data['Bookmark']['url']);
			$save['Bookmark']['title'] = isset($title) ? $title : NULL;
			$save['Bookmark']['description'] = isset($description) ? $description : NULL;
			$save['Bookmark']['is_public'] = $this->request->data['Bookmark']['is_public'];
			
		
			$this->Bookmark->create();
			if ($this->Bookmark->save($save)) {
				$this->Bookmark->deleteCache($this->Auth->user('_id'));
				$this->Session->setFlash('The bookmark has been saved', 'success_form');
				$this->redirect(array('controller' => 'pages', 'action' => 'home'));
			} else {
				$this->Session->setFlash('The bookmark could not be saved. Please, try again.', 'error_form');
				$this->redirect(array('controller' => 'pages', 'action' => 'home'));
			}
		}
		$users = $this->Bookmark->User->find('list');
		$this->set(compact('users'));
	}
	

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
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
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Bookmark->id = $id;
		if (!$this->Bookmark->exists()) {
			throw new NotFoundException(__('Invalid bookmark'));
		}
		if ($this->Bookmark->delete()) {
			$this->Bookmark->deleteCache($this->Auth->user('id'));
			$this->Session->setFlash('Bookmark deleted', 'success_form');
			$this->redirect(array('controller' => 'pages', 'action' => 'home'));
		}
		$this->Session->setFlash('Bookmark was not deleted', 'error_form');
		$this->redirect(array('action' => 'index'));
	}
/**
 * admmin_index method
 *
 * @return void
 */
	public function admin_index() {
		if ($this->Auth->login() && $this->user_data['role_id'] !== 1) {
			throw new NotFoundException(__('Pages Not Found'));
		}
		
		$this->Bookmark->recursive = 0;
		$this->set('bookmarks', $this->paginate());
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

<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {
	
	public $uses = array('User', 'Role', 'Bookmark');
	public $helpers = array('Time');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('login');
		
		if($this->request->params['action'] !== 'login') {
			$role_id = $this->user_data['role_id']['$id']->__toString();
			$this->user_data['role'] = $this->Role->field('name', array('_id' => $role_id));
		
		
			if ($this->Auth->login()== FALSE && 
				$role_name !== strtolower('administrator') &&
				$role_id !== '4fc5a6d0b3686a0039000001'
			)
				{ 
				throw new NotFoundException(__('Pages Not Found'));
			}		
		}
		
		$this->layout = 'admin';
	}
/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		
		$users = $this->User->getAll();
		
		$this->set('users', $users);
	}



/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->Auth->login() && $this->user_data['role_id'] !== 1) {
			throw new NotFoundException(__('Pages Not Found'));
		}
		
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$roles = $this->User->Role->find('list');
		$this->set(compact('roles'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if ($this->Auth->login() && $this->user_data['role_id'] !== 1) {
			throw new NotFoundException(__('Pages Not Found'));
		}
		
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
		$roles = $this->User->Role->find('list');
		$this->set(compact('roles'));
	}

/**
 * delete method
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
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	
	
	public function login() {
		$this->layout = 'empty';
		
		 if ($this->Auth->login()) {
            return $this->redirect($this->Auth->redirect());
        }
		if ($this->request->is('post')) {
			
			if ($this->Auth->login()) {
				$data['User']['_id'] = $this->Auth->user('_id');
				$data['User']['lastlogin'] = date('Y-m-d H:i:s');
				
				$this->User->save($data);
				//return $this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'auth');
			}
			
		}
	
	}
	
	public function logout() {
		$this->Session->destroy();
		$this->redirect($this->Auth->logout());
		

	}
}

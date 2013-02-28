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
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('login', 'register', 'detail');
	}
	
	public function profile($username = null) {
		$this->layout = 'front';
		$this->User->recursive = 0;
		$id = $this->User->field('_id', array('username' => $username)); 
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		
		$user = $this->User->getById($id); 
		
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->User->deleteCache($id);
				$this->Session->setFlash('Your profile has been updated', 'success_form');
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash('Your profile could not be saved. Please, try again.', 'error_form');
			}
		} else {
			$this->request->data = $user;
		}
		
		$this->set('title_for_layout', 'My Profile | Nyimpen | Your Online Bookmarkinh Service');
		$this->set('desc_for_layout', 'Nyimpen is a simple online bookmarking service, its free to use, you can save your link easy and free forever.');
				
	}
	
	public function change_password($username) {
		$id = $this->User->field('_id', array('username' => $username));
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		
		if ($this->Auth->user('_id') != $id && $this->Auth->user('username') != $username) {
			throw new NotFoundException(__('Invalid user'));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->autoRender = false;
		
			if (!empty($this->request->data['User']['current_password'])
					&& !empty($this->request->data['User']['new_password'])
					&& !empty($this->request->data['User']['repeat_password'])) {
				
				$user_password = $this->User->getPassword($username);
				
				$password = $this->Auth->password($this->request->data['User']['current_password']);
			
				if($user_password === $password) {
					if($this->request->data['User']['new_password'] == $this->request->data['User']['repeat_password']) {
						//hash the brand new password
						$new_password = ($this->request->data['User']['new_password']);
						$user['id'] = $this->User->field('id', array('User.username' => $username));
						$user['password'] = $new_password;
						
			
						$this->User->save($user);
						
						$this->Session->setFlash('Your password has been updated', 'success_form');
					} else 
						$this->Session->setFlash('Oops!!, Your password not match', 'error_form'); //pssword not match
				} else
					$this->Session->setFlash('Oops!!, Your  current password is wrong', 'error_form'); //old pssword not match
			} else {
				$this->Session->setFlash('Oops!!, Something Wrong', 'error_form'); 
			}
			$this->redirect($this->referer());
		}
		
		$this->set('profile', $this->User->read(null, $id));
		$this->layout = 'admin';
	}
	
	public function login() {
		$this->layout = 'empty';
		
		if ($this->request->is('post')) {
			
			if ($this->Auth->login()) {
				
				$data['User']['_id'] = $this->Auth->user('_id');
				$data['User']['lastlogin'] = date('Y-m-d H:i:s');
				
				$this->User->save($data);
				return $this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'auth');
			}
			
		}
	
	}
	
	public function register() {
		if ($this->request->is('post')) {
			
			$this->autoRender = false;
			$error = FALSE;
			
			if($this->request->data['User']['username'] == '') {
				$err_msg[] = 'Username is required field';
				$error = TRUE;
			}
			
			if($this->request->data['User']['email'] == '') {
				$err_msg[] = 'Email is required field';
				$error = TRUE;
			}
			
			if($this->request->data['User']['password'] == '') {
				$err_msg[] = 'Password is required field';
				$error = TRUE;
			}
						
			if(!empty($this->request->data['User']['username'])) {
				
				$is_validusername = ctype_alnum($this->request->data['User']['username']);
				
				if($is_validusername) {
					$validusername = $this->User->check(array(
										'field'	=> 'username',
										'value'	=> 	$this->request->data['User']['username']
										));
					
					if($validusername) {
						$save['User']['username'] = $this->request->data['User']['username'];
					} else {
						$err_msg[] = 'Username has already been taken';
						$error = TRUE;
					}
				} else {
					$err_msg[] = 'Username is alphanumeric only';
					$error = TRUE;
				}
			}
			
			if(!empty($this->request->data['User']['email'])) {
				$is_validemail = $this->check_email_address($this->request->data['User']['email']);
				
				$validemail = $this->User->check(array(
									'field'	=> 'email',
									'value'	=> 	$this->request->data['User']['email']
									));
				
				if($validemail) {
					$save['User']['email'] = $this->request->data['User']['email'];
				} else {
					$err_msg[] = 'E-Mail has already been taken';
					$error = TRUE;
				}
				if($is_validemail) {
					$save['User']['email'] = $this->request->data['User']['email'];
				} else {
					$err_msg[] = 'E-Mail not Valid';
					$error = TRUE;
				}
				
				
			}
		
			
			if (!empty($this->request->data['User']['password'])
					) {
				
				if($this->request->data['User']['password'] == $this->request->data['User']['repeat_password']) {
					$save['User']['password'] = $this->request->data['User']['password'];
				
				} else {
					$err_msg[] = 'Password Not Match';
					$error = TRUE;
				}
			}
			
				App::import('Vendor', 'solvemedialib');
				
				//$solveMedia = new solvemedialib();
				$privkey = SOLVEMEDIA_PRIV_KEY;
				$hashkey = SOLVEMEDIA_HASH_KEY;
				$solvemedia_response = solvemedia_check_answer($privkey,
									$_SERVER["REMOTE_ADDR"],
									$this->request->data["adcopy_challenge"],
									$this->request->data["adcopy_response"],
									$hashkey);
				if (!$solvemedia_response->is_valid) {
					//echo "Error: ".$solvemedia_response->error;
					//handle incorrect answer
					$err_msg[] = 'Invalid Captcha';
					$error = TRUE;
				}
			
			if($error) {
				$message = '';
				foreach($err_msg as $msg) {
					$message = $msg;
				
				}
				$this->Session->setFlash($err_msg, 'register_failed');
				$this->redirect('/');
			} else {
				
				$role_id = $this->Role->get_id('member');
				$m_id = new MongoId($role_id); 
				$ref = array(
					'$ref' => 'roles',
					'$id'	=> $m_id
					);
					
				$save['User']['role_id'] = $ref;
				if ($this->User->save($save)) {
					$id = $this->User->id;
					$this->request->data['User'] = array_merge($save['User'], array('id' => $id));
					$user_data = $this->User->getById($id);
					$this->Auth->login($user_data['User']);
				
					$this->Session->setFlash('Welcome to NyimpeN.com', 'success_form');
					$this->redirect('/');
				} else {
					$this->Session->setFlash('Oops, Something Wrong!', 'register_failed');
					$this->redirect('/');
				}
			}
		} else {
			$this->layout = 'front';
		
		}
	
	}
	
	public function logout() {
		$this->Session->destroy();
		$this->redirect($this->Auth->logout());
		

	}
	
	private function check_email_address($email) {
		// First, we check that there's one @ symbol, 
		// and that the lengths are right.
		if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
			// Email invalid because wrong number of characters 
			// in one section or wrong number of @ symbols.
			return false;
		}
		
		// Split it into sections to make life easier
		$email_array = explode("@", $email);
		$local_array = explode(".", $email_array[0]);
		for ($i = 0; $i < sizeof($local_array); $i++) {
			if
			(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
			?'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
			$local_array[$i])) {
			  return false;
			}
		}
		
		// Check if domain is IP. If not, 
		// it should be valid domain name
		if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
			$domain_array = explode(".", $email_array[1]);
			if (sizeof($domain_array) < 2) {
				return false; // Not enough parts to domain
			}
			for ($i = 0; $i < sizeof($domain_array); $i++) {
			  if
				(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
				?([A-Za-z0-9]+))$",
				$domain_array[$i])) {
					return false;
				}
			}
		}
		
		return true;
	}
	
	public function detail($username) {
		
		$this->layout = 'front';
		$id = $this->User->field('_id', array('username' => $username));
		
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		
		$user = $this->User->getById($id);
		$bookmarks = $this->Bookmark->getPublicUser($id);
		$name = $user['User']['firstname'];
			
		if(isset($user['User']['lastname'])) 
			$name .= ' '. $user['User']['lastname'];
		
		$title = $name;
		$title .= " ({$user['User']['username']}) | Nyimpen";
		$this->set('user', $user);
		$this->set('bookmarks', $bookmarks);
		$this->set('title_for_layout', $title);
		$this->set('desc_for_layout', sizeof($bookmarks) .  ' Public bookmarks link by ' . $name . ', view more details at nyimpen.tk');
	
	}

}

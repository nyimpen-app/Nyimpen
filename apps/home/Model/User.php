<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Role $Role
 * @property Bookmark $Bookmark
 */
class User extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
	public $primaryKey = '_id';
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Bookmark' => array(
			'className' => 'Bookmark',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	public function beforeSave() {
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}
		
	public function check($params) {
		$field = isset($params['field']) ? $params['field'] : '_id';
		$value = isset($params['value']) ? $params['value'] : 1;
	
		$id = $this->field('_id', array(
					$field => $value
				));
			
		if(!empty($id))
			return FALSE;
		else
			return TRUE;
	}
	
	public function getById($id) {
		
		$cachename = $this->getCacheName($id, array(strtolower($this->name)));
		
		$data = Cache::read($cachename);
		if ($data == FALSE || empty($data)) {
			
				
				$db_data = $this->find('first', array(
						'conditions' => array('id' => $id
					)));
								
				Cache::write($cachename, $db_data);
				$data = Cache::read($cachename);
		}
		
		return $data;
	
	}
	
	public function getPassword($username) {
		return $this->field('password', array('username' => $username));
	}
	
	public function deleteCache($type) {
		$cachename = $this->getCacheName($type, array(strtolower($this->name)));
		
		Cache::delete($cachename);
		
		return TRUE;
	
	}

}

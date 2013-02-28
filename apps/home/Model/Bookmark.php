<?php
App::uses('AppModel', 'Model');
/**
 * Bookmark Model
 *
 * @property User $User
 */
class Bookmark extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';
	public $primaryKey = '_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	
	public function deleteCache($user_id) {
		
		$cachename = $this->getCacheName('user_' . $user_id, array(strtolower($this->name)));
		Cache::delete($cachename);
		
		return true;
		
		
	}
	
	public function getUserBookmark($user_id) {
		$cachename = $this->getCacheName('user_' . $user_id, array(strtolower($this->name)));
		
		$data = Cache::read($cachename);
		if ($data == FALSE || empty($data)) {
			

			$m_id = new MongoId($user_id); 
			$refe = array(
				'$ref' => 'users',
				'$id'	=> $m_id
				);		
								
			$db_data = $this->find('all', array(
							'conditions'	=> array(
								'user_id' => $refe
							),
							'order' => array('created' => '-1'),
							)
						);
	
			foreach($db_data as $key => $item) {
				$db_data[$key]['Bookmark']['url'] = urldecode($item['Bookmark']['url']);
			
			}
			Cache::write($cachename, $db_data);
			$data = Cache::read($cachename);
		}			
		
			return $data;
	
	}
	
	public function getPublicUser($user_id) {
		$cachename = $this->getCacheName('bookmark_public_' . $user_id, array(strtolower($this->name)));
		
		$data = Cache::read($cachename);
		
		if ($data == FALSE || empty($data)) {
			

			$m_id = new MongoId($user_id); 
			$refe = array(
				'$ref' => 'users',
				'$id'	=> $m_id
				);		
								
			$db_data = $this->find('all', array(
							'conditions'	=> array(
								'user_id' 	=> $refe,
								'is_public'	=> 1,
							),
							'order' => 'Bookmark.created DESC'
							)
						);
	
			foreach($db_data as $key => $item) {
				$db_data[$key]['Bookmark']['url'] = urldecode($item['Bookmark']['url']);
			
			}
			Cache::write($cachename, $db_data);
			$data = Cache::read($cachename);
		}		

		return $data;
	
	}
}

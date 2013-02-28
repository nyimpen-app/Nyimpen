<?php
App::uses('AppModel', 'Model');
/**
 * Setting Model
 *
 */
class Coba extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
	public $primaryKey = '_id';

	
	public function beforeSave() {
		
		return true;
	}
		
	public function getOption() {
		$cachename = 'coba';
		$data = Cache::read($cachename);
		if ($data == FALSE || empty($data)) {
											
			$db_data = $this->find('first', array(
							'conditions'	=> array(
								'type' => 'general_option'
							),
						));
	
			
			Cache::write($cachename, $db_data);
			$data = Cache::read($cachename);
		}
		
		
	
	}
	
	public function cobaCoba() {
		echo 'coba';
	
	}

}

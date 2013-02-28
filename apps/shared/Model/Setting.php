<?php
App::uses('AppModel', 'Model');
/**
 * Setting Model
 *
 */
class Setting extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
	public $primaryKey = '_id';
	
	
	public function beforeSave() {
		
		return true;
	}
	
	public function afterSave() {
		$this->deleteCache();
	
	}
		
	public function getOption() {
		$cachename = $this->getCacheName('GeneralSetting', array(strtolower($this->name)));
		
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
		
		return $data;		
	
	}
	
	function deleteCache() {
		$cache_name = $this->getCacheName('GeneralSetting', array(strtolower($this->name)));
		
		Cache::delete($cache_name, 'default');
		
		
		return TRUE;
	}

}

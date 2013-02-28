<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	
	
	public function afterSave() {
		
		$cachename = $this->getCacheName('all', array(strtolower($this->name)));
		Cache::delete($cachename);
		
		return true;
		
		
	}
	public function getById($id) {
		$cachename = $this->getCacheName($id, array(strtolower($this->name)));
		
		$data = Cache::read($cachename);
		if ($data == FALSE || empty($data)) {
		
				$db_data = $this->findById($id);
								
				Cache::write($cachename, $db_data);
				$data = Cache::read($cachename);
		}
		
		return $data;
	
	}
	
	public function getCacheName($function, $params = array()) {
		
		if (empty($function)) {
			return FALSE;
		}

		$nameSet = array_merge($params, array($function));

		return implode('_', $nameSet);

	}
}

<?php

// Intention is to call the static functions in this class from anywhere, just like calls to core functions

require_once 'CRM/Core/Page.php';

class CRM_Sequence_Page_PumSequence extends CRM_Core_Page {
  function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(ts('PumSequence'));

    // Example: Assign a variable for use in a template
    $this->assign('currentTime', date('Y-m-d H:i:s'));

    parent::run();
  }
  
  
  static function create($name=NULL, $cur_value=1, $min_value=1, $max_value=18446744073709551615, $increment=1, $cycle=FALSE) {
		if ($name=='') {
			return FALSE;
		} else {
			$name=substr($name, 0, 100);
		}
		$params = array(
			'version' => 3,
			'q' => 'civicrm/ajax/rest',
			'name' => $name,
			'min_value' => $min_value,
			'max_value' => $max_value,
			'cur_value' => $cur_value,
			'increment' => $increment,
			'cycle' => ($cycle?1:0),
		);
		$result = civicrm_api('Sequence', 'create', $params);
		if ($result['is_error']==0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	
	static function nextval($name=NULL) {
		if ($name=='') {
			return NULL;
		} else {
			$name=substr($name, 0, 100);
		}
		$params = array(
			'version' => 3,
			'q' => 'civicrm/ajax/rest',
			'name' => $name,
		);
		$result = civicrm_api('Sequence', 'nextval', $params);
		if ($result['is_error']==0) {
			return $result['values'];
		} else {
			return NULL;
		}
	}
}

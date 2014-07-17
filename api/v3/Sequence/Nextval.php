<?php

/**
 * Sequence.Nextval API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRM/API+Architecture+Standards
 */
function _civicrm_api3_sequence_nextval_spec(&$spec) {
  	$spec['name'] = array(
		'title'			=> 'Name of the sequence',
		'type'			=> 'string',
		'api.required'	=> 1,
	);
}

/**
 * Sequence.Nextval API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_sequence_nextval($params) {
	$name = $params['name'];
	$sql = 'SELECT * from civicrm_pum_sequence WHERE name=\'' . $name . '\'';
	$dao = CRM_Core_DAO::executeQuery($sql);
	if ($dao->N <>  1) {
		throw new API_Exception('Could not retrieve next value for sequence \''. $name . '\'');
	} else {
		$returnValues = NULL;
		if ($dao->fetch()) {
			$cur_val = $dao->cur_value;
			$returnValues = $cur_val;
			$next_val = $cur_val + $dao->increment;
			if ($next_val > $dao->max_value) {
				if ($dao->cycle) {
					$next_val = $dao->min_value;
				} else {
					$next_val = NULL;
				}
			} elseif ($next_val < $dao->min_value) {
				if ($dao->cycle) {
					$next_val = $dao->min_value;
				} else {
					$next_val = NULL;
				}
			}
			if (!is_null($next_val)) {
				$sql = 'UPDATE civicrm_pum_sequence SET cur_value = ' . $next_val . ' WHERE name = \'' . $name . '\'';
				$dao = CRM_Core_DAO::executeQuery($sql);
			}
		}
		return civicrm_api3_create_success($returnValues, $params);
	}
}


<?php

/**
 * Sequence.Create API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRM/API+Architecture+Standards
 */
function _civicrm_api3_sequence_create_spec(&$spec) {
	$spec['name'] = array(
		'title'			=> 'Name of the sequence',
		'type'			=> 'string',
		'api.required'	=> 1,
	);
	$spec['cur_value'] = array(
		'title'			=> 'The next value to be handed out',
		'type'			=> 'bigint(20)',
	);
	$spec['min_value'] = array(
		'title'			=> 'Lowerbound',
		'type'			=> 'bigint(20)',
	);
	$spec['max_value'] = array(
		'title'			=> 'Upperbound',
		'type'			=> 'bigint(20)',
	);
	$spec['increment'] = array(
		'title'			=> 'Increment',
		'type'			=> 'bigint(20)',
	);
	$spec['cycle'] = array(
		'title'			=> 'Continue at lowerbound after reaching the upperbound',
		'type'			=> 'boolean',
	);
}

/**
 * Sequence.Create API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_sequence_create($params) {
  $sql_cols = array();
  $sql_vals = array();
  if (array_key_exists('name', $params)) {
	$sql_cols[] = 'name';
	$sql_vals[] = '\'' . $params['name'] . '\'';
  }
  if (array_key_exists('increment', $params)) {
	if ($params['increment']>0) { 
		$sql_cols[] = 'increment';
		$sql_vals[] = $params['increment'];
	}
  }
  if (array_key_exists('min_value', $params)) {
	$sql_cols[] = 'min_value';
	$sql_vals[] = $params['min_value'];
  }
  if (array_key_exists('max_value', $params)) {
	$sql_cols[] = 'max_value';
	$sql_vals[] = $params['max_value'];
  }
  if (array_key_exists('cur_value', $params)) {
	$sql_cols[] = 'cur_value';
	$sql_vals[] = $params['cur_value'];
  }
  if (array_key_exists('cycle', $params)) {
	$sql_cols[] = 'cycle';
	$sql_vals[] = $params['cycle'];
  }
  $sql = 'INSERT INTO civicrm_pum_sequence (' . implode(', ', $sql_cols) . ') VALUES (' . implode(', ', $sql_vals) . ')';
  $dao = CRM_Core_DAO::executeQuery($sql);
  
  if ($dao->is_error ==  1) {
	throw new API_Exception($dao->error_message);
  } else {
	$returnValues = array();
	return civicrm_api3_create_success($returnValues, $params);
  }
}


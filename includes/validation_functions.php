<?php
$errors = array();

function fieldname_as_text($fieldname){
	$fieldname = str_replace("_"," ",$fieldname);
	$fieldname = ucfirst($fieldname);
	return $fieldname;
        }
		
// * presence
// use trim() so empty spaces don't count
// use === to avoid false positives
// empty() would consider "0" to be empty

// to avoid this case $vlue="   " many spaces i put trim function or i put new conditions 
//if(!isset($value) || (empty($value) && !is_numeric($value))){
	function has_presence($value){
		// return boolean here 
	
	return isset($value) && $value!=="";
	}
	
	function validate_presences($required_fields){
		
		global $errors;
		foreach($required_fields as $field){
			$value= trim($_POST[$field]);
			if(!has_presence($value)){
				
				$errors[$field]=fieldname_as_text($field) . " can't be blank";
			}
				
		}
	
	}

// max length
function has_max_length($value,$max){
return strlen($value)<= $max ;
}

function validate_max_lengths($fields_with_max_lenghts){
	// verry important the global vriable here..
	global $errors;
	// using an assoc. array
	foreach($fields_with_max_lenghts as $field => $max){
		$value=trim($_POST[$field]);
		if(!has_max_length($value,$max)){
	
	$errors[$field]= fieldname_as_text($field)." is too long";
	}
	}
}

// * inclusion in a set
function has_inclusion_in($value,$set){
return in_array($value,$set);
}






?>

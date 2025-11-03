<?php
/*
 *	Survey User Class
 *
 *
 */
 
class SurveyUser {

	private $id;
	private $tlId;
	
	public function __get($property) {
		if (property_exists($this, $property)) 
		  return $this->$property;
	 }
	 

	public function __set($property, $value) {
		if (property_exists($this, $property)) 
		  $this->$property = $value;
	}
	
	 
	public function getTlUsername() {
		
		return Database::ExecuteScalar("SELECT users.username FROM users WHERE id = {$this->tlId}");
		
	}


}
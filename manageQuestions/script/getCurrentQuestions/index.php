<?php
#ini_set('error_reporting', E_ALL);
#ini_set("display_errors", 1);
include('../../../../../kernel.inc.php');

	Database::ExecuteQuery("SET CHARACTER SET utf8");
	
	
	$cur = Database::ExecuteQuery("SELECT id, label AS name, correct, enabled FROM surveys.survey_answers WHERE questionId = {$_GET['questionId']}");
	$arr = array();
	
	while($record=Database::FetchRecord($cur)){
		array_push($arr, array('id' => $record['id'], 'name' => htmlspecialchars($record['name']), 'correct' => intval($record['correct']), 'enabled' => $record['enabled']));
		//array_push($arr, array('id'=>'id'.$i,'content'=>'content'.$i)); 
	}
	 
	
		echo json_encode($arr);
	
?>

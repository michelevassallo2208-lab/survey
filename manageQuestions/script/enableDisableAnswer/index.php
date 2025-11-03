<?php
#ini_set('error_reporting', E_ALL);
#ini_set("display_errors", 1);
include('../../../../../kernel.inc.php');

	Database::ExecuteQuery("SET NAMES 'utf8'");
	Database::ExecuteQuery("SET CHARACTER SET utf8");

	$type = $_GET['type'];
	$answerId = $_GET['answerId'];
	$questionId = $_GET['questionId'];
	
	switch($type){
		case 'enable':
			$enabledStatus = "true";
			break;
			
		case 'disable':
			$enabledStatus = "false";
			break;
	}
	
	Database::ExecuteUpdate("UPDATE surveys.survey_answers SET enabled='{$enabledStatus}' WHERE id = {$answerId}");
	
	
	$cur = Database::ExecuteQuery("SELECT id, label AS name, correct, enabled FROM surveys.survey_answers WHERE questionId = {$questionId}");
	$arr = array();
	while($record=Database::FetchRecord($cur)){
			
		array_push($arr, array('id' => $record['id'], 'name' => htmlspecialchars($record['name']), 'correct' => intval($record['correct']), 'enabled' => $record['enabled']));
	}
	 
	
		echo json_encode($arr);
	
?>

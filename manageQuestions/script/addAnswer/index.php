<?php
//ini_set('error_reporting', E_ALL);
//ini_set("display_errors", 1);
include('../../../../../kernel.inc.php');

	$answer = trim($_POST['answerName']);	
	$questionId = $_POST['questionId'];
	
	 
	 Database::ExecuteQuery("SET NAMES 'utf8'");
	 Database::ExecuteQuery("SET CHARACTER SET utf8");
	
	$answerComplete = Database::EscapeString($answer,true); 
	
	
	Database::ExecuteInsert("INSERT INTO surveys.survey_answers (label, questionId, correct, enabled) VALUES ('{$answerComplete}', {$questionId}, '0', 'true')");
	
		
	$cur = Database::ExecuteQuery("SELECT id, label AS name, correct, enabled FROM surveys.survey_answers WHERE questionId = {$questionId}");
	$arr = array();
	while($record=Database::FetchRecord($cur)){
			
		array_push($arr, array('id' => $record['id'], 'name' => htmlspecialchars($record['name']), 'correct' => intval($record['correct']), 'enabled' => $record['enabled']));
	}
	 
	
		echo json_encode($arr);
	
?>

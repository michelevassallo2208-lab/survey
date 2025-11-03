<?php
#ini_set('error_reporting', E_ALL);
#ini_set("display_errors", 1);
include('../../../../../kernel.inc.php');
	
	Database::ExecuteQuery("SET NAMES 'utf8'");
	Database::ExecuteQuery("SET CHARACTER SET utf8");


	$status = $_GET['answerStatus'];
	$answerId = $_GET['answerId'];
	$questionId = $_GET['questionId'];
	
		
		
	switch($status){
		case 'true'://CHROME
		case '0'://FIREFOX
			$correctStatus = "1";
			break;
			
		case 'false'://CHROME
		case '1'://FIREFOX
			$correctStatus = "0";
			break;
	}
	
	Database::ExecuteUpdate("UPDATE surveys.survey_answers SET correct='{$correctStatus}' WHERE id = {$answerId}");
	
	
	
	
	$cur = Database::ExecuteQuery("SELECT id, label AS name, correct, enabled FROM surveys.survey_answers WHERE questionId = {$questionId}");
	$arr = array();
	while($record=Database::FetchRecord($cur)){
			
		array_push($arr, array('id' => $record['id'], 'name' => htmlspecialchars($record['name']), 'correct' => intval($record['correct']), 'enabled' => $record['enabled']));
	}
	 
	
		echo json_encode($arr);
	
?>

<?php
global $survey_manageQuestions;


$record = $survey_manageQuestions['manager']->readById($survey_manageQuestions['id']);
$survey_manageQuestions['sheet']->fromDbRecord($record);		

		
$survey_manageQuestions['sheet']->setAndCheck();



if ($survey_manageQuestions['sheet']->wasSubmitted() && !$survey_manageQuestions['sheet']->hasErrors()) {
	
	$copyId = $survey_manageQuestions['id'];
	$record = $survey_manageQuestions['sheet']->toDbRecord();
	

	
	
	unset($record['job']);
	unset($record['marketId']);
		
	$insertedId = $survey_manageQuestions['manager']->insert($record);
	
	$answerCur = Database::ExecuteQuery("SELECT * FROM surveys.survey_answers WHERE questionId = {$copyId} AND enabled = 'true'");
	
	
	
	while($answerRecord = Database::FetchRecord($answerCur)) {
		
		Database::ExecuteQuery("INSERT INTO surveys.survey_answers (label, questionId, correct, enabled) VALUES (\"{$answerRecord['label']}\", {$insertedId}, '{$answerRecord['correct']}', '{$answerRecord['enabled']}')");
		
	}
	
	Header::JsRedirect(Self(false, '_msg=inserted'));
	
}else{
	$survey_manageQuestions['buttons']['submit']->text = 'Duplica';	
	$survey_manageQuestions['sheet']->command = 'duplicate';
	$survey_manageQuestions['sheet']->show();
}
?>

<a class="tolist" href="<?=Language::GetAddress($survey_manageQuestions['manager']->folder . '/')?>">Torna all'elenco</a>
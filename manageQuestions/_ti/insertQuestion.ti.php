<?php
global $survey_manageQuestions;


$survey_manageQuestions['sheet']->setAndCheck();	

$record = $survey_manageQuestions['sheet']->toDbRecord();


	
if ($survey_manageQuestions['sheet']->wasSubmitted() ) {
	

	
}	
	
	

if ($survey_manageQuestions['sheet']->wasSubmitted() && !$survey_manageQuestions['sheet']->hasErrors()) {
	
	unset($record['job']);
	unset($record['marketId']);

	$survey_manageQuestions['manager']->table = 'surveys.survey_questions';
	
	$survey_manageQuestions['manager']->insert($record);	
	Header::JsRedirect(Language::GetAddress('survey/manageQuestions/?_command=list&_msg=inserted'));
		
}else {
	
	$survey_manageQuestions['buttons']['submit']->text = 'Inserisci';		
	$survey_manageQuestions['sheet']->command = 'insertQuestion';
	$survey_manageQuestions['sheet']->show();
}	
?>

<a class="tolist" href="<?=Language::GetAddress($survey_manageQuestions['manager']->folder . '/')?>">Torna all'elenco</a>
<script type="text/javascript" language="javascript" src="/_js/jquery-ui.js"> </script>
<script src="/_js/jquery.ui.datepicker-it.js" language="javascript" type="text/javascript"></script>
<link href="/_css/jquery-ui.css" type="text/css" rel="stylesheet"></link>
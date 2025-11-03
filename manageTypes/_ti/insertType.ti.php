<?php
global $survey_manageTypes;


$survey_manageTypes['sheet']->setAndCheck();	

$record = $survey_manageTypes['sheet']->toDbRecord();
	
if ($survey_manageTypes['sheet']->wasSubmitted() ) {
	
	
}	
	
	

if ($survey_manageTypes['sheet']->wasSubmitted() && !$survey_manageTypes['sheet']->hasErrors()) {

	/* $record['creationDt'] 	= 'NOW()';
	$record['creatorId'] 	= Session::GetUser('id'); */
	
	$survey_manageTypes['manager']->table = 'surveys.survey_types';
	
	
	$survey_manageTypes['manager']->insert($record);	
	Header::JsRedirect(Language::GetAddress('survey/manageTypes/?_command=list&_msg=inserted'));
		
}else {
	
	$survey_manageTypes['buttons']['submit']->text = 'Inserisci';		
	$survey_manageTypes['sheet']->command = 'insertType';
	$survey_manageTypes['sheet']->show();
}	
?>

<a class="tolist" href="<?=Language::GetAddress($survey_manageTypes['manager']->folder . '/')?>">Torna all'elenco</a>
<script type="text/javascript" language="javascript" src="/_js/jquery-ui.js"> </script>
<script src="/_js/jquery.ui.datepicker-it.js" language="javascript" type="text/javascript"></script>
<link href="/_css/jquery-ui.css" type="text/css" rel="stylesheet"></link>
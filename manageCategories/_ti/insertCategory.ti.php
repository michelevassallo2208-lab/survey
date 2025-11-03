<?php
global $survey_manageCategories;


$survey_manageCategories['sheet']->setAndCheck();	

$record = $survey_manageCategories['sheet']->toDbRecord();
	
if ($survey_manageCategories['sheet']->wasSubmitted() ) {
	
		
	$marketCheck = Database::ExecuteRecord("SELECT job FROM centre_ccsud.users_market WHERE id IN( {$record['marketId']} )");
	
	if($marketCheck['job'] != $record['job']){
		$survey_manageCategories['sheet']->addSummaryError("Specificare la commessa corretta per il mercato selezionato.");
	}
	
}	
	
	

if ($survey_manageCategories['sheet']->wasSubmitted() && !$survey_manageCategories['sheet']->hasErrors()) {

	/* $record['creationDt'] 	= 'NOW()';
	$record['creatorId'] 	= Session::GetUser('id'); */
	
	$survey_manageCategories['manager']->table = 'surveys.survey_categories';
	
	
	$survey_manageCategories['manager']->insert($record);	
	Header::JsRedirect(Language::GetAddress('survey/manageCategories/?_command=list&_msg=inserted'));
		
}else {
	
	$survey_manageCategories['buttons']['submit']->text = 'Inserisci';		
	$survey_manageCategories['sheet']->command = 'insertCategory';
	$survey_manageCategories['sheet']->show();
}	
?>

<a class="tolist" href="<?=Language::GetAddress($survey_manageCategories['manager']->folder . '/')?>">Torna all'elenco</a>
<script type="text/javascript" language="javascript" src="/_js/jquery-ui.js"> </script>
<script src="/_js/jquery.ui.datepicker-it.js" language="javascript" type="text/javascript"></script>
<link href="/_css/jquery-ui.css" type="text/css" rel="stylesheet"></link>
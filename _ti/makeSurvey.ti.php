<?php
global $survey;
#ini_set('error_reporting', E_ALL);
ini_set("display_errors", 1);
$survey['sheet']->setAndCheck();	

$record = $survey['sheet']->toDbRecord();
	
if ($survey['sheet']->wasSubmitted() ) {
	
		
	$marketCheck = Database::ExecuteRecord("SELECT job FROM centre_ccsud.users_market WHERE id = {$record['marketId']} LIMIT 1");
	
	if($marketCheck['job'] != $record['job']){
		$survey['sheet']->addSummaryError("Specificare la commessa corretta per il mercato selezionato.");
	}
	
}	
	
	

if ($survey['sheet']->wasSubmitted() && !$survey['sheet']->hasErrors()) {

	$record['creationDt'] 	= 'NOW()';
	$record['creatorId'] 	= Session::GetUser('id');
	
	$survey['manager']->table = 'surveys.survey';
	
	
	$survey['manager']->insert($record,'creationDt');	
	Header::JsRedirect(Language::GetAddress('survey/?_command=list&_msg=inserted'));
		
}else {
	
	$survey['buttons']['submit']->text = 'Inserisci';		
	$survey['sheet']->command = 'makeSurvey';
	$survey['sheet']->show();
}	
?>

<a class="tolist" href="<?=Language::GetAddress($survey['manager']->folder . '/')?>">Torna all'elenco</a>
<script type="text/javascript" language="javascript" src="/_js/jquery-ui.js"> </script>
<script src="/_js/jquery.ui.datepicker-it.js" language="javascript" type="text/javascript"></script>
<link href="/_css/jquery-ui.css" type="text/css" rel="stylesheet"></link>
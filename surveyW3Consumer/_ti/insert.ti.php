<?php
global $surveyW3Consumer;

$surveyW3Consumer['sheet']->setAndCheck();	

$record = $surveyW3Consumer['sheet']->toDbRecord();
$userId = Session::GetUser('id');

if(Session::UserHasOneOfProfilesIn('3')) {
	
	$alreadyInserted = Database::ExecuteScalar("SELECT id FROM surveys.surveyW3Consumer WHERE userId = {$userId}");
	
	if($alreadyInserted > 0)
		die('Hai gi&agrave; inserito il questionario');
	
}
if ($surveyW3Consumer['sheet']->wasSubmitted()){
			

}


if ($surveyW3Consumer['sheet']->wasSubmitted() && !$surveyW3Consumer['sheet']->hasErrors()) {


	$record['insertDt'] = 'NOW()';
	$record['userId'] 	= Session::GetUser('id');
	
	$surveyW3Consumer['manager']->insert($record,'insertDt');	
	
	Javascript("alert('Sondaggio Inserito!')");
	Session::SetUser('_surveyW3','compiled');
	Session::Set('_redirectPriority','');
	
	Header::JsRedirect(Language::GetAddress('home'));
	
}else {
	$surveyW3Consumer['buttons']['submit']->text = 'Inserisci';		
	$surveyW3Consumer['sheet']->command = 'insert';
	$surveyW3Consumer['sheet']->show();
}	
?>
<script type="text/javascript" language="javascript" src="/_js/jquery-ui.js"> </script>
<script src="/_js/jquery.ui.datepicker-it.js" language="javascript" type="text/javascript"></script>
<link href="/_css/jquery-ui.css" type="text/css" rel="stylesheet"></link>

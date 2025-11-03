<?php
global $surveyLocker;

$surveyLocker['sheet']->setAndCheck();	

$record = $surveyLocker['sheet']->toDbRecord();
$userId = Session::GetUser('id');

if(Session::UserHasOneOfProfilesIn('3')) {
	
	$alreadyInserted = Database::ExecuteScalar("SELECT id FROM surveys.survey_locker WHERE userId = {$userId}");
	
	if($alreadyInserted > 0)
		die('Hai gi&agrave; inserito il questionario');
	
}
if ($surveyLocker['sheet']->wasSubmitted()){
			

}


if ($surveyLocker['sheet']->wasSubmitted() && !$surveyLocker['sheet']->hasErrors()) {


	$record['insertDt'] = 'NOW()';
	$record['userId'] 	= Session::GetUser('id');
	
	$surveyLocker['manager']->insert($record,'insertDt');	
	
	Javascript("alert('Sondaggio Inserito!')");
	Session::SetUser('_lockerSurvey','compiled');
	Session::Set('_redirectPriority','');
	
	Header::JsRedirect(Language::GetAddress('home'));
	
}else {
	$surveyLocker['buttons']['submit']->text = 'Inserisci';		
	$surveyLocker['sheet']->command = 'insert';
	$surveyLocker['sheet']->show();
}	
?>
<script type="text/javascript" language="javascript" src="/_js/jquery-ui.js"> </script>
<script src="/_js/jquery.ui.datepicker-it.js" language="javascript" type="text/javascript"></script>
<link href="/_css/jquery-ui.css" type="text/css" rel="stylesheet"></link>

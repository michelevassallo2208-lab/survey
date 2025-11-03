<?php
global $surveyGym;

$surveyGym['sheet']->setAndCheck();	

$record = $surveyGym['sheet']->toDbRecord();
$userId = Session::GetUser('id');

if(Session::UserHasOneOfProfilesIn('3')) {
	
	$alreadyInserted = Database::ExecuteScalar("SELECT id FROM surveys.survey_gym WHERE userId = {$userId}");
	
	if($alreadyInserted > 0)
		die('Hai gi&agrave; inserito il questionario');
	
}
if ($surveyGym['sheet']->wasSubmitted()){
			

}


if ($surveyGym['sheet']->wasSubmitted() && !$surveyGym['sheet']->hasErrors()) {


	$record['insertDt'] = 'NOW()';
	$record['userId'] 	= Session::GetUser('id');
	
	$surveyGym['manager']->insert($record,'insertDt');	
	
	Javascript("alert('Sondaggio Inserito!')");
	Session::SetUser('_gymSurvey','compiled');
	Session::Set('_redirectPriority','');
	
	Header::JsRedirect(Language::GetAddress('home'));
	
}else {
	$surveyGym['buttons']['submit']->text = 'Inserisci';		
	$surveyGym['sheet']->command = 'insert';
	$surveyGym['sheet']->show();
}	
?>
<script type="text/javascript" language="javascript" src="/_js/jquery-ui.js"> </script>
<script src="/_js/jquery.ui.datepicker-it.js" language="javascript" type="text/javascript"></script>
<link href="/_css/jquery-ui.css" type="text/css" rel="stylesheet"></link>

<?php
global $surveyAquila;

$surveyAquila['sheet']->setAndCheck();	

$record = $surveyAquila['sheet']->toDbRecord();
$userId = Session::GetUser('id');

if(Session::UserHasOneOfProfilesIn('3')) {
	
	$alreadyInserted = Database::ExecuteScalar("SELECT id FROM surveys.survey_access_aquila WHERE userId = {$userId}");
	
	if($alreadyInserted > 0)
		die('Hai gi&agrave; inserito il questionario');
	
}
echo "<h5>Indica la tua login e rispondi alla seguente domanda per ogni applicativo: <br><br>Riesci ad accedere all'applicativo?</h5>";
if ($surveyAquila['sheet']->wasSubmitted()){
			

}


if ($surveyAquila['sheet']->wasSubmitted() && !$surveyAquila['sheet']->hasErrors()) {


	$record['insertDt'] = 'NOW()';
	$record['userId'] 	= Session::GetUser('id');
	
	$surveyAquila['manager']->insert($record,'insertDt');	
	
	Javascript("alert('Questionario Inserito!')");
	Session::SetUser('_accessSurvey','compiled');
	Session::Set('_redirectPriority','');
	
	Header::JsRedirect(Language::GetAddress('c2c_crm/home'));
	
}else {
	$surveyAquila['buttons']['submit']->text = 'Inserisci';		
	$surveyAquila['sheet']->command = 'insert';
	$surveyAquila['sheet']->show();
}	
?>
<script type="text/javascript" language="javascript" src="/_js/jquery-ui.js"> </script>
<script src="/_js/jquery.ui.datepicker-it.js" language="javascript" type="text/javascript"></script>
<link href="/_css/jquery-ui.css" type="text/css" rel="stylesheet"></link>

<?php
global $surveyHeadset;

$surveyHeadset['sheet']->setAndCheck();	

$record = $surveyHeadset['sheet']->toDbRecord();
$userId = Session::GetUser('id');

if(Session::UserHasOneOfProfilesIn('3')) {
	
	$alreadyInserted = Database::ExecuteScalar("SELECT id FROM surveys.survey_headset WHERE userId = {$userId}");
	
	if($alreadyInserted > 0)
		die('Hai gi&agrave; inserito il questionario');
	
}
if ($surveyHeadset['sheet']->wasSubmitted()){
	
	if (!preg_match('/^\d{8}$/', $record['firstQ'])) {
		$surveyHeadset['fields']['firstQ']->setError("Il seriale adattatore deve essere di 8 cifre");
	}
	
	if (!preg_match('/^\d{8}$/', $record['secondQ'])) {
		$surveyHeadset['fields']['secondQ']->setError("Il seriale adattatore deve essere di 8 cifre");
	}

}
?>

<p><b>Ricercare i seriali delle proprie cuffie in dotazione (come indicato nelle foto) e riportarli negli appositi campi.</b><br>
	N.B. I seriali devono essere composti da <b>8 cifre</b></p>
<div class="cont">
<h3>Seriale cuffie (parte superiore)</h3>
	<div class="cont-img">
		<img src="<?=GetImageAddress('serialeCuffie.jpg')?>" />
	</div>
</div>
<div class="cont">
<h3>Seriale adattatore (parte inferiore)</h3>
	<div class="cont-img">
		<img src="<?=GetImageAddress('serialeAdattatore.jpg')?>" />
	</div>
</div>

<?php
if ($surveyHeadset['sheet']->wasSubmitted() && !$surveyHeadset['sheet']->hasErrors()) {


	$record['insertDt'] = 'NOW()';
	$record['userId'] 	= Session::GetUser('id');
	
	$surveyHeadset['manager']->insert($record,'insertDt');	
	
	Javascript("alert('Sondaggio Inserito!')");
	Session::SetUser('_headsetSurvey','compiled');
	Session::Set('_redirectPriority','');
	die('Ricaricare la pagina');
	Header::JsRedirect(Language::GetAddress('home'));
	
}else {
	$surveyHeadset['buttons']['submit']->text = 'Inserisci';		
	$surveyHeadset['sheet']->command = 'insert';
	$surveyHeadset['sheet']->show();
}	
?>
<script type="text/javascript" language="javascript" src="/_js/jquery-ui.js"> </script>
<script src="/_js/jquery.ui.datepicker-it.js" language="javascript" type="text/javascript"></script>
<link href="/_css/jquery-ui.css" type="text/css" rel="stylesheet"></link>

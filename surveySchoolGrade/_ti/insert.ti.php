<?php
global $surveySchoolGrade;

$surveySchoolGrade['sheet']->setAndCheck();	

$record = $surveySchoolGrade['sheet']->toDbRecord();
$userId = Session::GetUser('id');

if(Session::UserHasOneOfProfilesIn('3')) {
	
	$alreadyInserted = Database::ExecuteScalar("SELECT id FROM surveys.surveySchoolGrade WHERE userId = {$userId}");
	
	if($alreadyInserted > 0)
		die('Hai gi&agrave; inserito il questionario');
	
}
if ($surveySchoolGrade['sheet']->wasSubmitted()){
			

}


if ($surveySchoolGrade['sheet']->wasSubmitted() && !$surveySchoolGrade['sheet']->hasErrors()) {


	$record['insertDt'] = 'NOW()';
	$record['userId'] 	= Session::GetUser('id');
	unset($record['yesOrNo']);
	
	$surveySchoolGrade['manager']->insert($record,'insertDt');	
	
	Javascript("alert('Sondaggio Inserito!')");
	Session::SetUser('_surveySchoolGrade','compiled');
	Session::Set('_redirectPriority','');
	
	Header::JsRedirect(Language::GetAddress('home'));
	
}else {
	$surveySchoolGrade['buttons']['submit']->text = 'Inserisci';		
	$surveySchoolGrade['sheet']->command = 'insert';
	$surveySchoolGrade['sheet']->show();
}	
?>
<script type="text/javascript" language="javascript" src="/_js/jquery-ui.js"> </script>
<script src="/_js/jquery.ui.datepicker-it.js" language="javascript" type="text/javascript"></script>
<link href="/_css/jquery-ui.css" type="text/css" rel="stylesheet"></link>


<script type="text/javascript">
	$(document).ready(function() {
		

		$('#secondQ').closest('tr').hide();

		
		$("#yesOrNo").change(function() {
			if($(this).val()== 'Si') { 
				$('#secondQ').closest('tr').show();
		
			}else{
				$('#secondQ').closest('tr').hide();
			}
		});
	});
</script>

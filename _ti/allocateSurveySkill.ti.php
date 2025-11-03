<?php
global $survey;



$survey['sheet']->setAndCheck();		
$record = $survey['sheet']->toDbRecord();

$surveyId = $_GET['surveyId'];

 

if ($survey['sheet']->wasSubmitted() && !$survey['sheet']->hasErrors()) {

	
	
	Database::ExecuteInsert("INSERT INTO surveys.survey_pivot_ca (idSurvey, idCa, token) SELECT {$surveyId}, centre_ccsud.users.id, SHA2(CONCAT(centre_ccsud.users.id,{$surveyId}), 224)  
	FROM centre_ccsud.users WHERE centre_ccsud.users.preferredActivityId={$record['skillId']} AND users.location='{$record['location']}'");

	?>
		<script type="text/javascript" language="javascript">
				alert('Operatori con la Skill selezionata Inseriti!');
				window.opener.location.reload(true);
				window.close();
		</script>
			<?
	
}else{
		
	$survey['sheet']->command = 'allocateSurveySkill';
	$survey['sheet']->show();
}


	
?>
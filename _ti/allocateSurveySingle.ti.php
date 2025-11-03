<?php
global $survey;



$survey['sheet']->setAndCheck();		
$record = $survey['sheet']->toDbRecord();

$surveyId = $_GET['surveyId'];


if ($survey['sheet']->wasSubmitted() && !$survey['sheet']->hasErrors()) {
	
	Database::ExecuteInsert("INSERT INTO surveys.survey_pivot_ca (idSurvey, idCa, token) VALUES ({$surveyId}, {$record['userId']}, SHA2(CONCAT({$record['userId']},{$surveyId}), 256))");
	?>
		<script type="text/javascript" language="javascript">
				alert('Nuovo Operatore Inserito!');
				window.opener.location.reload(true);
				window.close();
		</script>
			<?
	
}else{
		
	$survey['sheet']->command = 'allocateSurveySingle';
	$survey['sheet']->show();
}


	
?>
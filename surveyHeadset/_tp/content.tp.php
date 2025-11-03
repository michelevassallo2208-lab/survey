
<?php global $surveyHeadset; 

?>

<h2>Censimento cuffie</h2>

<?php
if($surveyHeadset['command'] == 'insert')
	
?>

<?php $surveyHeadset['message']->show(); ?>

<?php

if ($surveyHeadset['sheet']->hasMessage()) 
	echo($surveyHeadset['sheet']->getMessage());	
	
Template::ShowInterface();
?>	

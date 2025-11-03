
<?php global $surveyGym; 

?>

<h2>Sondaggio</h2>

<?php
if($surveyGym['command'] == 'insert')
	
?>

<?php $surveyGym['message']->show(); ?>

<?php

if ($surveyGym['sheet']->hasMessage()) 
	echo($surveyGym['sheet']->getMessage());	
	
Template::ShowInterface();
?>	

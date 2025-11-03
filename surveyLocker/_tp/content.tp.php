
<?php global $surveyLocker; 

?>

<h2>Sondaggio</h2>

<?php
if($surveyLocker['command'] == 'insert')
	
?>

<?php $surveyLocker['message']->show(); ?>

<?php

if ($surveyLocker['sheet']->hasMessage()) 
	echo($surveyLocker['sheet']->getMessage());	
	
Template::ShowInterface();
?>	

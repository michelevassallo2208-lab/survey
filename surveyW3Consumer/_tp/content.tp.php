
<?php global $surveyW3Consumer; 

?>

<h2>Sondaggio W3 Consumer</h2>

<?php
if($surveyW3Consumer['command'] == 'insert')
	
?>

<?php $surveyW3Consumer['message']->show(); ?>

<?php

if ($surveyW3Consumer['sheet']->hasMessage()) 
	echo($surveyW3Consumer['sheet']->getMessage());	
	
Template::ShowInterface();
?>	

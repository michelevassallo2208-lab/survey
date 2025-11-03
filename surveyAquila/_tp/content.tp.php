
<?php global $surveyAquila; 

?>

<h2>Questionario accesso L'Aquila</h2>

<?php
if($surveyAquila['command'] == 'insert')
	
?>

<?php $surveyAquila['message']->show(); ?>

<?php

if ($surveyAquila['sheet']->hasMessage()) 
	echo($surveyAquila['sheet']->getMessage());	
	
Template::ShowInterface();
?>	

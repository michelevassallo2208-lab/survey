<?php global $survey_manageQuestions; ?>


<?php
if ($survey_manageQuestions['command']=="insert") {
	?>
<h2>INDICA QUALE TRA LE POSSIBILI SCELTE e' QUELLA PIU' GIUSTA PER APPLICARE CORRETTAMENTE IL PROCESSO DI RICONOSCIMENTO E AUTENTICAZIONE</h2>	
	<?
}


$survey_manageQuestions['message']->show(); ?>

<?php

if ($survey_manageQuestions['sheet']->hasMessage()) 
	echo($survey_manageQuestions['sheet']->getMessage());	
	
Template::ShowInterface();
?>	


<?php global $survey_manageTypes; ?>


<?php
if ($survey_manageTypes['command']=="insert") {
	?>
<h2>INDICA QUALE TRA LE POSSIBILI SCELTE e' QUELLA PIU' GIUSTA PER APPLICARE CORRETTAMENTE IL PROCESSO DI RICONOSCIMENTO E AUTENTICAZIONE</h2>	
	<?
}


$survey_manageTypes['message']->show(); ?>

<?php

if ($survey_manageTypes['sheet']->hasMessage()) 
	echo($survey_manageTypes['sheet']->getMessage());	
	
Template::ShowInterface();
?>	


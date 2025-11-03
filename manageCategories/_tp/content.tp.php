<?php global $survey_manageCategories; ?>


<?php
if ($survey_manageCategories['command']=="insert") {
	?>
<h2>INDICA QUALE TRA LE POSSIBILI SCELTE e' QUELLA PIU' GIUSTA PER APPLICARE CORRETTAMENTE IL PROCESSO DI RICONOSCIMENTO E AUTENTICAZIONE</h2>	
	<?
}


$survey_manageCategories['message']->show(); ?>

<?php

if ($survey_manageCategories['sheet']->hasMessage()) 
	echo($survey_manageCategories['sheet']->getMessage());	
	
Template::ShowInterface();
?>	


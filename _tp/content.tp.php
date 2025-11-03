<?php global $survey; ?>


<?php
if ($survey['command']=="insert") {
	?>
<h2>INDICA QUALE TRA LE POSSIBILI SCELTE e' QUELLA PIU' GIUSTA</h2>	
	<?
}


$survey['message']->show(); ?>

<?php

if ($survey['sheet']->hasMessage()) 
	echo($survey['sheet']->getMessage());	
	
Template::ShowInterface();
?>	


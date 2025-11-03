
<?php global $surveySchoolGrade; 

?>

<h2>Sondaggio</h2>

<?php
if($surveySchoolGrade['command'] == 'insert')
	
?>

<?php $surveySchoolGrade['message']->show(); ?>

<?php

if ($surveySchoolGrade['sheet']->hasMessage()) 
	echo($surveySchoolGrade['sheet']->getMessage());	
	
Template::ShowInterface();
?>	

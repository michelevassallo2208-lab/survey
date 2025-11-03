<?

global $survey_manageQuestions;


$surveyLabel = Database::ExecuteScalar("SELECT label FROM surveys.survey WHERE id = {$survey['id']}");

echo "<h2>Gestione questionario {$surveyLabel}</h2>";
?>

<div class='floatL'>
		<a href="<?=Language::GetAddress('survey/?_command=configSurvey')?>"><img src="<?=GetImageAddress('icons/settings_survey_100.png')?>" /><p>Configura Questionario</p></a>	
</div>

<div class='floatL'>
		<a href="<?=Language::GetAddress('survey/?_command=configSurvey')?>"><img src="<?=GetImageAddress('icons/associate_100.png')?>" /><p>Distribuisci</p></a>	
</div>
<div class='clear'></div>



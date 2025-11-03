<?php
global $surveyGym;



$surveyGym['manager']->selectFields = " surveys.survey_gym.* ";
$record = $surveyGym['manager']->readById($surveyGym['id']);
$surveyGym['sheet']->fromDbRecord($record);			
$surveyGym['sheet']->setAndCheck();


if ($surveyGym['sheet']->wasSubmitted()){
	$record = $surveyGym['sheet']->toDbRecord();		
	
}




if ($surveyGym['sheet']->wasSubmitted() && !$surveyGym['sheet']->hasErrors()) {
	$record = $surveyGym['sheet']->toDbRecord();		
	
	
	$surveyGym['manager']->updateById($record, $surveyGym['id']);		
	
	
	Header::JsRedirect(Self(false, '_msg=modified'));
	
	
}else{
	$surveyGym['buttons']['submit']->text = 'Salva';	
	$surveyGym['sheet']->command = 'modify';
	$surveyGym['sheet']->show();
}



?>

<a class="tolist" href="<?=Language::GetAddress($surveyGym['manager']->folder . '/')?>">Torna all'elenco</a>
<?php
global $surveyHeadset;



$surveyHeadset['manager']->selectFields = " surveys.survey_headset.* ";
$record = $surveyHeadset['manager']->readById($surveyHeadset['id']);
$surveyHeadset['sheet']->fromDbRecord($record);			
$surveyHeadset['sheet']->setAndCheck();


if ($surveyHeadset['sheet']->wasSubmitted()){
	$record = $surveyHeadset['sheet']->toDbRecord();		
	
}




if ($surveyHeadset['sheet']->wasSubmitted() && !$surveyHeadset['sheet']->hasErrors()) {
	$record = $surveyHeadset['sheet']->toDbRecord();		
	
	
	$surveyHeadset['manager']->updateById($record, $surveyHeadset['id']);		
	
	
	Header::JsRedirect(Self(false, '_msg=modified'));
	
	
}else{
	$surveyHeadset['buttons']['submit']->text = 'Salva';	
	$surveyHeadset['sheet']->command = 'modify';
	$surveyHeadset['sheet']->show();
}



?>

<a class="tolist" href="<?=Language::GetAddress($surveyHeadset['manager']->folder . '/')?>">Torna all'elenco</a>
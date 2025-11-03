<?php
global $surveyAquila;



$surveyAquila['manager']->selectFields = " surveys.survey_access_aquila.* ";
$record = $surveyAquila['manager']->readById($surveyAquila['id']);
$surveyAquila['sheet']->fromDbRecord($record);			
$surveyAquila['sheet']->setAndCheck();


if ($surveyAquila['sheet']->wasSubmitted()){
	$record = $surveyAquila['sheet']->toDbRecord();		
	
}




if ($surveyAquila['sheet']->wasSubmitted() && !$surveyAquila['sheet']->hasErrors()) {
	$record = $surveyAquila['sheet']->toDbRecord();		
	
	
	$surveyAquila['manager']->updateById($record, $surveyAquila['id']);		
	
	
	Header::JsRedirect(Self(false, '_msg=modified'));
	
	
}else{
	$surveyAquila['buttons']['submit']->text = 'Salva';	
	$surveyAquila['sheet']->command = 'modify';
	$surveyAquila['sheet']->show();
}



?>

<a class="tolist" href="<?=Language::GetAddress($surveyAquila['manager']->folder . '/')?>">Torna all'elenco</a>
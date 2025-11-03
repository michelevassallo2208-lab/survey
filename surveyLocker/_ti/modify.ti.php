<?php
global $surveyLocker;



$surveyLocker['manager']->selectFields = " surveys.survey_locker.* ";
$record = $surveyLocker['manager']->readById($surveyLocker['id']);
$surveyLocker['sheet']->fromDbRecord($record);			
$surveyLocker['sheet']->setAndCheck();


if ($surveyLocker['sheet']->wasSubmitted()){
	$record = $surveyLocker['sheet']->toDbRecord();		
	
}




if ($surveyLocker['sheet']->wasSubmitted() && !$surveyLocker['sheet']->hasErrors()) {
	$record = $surveyLocker['sheet']->toDbRecord();		
	
	
	$surveyLocker['manager']->updateById($record, $surveyLocker['id']);		
	
	
	Header::JsRedirect(Self(false, '_msg=modified'));
	
	
}else{
	$surveyLocker['buttons']['submit']->text = 'Salva';	
	$surveyLocker['sheet']->command = 'modify';
	$surveyLocker['sheet']->show();
}



?>

<a class="tolist" href="<?=Language::GetAddress($surveyLocker['manager']->folder . '/')?>">Torna all'elenco</a>
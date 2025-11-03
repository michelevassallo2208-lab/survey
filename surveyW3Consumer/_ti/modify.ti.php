<?php
global $surveyW3Consumer;



$surveyW3Consumer['manager']->selectFields = " surveys.surveyW3Consumer.* ";
$record = $surveyW3Consumer['manager']->readById($surveyW3Consumer['id']);
$surveyW3Consumer['sheet']->fromDbRecord($record);			
$surveyW3Consumer['sheet']->setAndCheck();


if ($surveyW3Consumer['sheet']->wasSubmitted()){
	$record = $surveyW3Consumer['sheet']->toDbRecord();		
	
}




if ($surveyW3Consumer['sheet']->wasSubmitted() && !$surveyW3Consumer['sheet']->hasErrors()) {
	$record = $surveyW3Consumer['sheet']->toDbRecord();		
	
	
	$surveyW3Consumer['manager']->updateById($record, $surveyW3Consumer['id']);		
	
	
	Header::JsRedirect(Self(false, '_msg=modified'));
	
	
}else{
	$surveyW3Consumer['buttons']['submit']->text = 'Salva';	
	$surveyW3Consumer['sheet']->command = 'modify';
	$surveyW3Consumer['sheet']->show();
}



?>

<a class="tolist" href="<?=Language::GetAddress($surveyW3Consumer['manager']->folder . '/')?>">Torna all'elenco</a>
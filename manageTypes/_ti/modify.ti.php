<?php
global $survey_manageTypes;

$record = $survey_manageTypes['manager']->readById($survey_manageTypes['id']);
$survey_manageTypes['sheet']->fromDbRecord($record);		

$survey_manageTypes['sheet']->fromDbRecord($record);			
$survey_manageTypes['sheet']->setAndCheck();

if ($survey_manageTypes['sheet']->wasSubmitted() ) {
	$record = $survey_manageTypes['sheet']->toDbRecord();	

	
}	

if ($survey_manageTypes['sheet']->wasSubmitted() && !$survey_manageTypes['sheet']->hasErrors()) {
	
	
	$record = $survey_manageTypes['sheet']->toDbRecord();
	
		
	$survey_manageTypes['manager']->updateById($record, $survey_manageTypes['id']);		
	
	Header::JsRedirect(Self(false, '_msg=modified'));
	
}else{
	$survey_manageTypes['buttons']['submit']->text = 'Salva';	
	$survey_manageTypes['sheet']->command = 'modify';
	$survey_manageTypes['sheet']->show();
}
?>

<a class="tolist" href="<?=Language::GetAddress($survey_manageTypes['manager']->folder . '/')?>">Torna all'elenco</a>
<?php
global $survey_manageCategories;

$record = $survey_manageCategories['manager']->readById($survey_manageCategories['id']);
$survey_manageCategories['sheet']->fromDbRecord($record);		

$survey_manageCategories['sheet']->fromDbRecord($record);			
$survey_manageCategories['sheet']->setAndCheck();

if ($survey_manageCategories['sheet']->wasSubmitted() ) {
	$record = $survey_manageCategories['sheet']->toDbRecord();	
		
	$marketCheck = Database::ExecuteRecord("SELECT job FROM centre_ccsud.users_market WHERE id IN( {$record['marketId']} )");
	
	if($marketCheck['job'] != $record['job']){
		$survey_manageCategories['sheet']->addSummaryError("Specificare la commessa corretta per il mercato selezionato.");
	}
	
}	

if ($survey_manageCategories['sheet']->wasSubmitted() && !$survey_manageCategories['sheet']->hasErrors()) {
	
	
	$record = $survey_manageCategories['sheet']->toDbRecord();
	
		
	$survey_manageCategories['manager']->updateById($record, $survey_manageCategories['id']);		
	
	Header::JsRedirect(Self(false, '_msg=modified'));
	
}else{
	$survey_manageCategories['buttons']['submit']->text = 'Salva';	
	$survey_manageCategories['sheet']->command = 'modify';
	$survey_manageCategories['sheet']->show();
}
?>

<a class="tolist" href="<?=Language::GetAddress($survey_manageCategories['manager']->folder . '/')?>">Torna all'elenco</a>
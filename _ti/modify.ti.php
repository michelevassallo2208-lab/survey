<?php
global $survey;

$survey['sheet']->setAndCheck();


if ($survey['sheet']->wasSubmitted() && !$survey['sheet']->hasErrors()) {
	
	
	$record = $survey['sheet']->toDbRecord();
	
		
	$survey['manager']->updateById($record, $survey['id']);		
	
	Header::JsRedirect(Self(false, '_msg=modified'));
	
}else{
	
	$record = $survey['manager']->readById($survey['id']);
	$survey['sheet']->fromDbRecord($record);
	
	$survey['buttons']['submit']->text = 'Salva';	
	$survey['sheet']->command = 'modify';
	$survey['sheet']->show();
}
?>

<a class="tolist" href="<?=Language::GetAddress($survey['manager']->folder . '/')?>">Torna all'elenco</a>
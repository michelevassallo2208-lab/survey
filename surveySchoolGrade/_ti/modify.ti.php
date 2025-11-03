<?php
global $surveySchoolGrade;



$surveySchoolGrade['manager']->selectFields = " surveys.surveySchoolGrade.* ";
$record = $surveySchoolGrade['manager']->readById($surveySchoolGrade['id']);
$surveySchoolGrade['sheet']->fromDbRecord($record);			
$surveySchoolGrade['sheet']->setAndCheck();


if ($surveySchoolGrade['sheet']->wasSubmitted()){
	$record = $surveySchoolGrade['sheet']->toDbRecord();		
	
}




if ($surveySchoolGrade['sheet']->wasSubmitted() && !$surveySchoolGrade['sheet']->hasErrors()) {
	$record = $surveySchoolGrade['sheet']->toDbRecord();		
	
	
	$surveySchoolGrade['manager']->updateById($record, $surveySchoolGrade['id']);		
	
	
	Header::JsRedirect(Self(false, '_msg=modified'));
	
	
}else{
	$surveySchoolGrade['buttons']['submit']->text = 'Salva';	
	$surveySchoolGrade['sheet']->command = 'modify';
	$surveySchoolGrade['sheet']->show();
}



?>

<a class="tolist" href="<?=Language::GetAddress($surveySchoolGrade['manager']->folder . '/')?>">Torna all'elenco</a>
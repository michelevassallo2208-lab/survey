<?php 

IncludeLib('datetimelib');
IncludeObject('filtersheet');
IncludeField('text');
IncludeButton('filter');
IncludeButton('resetfilter');

global $surveyHeadset, $filter;

$filter['sheet']->setAndCheck();
$filter['sheet']->show();

$surveyHeadset['manager']->selectFields = " surveys.survey_headset.* ";

if ($filter['sheet']->isFiltered()) {
    if ($filter['sheet']->getFilterValue('userId')>0) 				$surveyHeadset['manager']->addWhereClause("surveys.survey_headset.userId = ".$filter['sheet']->getFilterValue('userId')."");
	// if ($filter['sheet']->getFilterValue('tlId')!='') 				$surveyHeadset['manager']->addWhereClause("centre_ccsud.users.tlId = '".$filter['sheet']->getFilterValue('tlId')."'");
	
	if ($filter['sheet']->getFilterValue('firstQ')!='') 				$surveyHeadset['manager']->addWhereClause("surveys.survey_headset.firstQ = \"".$filter['sheet']->getFilterValue('firstQ')."\"");
	if ($filter['sheet']->getFilterValue('secondQ')!='') 				$surveyHeadset['manager']->addWhereClause("surveys.survey_headset.secondQ = \"".$filter['sheet']->getFilterValue('secondQ')."\"");

}
 
$surveyHeadset['manager']->addOuterJoin("centre_ccsud.users ON centre_ccsud.users.id = surveys.survey_headset.userId");
$surveyHeadset['manager']->addOrderClause("insertDt DESC");

$surveyHeadset['manager']->paging = new Paging();
$surveyHeadset['manager']->paging->textBefore = 'Pagine ';
$surveyHeadset['manager']->paging->size = 100;	
$surveyHeadset['manager']->paging->maxPages = 10;
$surveyHeadset['manager']->paging->total = $surveyHeadset['manager']->countAll(); 


$surveyHeadset['sheet']->sourceCursor = $surveyHeadset['manager']->readPaged();
$surveyHeadset['sheet']->cssClass = 'list1';

echo "<!--". $surveyHeadset['manager']->lastQuery ."-->";



$surveyHeadset['manager']->paging->show();


echo('<div class="numrecords">Numero di record: ' . $surveyHeadset['manager']->paging->total);

$surveyHeadset['sheet']->showAsList(); 
$surveyHeadset['manager']->paging->show();
?>	


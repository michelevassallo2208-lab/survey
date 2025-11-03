<?php 

IncludeLib('datetimelib');
IncludeObject('filtersheet');
IncludeField('text');
IncludeButton('filter');
IncludeButton('resetfilter');

global $surveyLocker, $filter;

$filter['sheet']->setAndCheck();
$filter['sheet']->show();

$surveyLocker['manager']->selectFields = " surveys.survey_locker.* ";

if ($filter['sheet']->isFiltered()) {
    if ($filter['sheet']->getFilterValue('userId')>0) 				$surveyLocker['manager']->addWhereClause("surveys.survey_locker.userId = ".$filter['sheet']->getFilterValue('userId')."");
	if ($filter['sheet']->getFilterValue('tlId')!='') 				$surveyLocker['manager']->addWhereClause("centre_ccsud.users.tlId = '".$filter['sheet']->getFilterValue('tlId')."'");
	
	if ($filter['sheet']->getFilterValue('firstQ')!='') 				$surveyLocker['manager']->addWhereClause("surveys.survey_locker.firstQ = \"".$filter['sheet']->getFilterValue('firstQ')."\"");
	if ($filter['sheet']->getFilterValue('secondQ')!='') 				$surveyLocker['manager']->addWhereClause("surveys.survey_locker.secondQ = \"".$filter['sheet']->getFilterValue('secondQ')."\"");
	if ($filter['sheet']->getFilterValue('thirdQ')!='') 				$surveyLocker['manager']->addWhereClause("surveys.survey_locker.thirdQ = \"".$filter['sheet']->getFilterValue('thirdQ')."\"");
}
 
$surveyLocker['manager']->addOuterJoin("centre_ccsud.users ON centre_ccsud.users.id = surveys.survey_locker.userId");
$surveyLocker['manager']->addOrderClause("insertDt DESC");

$surveyLocker['manager']->paging = new Paging();
$surveyLocker['manager']->paging->textBefore = 'Pagine ';
$surveyLocker['manager']->paging->size = 100;	
$surveyLocker['manager']->paging->maxPages = 10;
$surveyLocker['manager']->paging->total = $surveyLocker['manager']->countAll(); 


$surveyLocker['sheet']->sourceCursor = $surveyLocker['manager']->readPaged();
$surveyLocker['sheet']->cssClass = 'list1';

echo "<!--". $surveyLocker['manager']->lastQuery ."-->";



$surveyLocker['manager']->paging->show();


echo('<div class="numrecords">Numero di record: ' . $surveyLocker['manager']->paging->total);

$surveyLocker['sheet']->showAsList(); 
$surveyLocker['manager']->paging->show();
?>	


<?php 

IncludeLib('datetimelib');
IncludeObject('filtersheet');
IncludeField('text');
IncludeButton('filter');
IncludeButton('resetfilter');

global $surveyW3Consumer, $filter;

$filter['sheet']->setAndCheck();
$filter['sheet']->show();

$surveyW3Consumer['manager']->selectFields = " surveys.surveyW3Consumer.* ";

if ($filter['sheet']->isFiltered()) {
    if ($filter['sheet']->getFilterValue('userId')>0) 				$surveyW3Consumer['manager']->addWhereClause("surveys.surveyW3Consumer.userId = ".$filter['sheet']->getFilterValue('userId')."");
	if ($filter['sheet']->getFilterValue('tlId')!='') 				$surveyW3Consumer['manager']->addWhereClause("centre_ccsud.users.tlId = '".$filter['sheet']->getFilterValue('tlId')."'");
	

}
 
$surveyW3Consumer['manager']->addOuterJoin("centre_ccsud.users ON centre_ccsud.users.id = surveys.surveyW3Consumer.userId");
$surveyW3Consumer['manager']->addOrderClause("insertDt DESC");

$surveyW3Consumer['manager']->paging = new Paging();
$surveyW3Consumer['manager']->paging->textBefore = 'Pagine ';
$surveyW3Consumer['manager']->paging->size = 100;	
$surveyW3Consumer['manager']->paging->maxPages = 10;
$surveyW3Consumer['manager']->paging->total = $surveyW3Consumer['manager']->countAll(); 


$surveyW3Consumer['sheet']->sourceCursor = $surveyW3Consumer['manager']->readPaged();
$surveyW3Consumer['sheet']->cssClass = 'list1';

echo "<!--". $surveyW3Consumer['manager']->lastQuery ."-->";



$surveyW3Consumer['manager']->paging->show();


echo('<div class="numrecords">Numero di record: ' . $surveyW3Consumer['manager']->paging->total);

$surveyW3Consumer['sheet']->showAsList(); 
$surveyW3Consumer['manager']->paging->show();
?>	


<?php 

IncludeLib('datetimelib');
IncludeObject('filtersheet');
IncludeField('text');
IncludeButton('filter');
IncludeButton('resetfilter');

global $surveySchoolGrade, $filter;

$filter['sheet']->setAndCheck();
$filter['sheet']->show();

$surveySchoolGrade['manager']->selectFields = " surveys.surveySchoolGrade.* ";

if ($filter['sheet']->isFiltered()) {
    if ($filter['sheet']->getFilterValue('userId')>0) 				$surveySchoolGrade['manager']->addWhereClause("surveys.surveySchoolGrade.userId = ".$filter['sheet']->getFilterValue('userId')."");
	if ($filter['sheet']->getFilterValue('tlId')!='') 				$surveySchoolGrade['manager']->addWhereClause("centre_ccsud.users.tlId = '".$filter['sheet']->getFilterValue('tlId')."'");
	

}
 
$surveySchoolGrade['manager']->addOuterJoin("centre_ccsud.users ON centre_ccsud.users.id = surveys.surveySchoolGrade.userId");
$surveySchoolGrade['manager']->addOrderClause("insertDt DESC");

$surveySchoolGrade['manager']->paging = new Paging();
$surveySchoolGrade['manager']->paging->textBefore = 'Pagine ';
$surveySchoolGrade['manager']->paging->size = 100;	
$surveySchoolGrade['manager']->paging->maxPages = 10;
$surveySchoolGrade['manager']->paging->total = $surveySchoolGrade['manager']->countAll(); 


$surveySchoolGrade['sheet']->sourceCursor = $surveySchoolGrade['manager']->readPaged();
$surveySchoolGrade['sheet']->cssClass = 'list1';

echo "<!--". $surveySchoolGrade['manager']->lastQuery ."-->";



$surveySchoolGrade['manager']->paging->show();


echo('<div class="numrecords">Numero di record: ' . $surveySchoolGrade['manager']->paging->total);

$surveySchoolGrade['sheet']->showAsList(); 
$surveySchoolGrade['manager']->paging->show();
?>	


<?php 

IncludeLib('datetimelib');
IncludeObject('filtersheet');
IncludeField('text');
IncludeButton('filter');
IncludeButton('resetfilter');

global $surveyGym, $filter;

$filter['sheet']->setAndCheck();
$filter['sheet']->show();

$surveyGym['manager']->selectFields = " surveys.survey_gym.* ";

if ($filter['sheet']->isFiltered()) {
    if ($filter['sheet']->getFilterValue('userId')>0) 				$surveyGym['manager']->addWhereClause("surveys.survey_gym.userId = ".$filter['sheet']->getFilterValue('userId')."");
	if ($filter['sheet']->getFilterValue('tlId')!='') 				$surveyGym['manager']->addWhereClause("centre_ccsud.users.tlId = '".$filter['sheet']->getFilterValue('tlId')."'");
	
	if ($filter['sheet']->getFilterValue('firstQ')!='') 				$surveyGym['manager']->addWhereClause("surveys.survey_gym.firstQ = \"".$filter['sheet']->getFilterValue('firstQ')."\"");
	if ($filter['sheet']->getFilterValue('secondQ')!='') 				$surveyGym['manager']->addWhereClause("surveys.survey_gym.secondQ = \"".$filter['sheet']->getFilterValue('secondQ')."\"");

}
 
$surveyGym['manager']->addOuterJoin("centre_ccsud.users ON centre_ccsud.users.id = surveys.survey_gym.userId");
$surveyGym['manager']->addOrderClause("insertDt DESC");

$surveyGym['manager']->paging = new Paging();
$surveyGym['manager']->paging->textBefore = 'Pagine ';
$surveyGym['manager']->paging->size = 100;	
$surveyGym['manager']->paging->maxPages = 10;
$surveyGym['manager']->paging->total = $surveyGym['manager']->countAll(); 


$surveyGym['sheet']->sourceCursor = $surveyGym['manager']->readPaged();
$surveyGym['sheet']->cssClass = 'list1';

echo "<!--". $surveyGym['manager']->lastQuery ."-->";



$surveyGym['manager']->paging->show();


echo('<div class="numrecords">Numero di record: ' . $surveyGym['manager']->paging->total);

$surveyGym['sheet']->showAsList(); 
$surveyGym['manager']->paging->show();
?>	


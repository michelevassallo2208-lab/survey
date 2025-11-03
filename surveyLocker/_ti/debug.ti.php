<?php 

IncludeLib('datetimelib');
IncludeObject('filtersheet');
IncludeField('text');
IncludeButton('filter');
IncludeButton('resetfilter');

global $surveyGym, $filter;

$filter['sheet']->setAndCheck();
$filter['sheet']->show();

$surveyGym['manager']->selectFields = " surveys.survey_access_aquila.* ";

if ($filter['sheet']->isFiltered()) {
    if ($filter['sheet']->getFilterValue('userId')>0) 				$surveyGym['manager']->addWhereClause("surveys.survey_access_aquila.userId = ".$filter['sheet']->getFilterValue('userId')."");
	if ($filter['sheet']->getFilterValue('tlId')!='') 				$surveyGym['manager']->addWhereClause("centre_ccsud.users.tlId = '".$filter['sheet']->getFilterValue('tlId')."'");
	
	if ($filter['sheet']->getFilterValue('login')!='') 				$surveyGym['manager']->addWhereClause("surveys.survey_access_aquila.login = '".$filter['sheet']->getFilterValue('login')."'");
	if ($filter['sheet']->getFilterValue('withU')!='') 				$surveyGym['manager']->addWhereClause("surveys.survey_access_aquila.withU = '".$filter['sheet']->getFilterValue('withU')."'");
	if ($filter['sheet']->getFilterValue('pplSoft')!='') 			$surveyGym['manager']->addWhereClause("surveys.survey_access_aquila.pplSoft = '".$filter['sheet']->getFilterValue('pplSoft')."'");
	if ($filter['sheet']->getFilterValue('uadOmRimb')!='') 			$surveyGym['manager']->addWhereClause("surveys.survey_access_aquila.uadOmRimb = '".$filter['sheet']->getFilterValue('uadOmRimb')."'");
	if ($filter['sheet']->getFilterValue('dss')!='') 				$surveyGym['manager']->addWhereClause("DATE(surveys.survey_access_aquila.dss) >= '".$filter['sheet']->getFilterValue('dss')."'");
	if ($filter['sheet']->getFilterValue('dokCrm')!='') 			$surveyGym['manager']->addWhereClause("DATE(surveys.survey_access_aquila.dokCrm) <= '".$filter['sheet']->getFilterValue('dokCrm')."'");
	if ($filter['sheet']->getFilterValue('irma')!='') 				$surveyGym['manager']->addWhereClause("surveys.survey_access_aquila.irma = '".$filter['sheet']->getFilterValue('irma')."'");
	if ($filter['sheet']->getFilterValue('dbAuto')!='') 			$surveyGym['manager']->addWhereClause("surveys.survey_access_aquila.dbAuto = '".$filter['sheet']->getFilterValue('dbAuto')."'");
	if ($filter['sheet']->getFilterValue('mPay')!='') 				$surveyGym['manager']->addWhereClause("surveys.survey_access_aquila.mPay = '".$filter['sheet']->getFilterValue('mPay')."'");
	if ($filter['sheet']->getFilterValue('oneShot')!='') 			$surveyGym['manager']->addWhereClause("surveys.survey_access_aquila.oneShot = '".$filter['sheet']->getFilterValue('oneShot')."'");
	if ($filter['sheet']->getFilterValue('ricaricaEasy')!='') 		$surveyGym['manager']->addWhereClause("surveys.survey_access_aquila.ricaricaEasy = '".$filter['sheet']->getFilterValue('ricaricaEasy')."'");
	if ($filter['sheet']->getFilterValue('thd')!='') 				$surveyGym['manager']->addWhereClause("surveys.survey_access_aquila.thd = '".$filter['sheet']->getFilterValue('thd')."'");
	if ($filter['sheet']->getFilterValue('cora')!='') 				$surveyGym['manager']->addWhereClause("surveys.survey_access_aquila.cora = '".$filter['sheet']->getFilterValue('cora')."'");
	if ($filter['sheet']->getFilterValue('threeSat')!='') 			$surveyGym['manager']->addWhereClause("surveys.survey_access_aquila.threeSat = '".$filter['sheet']->getFilterValue('threeSat')."'");
	if ($filter['sheet']->getFilterValue('ccmMail')!='') 			$surveyGym['manager']->addWhereClause("surveys.survey_access_aquila.ccmMail = '".$filter['sheet']->getFilterValue('ccmMail')."'");
	if ($filter['sheet']->getFilterValue('gc3')!='') 				$surveyGym['manager']->addWhereClause("surveys.survey_access_aquila.gc3 = '".$filter['sheet']->getFilterValue('gc3')."'");
	if ($filter['sheet']->getFilterValue('wellDone')!='') 			$surveyGym['manager']->addWhereClause("surveys.survey_access_aquila.wellDone = '".$filter['sheet']->getFilterValue('wellDone')."'");
	if ($filter['sheet']->getFilterValue('easyCimOutbound')!='') 	$surveyGym['manager']->addWhereClause("surveys.survey_access_aquila.easyCimOutbound = '".$filter['sheet']->getFilterValue('easyCimOutbound')."'");
	if ($filter['sheet']->getFilterValue('genesysBar')!='') 		$surveyGym['manager']->addWhereClause("surveys.survey_access_aquila.genesysBar = '".$filter['sheet']->getFilterValue('genesysBar')."'");
}
print_r($_SESSION);
$surveyGym['manager']->addOuterJoin("centre_ccsud.users ON centre_ccsud.users.id = surveys.survey_access_aquila.userId");

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


<?php 

IncludeLib('datetimelib');
IncludeObject('filtersheet');
IncludeField('text');
IncludeButton('filter');
IncludeButton('resetfilter');

global $surveyAquila, $filter;

$filter['sheet']->setAndCheck();
$filter['sheet']->show();

$surveyAquila['manager']->selectFields = " surveys.survey_access_aquila.* ";

if ($filter['sheet']->isFiltered()) {
    if ($filter['sheet']->getFilterValue('userId')>0) 				$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.userId = ".$filter['sheet']->getFilterValue('userId')."");
	if ($filter['sheet']->getFilterValue('tlId')!='') 				$surveyAquila['manager']->addWhereClause("centre_ccsud.users.tlId = '".$filter['sheet']->getFilterValue('tlId')."'");
	
	if ($filter['sheet']->getFilterValue('login')!='') 				$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.login = '".$filter['sheet']->getFilterValue('login')."'");
	if ($filter['sheet']->getFilterValue('withU')!='') 				$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.withU = '".$filter['sheet']->getFilterValue('withU')."'");
	if ($filter['sheet']->getFilterValue('pplSoft')!='') 			$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.pplSoft = '".$filter['sheet']->getFilterValue('pplSoft')."'");
	if ($filter['sheet']->getFilterValue('uadOmRimb')!='') 			$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.uadOmRimb = '".$filter['sheet']->getFilterValue('uadOmRimb')."'");
	if ($filter['sheet']->getFilterValue('dss')!='') 				$surveyAquila['manager']->addWhereClause("DATE(surveys.survey_access_aquila.dss) >= '".$filter['sheet']->getFilterValue('dss')."'");
	if ($filter['sheet']->getFilterValue('dokCrm')!='') 			$surveyAquila['manager']->addWhereClause("DATE(surveys.survey_access_aquila.dokCrm) <= '".$filter['sheet']->getFilterValue('dokCrm')."'");
	if ($filter['sheet']->getFilterValue('irma')!='') 				$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.irma = '".$filter['sheet']->getFilterValue('irma')."'");
	if ($filter['sheet']->getFilterValue('dbAuto')!='') 			$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.dbAuto = '".$filter['sheet']->getFilterValue('dbAuto')."'");
	if ($filter['sheet']->getFilterValue('mPay')!='') 				$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.mPay = '".$filter['sheet']->getFilterValue('mPay')."'");
	if ($filter['sheet']->getFilterValue('oneShot')!='') 			$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.oneShot = '".$filter['sheet']->getFilterValue('oneShot')."'");
	if ($filter['sheet']->getFilterValue('ricaricaEasy')!='') 		$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.ricaricaEasy = '".$filter['sheet']->getFilterValue('ricaricaEasy')."'");
	if ($filter['sheet']->getFilterValue('thd')!='') 				$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.thd = '".$filter['sheet']->getFilterValue('thd')."'");
	if ($filter['sheet']->getFilterValue('cora')!='') 				$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.cora = '".$filter['sheet']->getFilterValue('cora')."'");
	if ($filter['sheet']->getFilterValue('threeSat')!='') 			$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.threeSat = '".$filter['sheet']->getFilterValue('threeSat')."'");
	if ($filter['sheet']->getFilterValue('ccmMail')!='') 			$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.ccmMail = '".$filter['sheet']->getFilterValue('ccmMail')."'");
	if ($filter['sheet']->getFilterValue('gc3')!='') 				$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.gc3 = '".$filter['sheet']->getFilterValue('gc3')."'");
	if ($filter['sheet']->getFilterValue('wellDone')!='') 			$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.wellDone = '".$filter['sheet']->getFilterValue('wellDone')."'");
	if ($filter['sheet']->getFilterValue('easyCimOutbound')!='') 	$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.easyCimOutbound = '".$filter['sheet']->getFilterValue('easyCimOutbound')."'");
	if ($filter['sheet']->getFilterValue('genesysBar')!='') 		$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.genesysBar = '".$filter['sheet']->getFilterValue('genesysBar')."'");
}
 
$surveyAquila['manager']->addOuterJoin("centre_ccsud.users ON centre_ccsud.users.id = surveys.survey_access_aquila.userId");
$surveyAquila['manager']->addOrderClause("insertDt DESC");

$surveyAquila['manager']->paging = new Paging();
$surveyAquila['manager']->paging->textBefore = 'Pagine ';
$surveyAquila['manager']->paging->size = 100;	
$surveyAquila['manager']->paging->maxPages = 10;
$surveyAquila['manager']->paging->total = $surveyAquila['manager']->countAll(); 


$surveyAquila['sheet']->sourceCursor = $surveyAquila['manager']->readPaged();
$surveyAquila['sheet']->cssClass = 'list1';

echo "<!--". $surveyAquila['manager']->lastQuery ."-->";



$surveyAquila['manager']->paging->show();


echo('<div class="numrecords">Numero di record: ' . $surveyAquila['manager']->paging->total);

$surveyAquila['sheet']->showAsList(); 
$surveyAquila['manager']->paging->show();
?>	


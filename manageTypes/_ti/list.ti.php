<?php 
//ini_set('error_reporting', E_ALL);
//ini_set("display_errors", 1);
IncludeLib('datetimelib');
IncludeObject('filtersheet');
IncludeField('text');
IncludeButton('filter');
IncludeButton('resetfilter');

global $survey_manageTypes, $filter;

if (!Session::UserHasOneOfProfilesIn('1,2,6,32')){
	echo "<h2>Tool non accessibile dal tuo profilo.</h2>";
	die();
}

$location = Session::GetUser('location');
$locationMarketClause="";
if($location == 'aquila'){
	$locationMarketClause=" AND FIND_IN_SET('{$location}',locations)";			
}



$filter['sheet']->setAndCheck();
$filter['sheet']->show();


if ($filter['sheet']->isFiltered()) {
	if ($filter['sheet']->getFilterValue('label')!='') $survey_manageTypes['manager']->addWhereClause("surveys.survey_types.label LIKE '%".$filter['sheet']->getFilterValue('label')."%'");
	
	if ($filter['sheet']->getFilterValue('viewable')!='') $survey_manageTypes['manager']->addWhereClause("surveys.survey_types.viewable = ".$filter['sheet']->getFilterValue('viewable'));

	

} 


$q = "SELECT * FROM " . $survey_manageTypes['manager']->getTable() .$survey_manageTypes['manager']->getJoin(). $survey_manageTypes['manager']->getWhere();


$survey_manageTypes['manager']->paging = new Paging();
$survey_manageTypes['manager']->paging->textBefore = 'Pagine ';
$survey_manageTypes['manager']->paging->size = 100;	
$survey_manageTypes['manager']->paging->maxPages = 10;
$survey_manageTypes['sheet']->sourceCursor = Database::ExecuteSelect($q);
$survey_manageTypes['manager']->paging->total = Database::NumRows($survey_manageTypes['sheet']->sourceCursor);


$survey_manageTypes['sheet']->cssClass = 'list1';

$survey_manageTypes['manager']->paging->show();



echo('<div class="numrecords">Numero di record: ' . $survey_manageTypes['manager']->paging->total . " ");

$survey_manageTypes['sheet']->showAsList(); 
$survey_manageTypes['manager']->paging->show();
?>	

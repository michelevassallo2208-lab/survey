

<?php 
//ini_set('error_reporting', E_ALL);
//ini_set("display_errors", 1);
IncludeLib('datetimelib');
IncludeObject('filtersheet');
IncludeField('text');
IncludeButton('filter');
IncludeButton('resetfilter');

global $survey_manageCategories, $filter;

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
	if ($filter['sheet']->getFilterValue('label')!='') $survey_manageCategories['manager']->addWhereClause("surveys.survey_categories.label LIKE '%".$filter['sheet']->getFilterValue('label')."%'");

	
	if ($filter['sheet']->getFilterValue('job')!='') $survey_manageCategories['manager']->addWhereClause("surveys.survey_categories.job = '".$filter['sheet']->getFilterValue('job')."'");
	
	if ($filter['sheet']->getFilterValue('marketId')>0) $survey_manageCategories['manager']->addWhereClause("surveys.survey_categories.marketId IN( '".$filter['sheet']->getFilterValue('marketId')."')");

} 

if($location == 'aquila'){
	$enabled_market_ids = Database::ExecuteCsv("SELECT DISTINCT(users_market.id) FROM surveys.survey_categories INNER JOIN centre_ccsud.users_market ON users_market.id = survey_categories.marketId WHERE 1 {$locationMarketClause}");
	$survey_manageCategories['manager']->addWhereClause("surveys.survey_categories.marketId IN ({$enabled_market_ids})");	
}
$q = "SELECT * FROM " . $survey_manageCategories['manager']->getTable() .$survey_manageCategories['manager']->getJoin(). $survey_manageCategories['manager']->getWhere();
//echo $q;

$survey_manageCategories['manager']->paging = new Paging();
$survey_manageCategories['manager']->paging->textBefore = 'Pagine ';
$survey_manageCategories['manager']->paging->size = 100;	
$survey_manageCategories['manager']->paging->maxPages = 10;
$survey_manageCategories['sheet']->sourceCursor = Database::ExecuteSelect($q);
$survey_manageCategories['manager']->paging->total = Database::NumRows($survey_manageCategories['sheet']->sourceCursor);


$survey_manageCategories['sheet']->cssClass = 'list1';

$survey_manageCategories['manager']->paging->show();



echo('<div class="numrecords">Numero di record: ' . $survey_manageCategories['manager']->paging->total . " ");

$survey_manageCategories['sheet']->showAsList(); 
$survey_manageCategories['manager']->paging->show();
?>	



<?php 
//ini_set('error_reporting', E_ALL);
//ini_set("display_errors", 1);
IncludeLib('datetimelib');
IncludeObject('filtersheet');
IncludeField('text');
IncludeButton('filter');
IncludeButton('resetfilter');

global $survey_manageQuestions, $filter;

if (!Session::UserHasOneOfProfilesIn('1,2,6,32')){
	echo "<h2>Tool non accessibile dal tuo profilo.</h2>";
	die();
}
$location = Session::GetUser('location');
if($location == 'aquila'){
	$locationMarketClause=" AND FIND_IN_SET('{$location}',locations)";			
}

$filter['sheet']->setAndCheck();
$filter['sheet']->show();


if ($filter['sheet']->isFiltered()) {
	if ($filter['sheet']->getFilterValue('label')!='') $survey_manageQuestions['manager']->addWhereClause("surveys.survey_questions.label LIKE '%".$filter['sheet']->getFilterValue('label')."%'");

	
	if ($filter['sheet']->getFilterValue('job')!='') $survey_manageQuestions['manager']->addWhereClause("surveys.survey_categories.job = '".$filter['sheet']->getFilterValue('job')."'");
	
	if ($filter['sheet']->getFilterValue('marketId')>0) $survey_manageQuestions['manager']->addWhereClause("surveys.survey_categories.marketId = '".$filter['sheet']->getFilterValue('marketId')."'");
	if ($filter['sheet']->getFilterValue('categoryId')>0) $survey_manageQuestions['manager']->addWhereClause("surveys.survey_questions.categoryId = '".$filter['sheet']->getFilterValue('categoryId')."'");
	if ($filter['sheet']->getFilterValue('enabled')!='') {		
		if($filter['sheet']->getFilterValue('enabled')=='Si'){
			$survey_manageQuestions['manager']->addWhereClause(" surveys.survey_questions.enabled = 'true'");
		}elseif($filter['sheet']->getFilterValue('enabled')=='No'){
			$survey_manageQuestions['manager']->addWhereClause(" surveys.survey_questions.enabled = 'false'");
		}		
	}	
} 

if($location == 'aquila'){
	$enabled_market_ids = Database::ExecuteCsv("SELECT DISTINCT(users_market.id) FROM surveys.survey_categories INNER JOIN centre_ccsud.users_market ON users_market.id = survey_categories.marketId WHERE 1 {$locationMarketClause}");
	$survey_manageQuestions['manager']->addWhereClause("surveys.survey_categories.marketId IN ({$enabled_market_ids})");	
}


$survey_manageQuestions['manager']->addOuterJoin("surveys.survey_categories ON surveys.survey_categories.id = surveys.survey_questions.categoryId");


$q = "SELECT *,survey_questions.label AS label, survey_questions.id AS id, 
survey_questions.enabled AS enabled
FROM " . $survey_manageQuestions['manager']->getTable() .$survey_manageQuestions['manager']->getJoin(). $survey_manageQuestions['manager']->getWhere() ;
//echo $q;

$survey_manageQuestions['manager']->paging = new Paging();
$survey_manageQuestions['manager']->paging->textBefore = 'Pagine ';
$survey_manageQuestions['manager']->paging->size = 100;	
$survey_manageQuestions['manager']->paging->maxPages = 10;
$survey_manageQuestions['sheet']->sourceCursor = Database::ExecuteSelect($q);
$survey_manageQuestions['manager']->paging->total = Database::NumRows($survey_manageQuestions['sheet']->sourceCursor);


$survey_manageQuestions['sheet']->cssClass = 'list1';

$survey_manageQuestions['manager']->paging->show();



echo('<div class="numrecords">Numero di record: ' . $survey_manageQuestions['manager']->paging->total . " ");

$survey_manageQuestions['sheet']->showAsList(); 
$survey_manageQuestions['manager']->paging->show();
?>	

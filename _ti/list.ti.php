

<?php 

IncludeLib('datetimelib');
IncludeObject('filtersheet');
IncludeField('text');
IncludeButton('filter');
IncludeButton('resetfilter');

global $survey, $filter;

if (!Session::UserHasOneOfProfilesIn('1,4,6,32')){
	echo "<h2>Tool non accessibile dal tuo profilo.</h2>";
	die();
}


$filter['sheet']->setAndCheck();
$filter['sheet']->show();

$location = Session::GetUser('location');

$style = 'modernH3G';
if ($filter['sheet']->isFiltered()) {
	if ($filter['sheet']->getFilterValue('creationDtFrom')!='') $survey['manager']->addWhereClause("DATE(surveys.survey.creationDt) >= '".$filter['sheet']->getFilterValue('creationDtFrom')."'");
	if ($filter['sheet']->getFilterValue('creationDtTo')!='') $survey['manager']->addWhereClause("DATE(surveys.survey.creationDt) <= '".$filter['sheet']->getFilterValue('creationDtTo')."'");
	
	if ($filter['sheet']->getFilterValue('startDateFrom')!='') $survey['manager']->addWhereClause("DATE(surveys.survey.startDate) >= '".$filter['sheet']->getFilterValue('startDateFrom')."'");
	if ($filter['sheet']->getFilterValue('endDateTo')!='') $survey['manager']->addWhereClause("DATE(surveys.survey.startDate) <= '".$filter['sheet']->getFilterValue('endDateTo')."'");
	
	if ($filter['sheet']->getFilterValue('job')!='') $survey['manager']->addWhereClause("surveys.survey.job = '".$filter['sheet']->getFilterValue('job')."'");
	if ($filter['sheet']->getFilterValue('marketId')>0) $survey['manager']->addWhereClause("surveys.survey.marketId = ".$filter['sheet']->getFilterValue('marketId'));
	if ($filter['sheet']->getFilterValue('typeId')>0) $survey['manager']->addWhereClause("surveys.survey.typeId = ".$filter['sheet']->getFilterValue('typeId'));
	if ($filter['sheet']->getFilterValue('id')>0) $survey['manager']->addWhereClause("surveys.survey.id = ".$filter['sheet']->getFilterValue('id'));
	if ($filter['sheet']->getFilterValue('location')!='') $survey['manager']->addWhereClause("surveys.survey.location = '".$filter['sheet']->getFilterValue('location')."'");
	
} 

$survey['manager']->addOrderClause("surveys.survey.creationDt desc");

if(Session::GetUser('location') != 'battipaglia'){
	$survey['manager']->addWhereClause("surveys.survey.location = '{$location}'");
	
	$style = ($location == 'roma' || $location == 'settingiano') ? 'modernPoste' : 'modernH3G';
	

}


//$survey['manager']->addJoin("surveys.survey ON survey.id = survey_outcome_ca.surveyId");

$q = "SELECT * FROM " . $survey['manager']->getTable() .$survey['manager']->getJoin(). $survey['manager']->getWhere();
// echo $q;

$survey['manager']->paging = new Paging();
$survey['manager']->paging->textBefore = 'Pagine ';
$survey['manager']->paging->size = 100;	
$survey['manager']->paging->maxPages = 10;
$survey['sheet']->sourceCursor = $survey['manager']->readPaged();
$survey['manager']->paging->total = Database::NumRows($survey['sheet']->sourceCursor);


$survey['sheet']->cssClass =$style;

$survey['manager']->paging->show();



echo('<div class="numrecords">Numero di record: ' . $survey['manager']->paging->total . " ");

$survey['sheet']->showAsList(); 
$survey['manager']->paging->show();

?>	

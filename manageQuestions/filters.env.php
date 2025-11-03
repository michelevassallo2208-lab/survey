<?php

IncludeLib('datetimelib');
IncludeObject('filtersheet');
IncludeField('text');
IncludeButton('filter');
IncludeButton('resetfilter');

global $filter;


$location = Session::GetUser('location');
$locationMarketClause="";
if($location == 'aquila'){
	$locationMarketClause=" AND FIND_IN_SET('{$location}',locations)";			
}


$filter['sheet'] = new FilterSheet('fs_survey_manageCat');
$filter['sheet']->columns = 4;
$filter['sheet']->title = 'Cerca';
$filter['sheet']->buttonsPosition = 'right';
$filter['sheet']->cssClass = 'fFilter'; 

if (Session::UserHasOneOfProfilesIn('1,2,6') || (@$filter['command']=='list') || (@$filter['command']=='')) {
	
	$filter['fields']['label'] = new TextField('label');
	$filter['fields']['label']->label = 'Testo Domanda';
	$filter['sheet']->addField($filter['fields']['label']);
	
	$filter['fields']['job'] = new DropDownField('job');
	$filter['fields']['job']->label = 'Commessa';
	$filter['fields']['job']->options = 'H3G;Poste;Sogei';
	if($location == 'aquila'){
		$filter['fields']['job']->options = 'H3G';
	}
	$filter['fields']['job']->usesNoSelection = true;
	$filter['sheet']->addField($filter['fields']['job']);
	
	$filter['fields']['marketId'] = new DropDownField('marketId');
	$filter['fields']['marketId']->label = 'Mercato';
	$filter['fields']['marketId']->sourceSelect = "id, label AS _label";
	$filter['fields']['marketId']->sourceTable = 'centre_ccsud.users_market';
	$filter['fields']['marketId']->sourceKey = 'id';
	$filter['fields']['marketId']->sourceLabel = '_label';
	$filter['fields']['marketId']->sourceQueryTail ="{$locationMarketClause} AND enabled='true' ORDER BY _label";
	$filter['fields']['marketId']->usesNoSelection = true;
	$filter['sheet']->addField($filter['fields']['marketId']);
	
	
	if($location == 'aquila'){
		$enabled_market_ids = Database::ExecuteCsv("SELECT DISTINCT(users_market.id) FROM surveys.survey_categories INNER JOIN centre_ccsud.users_market ON users_market.id = survey_categories.marketId WHERE 1 {$locationMarketClause}");
		
	}
	
	
	$filter['fields']['categoryId'] = new DropDownField('categoryId');
	$filter['fields']['categoryId']->label = 'Categoria';
	$filter['fields']['categoryId']->sourceSelect = "id, label AS _label";
	$filter['fields']['categoryId']->sourceTable = 'surveys.survey_categories';
	$filter['fields']['categoryId']->sourceKey = 'id';
	$filter['fields']['categoryId']->sourceLabel = '_label';
	$filter['fields']['categoryId']->sourceQueryTail ="AND enabled='true' ORDER BY _label";
	if($location == 'aquila') {
		$filter['fields']['categoryId']->sourceQueryTail ="AND marketId IN ({$enabled_market_ids}) AND enabled='true' ORDER BY _label";
	}
	$filter['fields']['categoryId']->usesNoSelection = true;
	$filter['sheet']->addField($filter['fields']['categoryId']);
	
	$filter['fields']['enabled'] = new DropDownField('enabled');
	$filter['fields']['enabled']->label = 'Attiva';	
	$filter['fields']['enabled']->usesNoSelection = true;		
	$filter['fields']['enabled']->options = 'Si;No';
	$filter['sheet']->addField($filter['fields']['enabled']);
	
	
}

/* $filter['fields']['activationId'] = new DropDownField('activationId');
$filter['fields']['activationId']->label = 'Attivit&agrave Subentro';
$filter['fields']['activationId']->sourceSelect = "id, label AS _label ";
$filter['fields']['activationId']->sourceTable = 'replaceActivity';
$filter['fields']['activationId']->sourceKey = 'id';
$filter['fields']['activationId']->sourceLabel = '_label';
$filter['fields']['activationId']->sourceQueryTail =" ORDER BY _label";
$filter['fields']['activationId']->usesNoSelection = true;
$filter['sheet']->addField($filter['fields']['activationId']); */


$filter['buttons']['submit'] = new SubmitButton('submit');
$filter['buttons']['submit']->text = 'Filtra';
$filter['sheet']->addSubmitButton($filter['buttons']['submit']);

$filter['buttons']['reset'] = new ResetFilterButton('reset');
$filter['buttons']['reset']->text = 'Elimina filtro';
$filter['sheet']->addSubmitButton($filter['buttons']['reset']);

$filter['sheet']->setAndCheck();

?>

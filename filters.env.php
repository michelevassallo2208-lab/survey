<?php

IncludeLib('datetimelib');
IncludeObject('filtersheet');
IncludeField('text');
IncludeButton('filter');
IncludeButton('resetfilter');

global $filter;



$listFilter = '';
if (!Session::UserHasOneOfProfilesIn('1,2,6'))
	$listFilter = " AND optEnabled = 'true'"; 

$filter['sheet'] = new FilterSheet('fs_survey');
$filter['sheet']->columns = 4;
$filter['sheet']->title = 'Cerca';
$filter['sheet']->buttonsPosition = 'right';
$filter['sheet']->cssClass = 'fFilter'; 

$location = Session::GetUser('location');
$locationMarketClause="";
$locationSurveyClause="";
if($location == 'aquila' || $location == 'roma' || $location == 'settingiano' || $location == 'sulmona'){
	$locationMarketClause=" AND FIND_IN_SET('{$location}',locations)";	
	$locationSurveyClause=" AND location = '{$location}'";		
}

if (Session::UserHasOneOfProfilesIn('1,2,6') || (@$filter['command']=='list') || (@$filter['command']=='')) {
	$filter['fields']['creationDtFrom'] = new DateField('creationDtFrom');
	$filter['fields']['creationDtFrom']->label = 'Data creazione da';	
	$filter['sheet']->addField($filter['fields']['creationDtFrom']);

	$filter['fields']['creationDtTo'] = new DateField('creationDtTo');
	$filter['fields']['creationDtTo']->label = 'a';
	$filter['sheet']->addField($filter['fields']['creationDtTo']);
	
	
	$filter['fields']['startDateFrom'] = new DateField('startDateFrom');
	$filter['fields']['startDateFrom']->label = 'Data inizio da';	
	$filter['sheet']->addField($filter['fields']['startDateFrom']);

	$filter['fields']['endDateTo'] = new DateField('endDateTo');
	$filter['fields']['endDateTo']->label = 'a';
	$filter['sheet']->addField($filter['fields']['endDateTo']);

	$filter['fields']['id'] = new DropDownField('id');
	$filter['fields']['id']->label = 'Questionario';
	$filter['fields']['id']->sourceSelect = "id, label AS _label";
	$filter['fields']['id']->sourceTable = 'surveys.survey';
	$filter['fields']['id']->sourceKey = 'id';
	$filter['fields']['id']->sourceLabel = '_label';
	$filter['fields']['id']->sourceQueryTail ="{$locationSurveyClause} AND enabled='true' ORDER BY _label";
	$filter['fields']['id']->usesNoSelection = true;
	$filter['sheet']->addField($filter['fields']['id']);
	
	$filter['fields']['typeId'] = new DropDownField('typeId');
	$filter['fields']['typeId']->label = 'Tipologia questionario';
	$filter['fields']['typeId']->sourceSelect = "id, label";
	$filter['fields']['typeId']->sourceTable = 'surveys.survey_types';
	$filter['fields']['typeId']->sourceKey = 'id';
	$filter['fields']['typeId']->sourceLabel = 'label';
	$filter['fields']['typeId']->sourceQueryTail =" AND viewable=1";
	$filter['fields']['typeId']->usesNoSelection = true;
	// $filter['fields']['typeId']->addFlag(Field::NOT_EMPTY());
	$filter['sheet']->addField($filter['fields']['typeId']);
	
	
	$filter['fields']['job'] = new DropDownField('job');
	$filter['fields']['job']->label = 'Commessa';
	$filter['fields']['job']->options = 'H3G;Poste;Sogei';
	if($location == 'aquila'){
		$filter['fields']['job']->options = 'H3G';
	}else if($location == 'settingiano'){
		$filter['fields']['job']->options = 'Poste';
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
	
	
	$filter['fields']['location'] = new DropDownField('location');
	$filter['fields']['location']->label = 'Location';
	$filter['fields']['location']->options = "battipaglia:Battipaglia;roma:Roma;aquila:L'Aquila;settingiano:Settingiano;sulmona:Sulmona";
	$filter['fields']['location']->usesNoSelection = true;
	if(Session::GetUser('location') == 'aquila'){
		$filter['fields']['location']->options = "aquila:L'Aquila";
		$filter['fields']['location']->value = 'aquila';
		$filter['fields']['location']->usesNoSelection = false;			
	} else 	if(Session::GetUser('location') == 'roma'){
		$filter['fields']['location']->options = "roma:Roma";
		$filter['fields']['location']->value = 'roma';
		$filter['fields']['location']->usesNoSelection = false;			
	} else 	if(Session::GetUser('location') == 'settingiano'){
		$filter['fields']['location']->options = "settingiano:Settingiano";
		$filter['fields']['location']->value = 'settingiano';
		$filter['fields']['location']->usesNoSelection = false;			
	}	else 	if(Session::GetUser('location') == 'sulmona'){
		$filter['fields']['location']->options = "sulmona:Sulmona";
		$filter['fields']['location']->value = 'sulmona';
		$filter['fields']['location']->usesNoSelection = false;			
	}			
	
	$filter['sheet']->addField($filter['fields']['location']);
	
	
}

$filter['buttons']['submit'] = new SubmitButton('submit');
$filter['buttons']['submit']->text = 'Filtra';
$filter['sheet']->addSubmitButton($filter['buttons']['submit']);

$filter['buttons']['reset'] = new ResetFilterButton('reset');
$filter['buttons']['reset']->text = 'Elimina filtro';
$filter['sheet']->addSubmitButton($filter['buttons']['reset']);

$filter['sheet']->setAndCheck();

?>

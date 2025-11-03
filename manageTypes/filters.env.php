<?php

IncludeLib('datetimelib');
IncludeObject('filtersheet');
IncludeField('text');
IncludeButton('filter');
IncludeButton('resetfilter');

global $filter;




$filter['sheet'] = new FilterSheet('fs_survey_manageTypes');
$filter['sheet']->columns = 4;
$filter['sheet']->title = 'Cerca';
$filter['sheet']->buttonsPosition = 'right';
$filter['sheet']->cssClass = 'fFilter'; 

$location = Session::GetUser('location');
$locationMarketClause="";
if($location == 'aquila'){
	$locationMarketClause=" AND FIND_IN_SET('{$location}',locations)";			
}

if (Session::UserHasOneOfProfilesIn('1,2,6') || (@$filter['command']=='list') || (@$filter['command']=='')) {
	
	$filter['fields']['label'] = new TextField('label');
	$filter['fields']['label']->label = 'Nome';
	$filter['sheet']->addField($filter['fields']['label']);
	
	$filter['fields']['viewable'] = new DropDownField('viewable');
	$filter['fields']['viewable']->label = 'Attiva?';
	$filter['fields']['viewable']->options = '1:Si;-1:No';
	$filter['fields']['viewable']->value = 'true';
	$filter['fields']['viewable']->usesNoSelection = true;	
	$filter['sheet']->addField($filter['fields']['viewable']);
	
	
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

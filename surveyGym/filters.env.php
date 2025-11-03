<?php

IncludeLib('datetimelib');
IncludeObject('filtersheet');
IncludeField('text');
IncludeField('double');
IncludeButton('filter');
IncludeButton('resetfilter');

global $filter;

$filter['sheet'] = new FilterSheet('fsdisaster');
$filter['sheet']->columns = 8;
$filter['sheet']->title = 'Cerca';
$filter['sheet']->buttonsPosition = 'right';
$filter['sheet']->cssClass = 'fFilter'; 


if (Session::UserHasOneOfProfilesIn('1,2,6')) {
	$filter['fields']['userId'] = new DropDownField('userId');
	$filter['fields']['userId']->label = 'Operatore';
	$filter['fields']['userId']->sourceCursor = Database::ExecuteSelect("SELECT id, CONCAT(surname, ' ', name) AS _label FROM users WHERE status='active' AND users.location !='satu' AND id IN (SELECT userId FROM pivot_users_profiles WHERE (profileId = '3' OR profileId = '1')) ORDER BY _label");
	$filter['fields']['userId']->usesNoSelection = true;
	$filter['fields']['userId']->sourceKey = 'id';
	$filter['fields']['userId']->sourceLabel = '_label';
	$filter['sheet']->addField($filter['fields']['userId']);
	
	
	$filter['fields']['tlId'] = new DropDownField('tlId');
	$filter['fields']['tlId']->label = 'TL';
	$filter['fields']['tlId']->sourceCursor = Database::ExecuteSelect("SELECT id, CONCAT(surname, ' ', name) AS _label FROM users WHERE status='active' AND users.location !='satu' AND job = 'Poste' AND id IN (SELECT userId FROM pivot_users_profiles WHERE (profileId = '2')) ORDER BY _label");
	$filter['fields']['tlId']->usesNoSelection = true;
	$filter['fields']['tlId']->sourceKey = 'id';
	$filter['fields']['tlId']->sourceLabel = '_label';
	$filter['sheet']->addField($filter['fields']['tlId']);

	
}
		$filter['fields']['firstQ'] = new DropDownField('firstQ');
		$filter['fields']['firstQ']->label = 'Domanda 1';
		$filter['fields']['firstQ']->options = 'Si singolo;Si di coppia;No';
		$filter['fields']['firstQ']->usesNoSelection = true;
		$filter['sheet']->addField($filter['fields']['firstQ']);
		
		$filter['fields']['secondQ'] = new DropDownField('secondQ');
		$filter['fields']['secondQ']->label = 'Domanda 2';
		$filter['fields']['secondQ']->options = 'Accesso singolo 1h al giorno per 2 giorni a settimana 70 euro;Accesso di coppia 1h al giorno per 2 giorni a settimana 100 euro';
		$filter['fields']['secondQ']->usesNoSelection = true;
		$filter['sheet']->addField($filter['fields']['secondQ']);
		




$filter['buttons']['submit'] = new SubmitButton('submit');
$filter['buttons']['submit']->text = 'Filtra';
$filter['sheet']->addSubmitButton($filter['buttons']['submit']);

$filter['buttons']['reset'] = new ResetFilterButton('reset');
$filter['buttons']['reset']->text = 'Elimina filtro';
$filter['sheet']->addSubmitButton($filter['buttons']['reset']);

$filter['sheet']->setAndCheck();

?>

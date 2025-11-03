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

		$filter['fields']['login'] = new TextField('login');
		$filter['fields']['login']->label = 'Login';
		$filter['sheet']->addField($filter['fields']['login']);
		

		
		$filter['fields']['withU'] = new DropDownField('withU');
		$filter['fields']['withU']->label = 'With U';
		$filter['fields']['withU']->options = '1:Si;-1:No';
		$filter['fields']['withU']->usesNoSelection = true;
		$filter['sheet']->addField($filter['fields']['withU']);
		
		$filter['fields']['pplSoft'] = new DropDownField('pplSoft');
		$filter['fields']['pplSoft']->label = 'Peoplesoft';
		$filter['fields']['pplSoft']->options = '1:Si;-1:No';
		$filter['fields']['pplSoft']->usesNoSelection = true;
		$filter['sheet']->addField($filter['fields']['pplSoft']);
		
		$filter['fields']['uadOmRimb'] = new DropDownField('uadOmRimb');
		$filter['fields']['uadOmRimb']->label = 'UAD + Omaggi e Rimborsi';
		$filter['fields']['uadOmRimb']->options = '1:Si;-1:No';
		$filter['fields']['uadOmRimb']->usesNoSelection = true;
		$filter['sheet']->addField($filter['fields']['uadOmRimb']);
		
		$filter['fields']['dss'] = new DropDownField('dss');
		$filter['fields']['dss']->label = 'DSS';
		$filter['fields']['dss']->options = '1:Si;-1:No';
		$filter['fields']['dss']->usesNoSelection = true;
		$filter['sheet']->addField($filter['fields']['dss']);
		
		$filter['fields']['dokCrm'] = new DropDownField('dokCrm');
		$filter['fields']['dokCrm']->label = 'DokCRM';
		$filter['fields']['dokCrm']->options = '1:Si;-1:No';
		$filter['fields']['dokCrm']->usesNoSelection = true;
		$filter['sheet']->addField($filter['fields']['dokCrm']);
		

		$filter['fields']['irma'] = new DropDownField('irma');
		$filter['fields']['irma']->label = 'IRMA';
		$filter['fields']['irma']->options = '1:Si;-1:No';
		$filter['fields']['irma']->usesNoSelection = true;
		$filter['sheet']->addField($filter['fields']['irma']);
		
		$filter['fields']['dbAuto'] = new DropDownField('dbAuto');
		$filter['fields']['dbAuto']->label = 'DB Auto';
		$filter['fields']['dbAuto']->options = '1:Si;-1:No';
		$filter['fields']['dbAuto']->usesNoSelection = true;
		$filter['sheet']->addField($filter['fields']['dbAuto']);
		
		$filter['fields']['mPay'] = new DropDownField('mPay');
		$filter['fields']['mPay']->label = 'M Pay';
		$filter['fields']['mPay']->options = '1:Si;-1:No';
		$filter['fields']['mPay']->usesNoSelection = true;
		$filter['sheet']->addField($filter['fields']['mPay']);
		
		$filter['fields']['oneShot'] = new DropDownField('oneShot');
		$filter['fields']['oneShot']->label = 'One Shot';
		$filter['fields']['oneShot']->options = '1:Si;-1:No';
		$filter['fields']['oneShot']->usesNoSelection = true;
		$filter['sheet']->addField($filter['fields']['oneShot']);
		
		$filter['fields']['ricaricaEasy'] = new DropDownField('ricaricaEasy');
		$filter['fields']['ricaricaEasy']->label = 'Cruscotto Ricarica facile';
		$filter['fields']['ricaricaEasy']->options = '1:Si;-1:No';
		$filter['fields']['ricaricaEasy']->usesNoSelection = true;
		$filter['sheet']->addField($filter['fields']['ricaricaEasy']);
		
		$filter['fields']['thd'] = new DropDownField('thd');
		$filter['fields']['thd']->label = 'THD';
		$filter['fields']['thd']->options = '1:Si;-1:No';
		$filter['fields']['thd']->usesNoSelection = true;
		$filter['sheet']->addField($filter['fields']['thd']);
		
		
		$filter['fields']['cora'] = new DropDownField('cora');
		$filter['fields']['cora']->label = 'CO.Ra';
		$filter['fields']['cora']->options = '1:Si;-1:No';
		$filter['fields']['cora']->usesNoSelection = true;
		$filter['sheet']->addField($filter['fields']['cora']);
		
		
		$filter['fields']['threeSat'] = new DropDownField('threeSat');
		$filter['fields']['threeSat']->label = '3SAT';
		$filter['fields']['threeSat']->options = '1:Si;-1:No';
		$filter['fields']['threeSat']->usesNoSelection = true;
		$filter['sheet']->addField($filter['fields']['threeSat']);
		
		
		$filter['fields']['ccmMail'] = new DropDownField('ccmMail');
		$filter['fields']['ccmMail']->label = 'Tool Casistiche CCM+sez mail';
		$filter['fields']['ccmMail']->options = '1:Si;-1:No';
		$filter['fields']['ccmMail']->usesNoSelection = true;
		$filter['sheet']->addField($filter['fields']['ccmMail']);
		
		$filter['fields']['gc3'] = new DropDownField('gc3');
		$filter['fields']['gc3']->label = 'Tool gc3';
		$filter['fields']['gc3']->options = '1:Si;-1:No';
		$filter['fields']['gc3']->usesNoSelection = true;
		$filter['sheet']->addField($filter['fields']['gc3']);
		
		$filter['fields']['wellDone'] = new DropDownField('wellDone');
		$filter['fields']['wellDone']->label = 'E-Learning WellDone';
		$filter['fields']['wellDone']->options = '1:Si;-1:No';
		$filter['fields']['wellDone']->usesNoSelection = true;
		$filter['sheet']->addField($filter['fields']['wellDone']);
		
		$filter['fields']['easyCimOutbound'] = new DropDownField('easyCimOutbound');
		$filter['fields']['easyCimOutbound']->label = 'EasyCIM Outbound';
		$filter['fields']['easyCimOutbound']->options = '1:Si;-1:No';
		$filter['fields']['easyCimOutbound']->usesNoSelection = true;
		$filter['sheet']->addField($filter['fields']['easyCimOutbound']);
		
		$filter['fields']['genesysBar'] = new DropDownField('genesysBar');
		$filter['fields']['genesysBar']->label = 'Barra Genesys';
		$filter['fields']['genesysBar']->options = '1:Si;-1:No';
		$filter['fields']['genesysBar']->usesNoSelection = true;
		$filter['sheet']->addField($filter['fields']['genesysBar']);



$filter['buttons']['submit'] = new SubmitButton('submit');
$filter['buttons']['submit']->text = 'Filtra';
$filter['sheet']->addSubmitButton($filter['buttons']['submit']);

$filter['buttons']['reset'] = new ResetFilterButton('reset');
$filter['buttons']['reset']->text = 'Elimina filtro';
$filter['sheet']->addSubmitButton($filter['buttons']['reset']);

$filter['sheet']->setAndCheck();

?>

<?php

Session::PageWantsLogin();

IncludeManager('table');
IncludeLib('datetimelib');
IncludeField('text');
IncludeField('email');
IncludeField('double');
IncludeField('check');
IncludeField('datetime');
IncludeField('time');
IncludeField('dropdown');
IncludeField('integer');
IncludeCommand('command');
IncludeButton('submit');
IncludeButton('reset');
IncludeHandler('field');
IncludeHandler('command');
IncludeField('file');


global $surveyAquila, $filter;




//ini_set('error_reporting', E_ALL);
//ini_set("display_errors", 1);

Template::ImportService('survey/surveyAquila','filters');

$surveyAquila['id'] = isset($_GET['_id']) ? intval($_GET['_id']) : intval(@$_POST['_id']);
$surveyAquila['command'] = isset($_GET['_command']) ? $_GET['_command'] : @$_POST['_command'];

$surveyAquila['manager'] = new TableManager();
$surveyAquila['manager']->table = 'surveys.survey_access_aquila';
$surveyAquila['manager']->folder = 'survey/surveyAquila';


if (Session::UserHasOneOfProfilesIn('3')) {
	$surveyAquila['manager']->addFilter('userId', Session::GetUser('id'));
} 
$surveyAquila['manager']->selectFields .= " ,surveys.survey_access_aquila.id AS id ";


$surveyAquila['sheet'] = new Sheet('sheet');
$surveyAquila['sheet']->errorsForeword = 'Non e\' stato possibile inviare i dati. Si sono verificati i seguenti errori';
$surveyAquila['sheet']->cssClass = 'tblForm';
$surveyAquila['sheet']->notEmptyMarker = '*';
$surveyAquila['sheet']->key = 'id';







	/*Includo questi componenti nell'interfaccia insert*/
	$interfaceIncluded=array('insert','','list','modify');
	if (in_array(@$surveyAquila['command'],$interfaceIncluded)){
		
		if(@$surveyAquila['command']=='' || @$surveyAquila['command']=='list'){
			$surveyAquila['fields']['insertDt'] = new DateTimeField('insertDt');
			$surveyAquila['fields']['insertDt']->label = 'Data/Ora inserimento';
			$surveyAquila['sheet']->addField($surveyAquila['fields']['insertDt']);
			
		}


		if(@$surveyAquila['command']=='' || @$surveyAquila['command']=='list' || @$surveyAquila['command']=='modify'){
		
			$surveyAquila['fields']['userId'] = new DropDownField('userId');
			$surveyAquila['fields']['userId']->label = 'Operatore';
			
			if(isSuperUser())
				$surveyAquila['fields']['userId']->sourceCursor = Database::ExecuteSelect("SELECT id, CONCAT(surname, ' ', name) AS _label FROM users ORDER BY _label");
			else
				$surveyAquila['fields']['userId']->sourceCursor = Database::ExecuteSelect("SELECT id, CONCAT(surname, ' ', name) AS _label FROM users WHERE users.job = '".Session::GetUser('job')."'  AND id IN (SELECT userId FROM pivot_users_profiles WHERE (profileId IN ('2','3','1'))) ORDER BY _label");
			
			$surveyAquila['fields']['userId']->usesNoSelection = true;
			$surveyAquila['fields']['userId']->sourceKey = 'id';
			$surveyAquila['fields']['userId']->sourceLabel = '_label';
			$surveyAquila['sheet']->addField($surveyAquila['fields']['userId']);
		}
		
		if(@$surveyAquila['command']=='' || @$surveyAquila['command']=='list'){
			
			// campi utente
			
		}	
		
		
		$surveyAquila['fields']['login'] = new TextField('login');
		$surveyAquila['fields']['login']->label = 'Login';
		$surveyAquila['fields']['login']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['sheet']->addField($surveyAquila['fields']['login']);
		
		$surveyAquila['fields']['token'] = new TextField('token');
		$surveyAquila['fields']['token']->label = 'Token';
		$surveyAquila['fields']['token']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['sheet']->addField($surveyAquila['fields']['token']);
		
		
		$surveyAquila['fields']['tokenWorks'] = new DropDownField('tokenWorks');
		$surveyAquila['fields']['tokenWorks']->label = 'Il token funziona?';
		$surveyAquila['fields']['tokenWorks']->options = '1:Si;-1:No';
		$surveyAquila['fields']['tokenWorks']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['fields']['tokenWorks']->usesNoSelection = true;
		$surveyAquila['sheet']->addField($surveyAquila['fields']['tokenWorks']);
		
		$surveyAquila['fields']['withU'] = new DropDownField('withU');
		$surveyAquila['fields']['withU']->label = 'With U';
		$surveyAquila['fields']['withU']->options = '1:Si;-1:No';
		$surveyAquila['fields']['withU']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['fields']['withU']->usesNoSelection = true;
		$surveyAquila['sheet']->addField($surveyAquila['fields']['withU']);
		
		$surveyAquila['fields']['pplSoft'] = new DropDownField('pplSoft');
		$surveyAquila['fields']['pplSoft']->label = 'Peoplesoft';
		$surveyAquila['fields']['pplSoft']->options = '1:Si;-1:No';
		$surveyAquila['fields']['pplSoft']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['fields']['pplSoft']->usesNoSelection = true;
		$surveyAquila['sheet']->addField($surveyAquila['fields']['pplSoft']);
		
		$surveyAquila['fields']['uadOmRimb'] = new DropDownField('uadOmRimb');
		$surveyAquila['fields']['uadOmRimb']->label = 'UAD + Omaggi e Rimborsi';
		$surveyAquila['fields']['uadOmRimb']->options = '1:Si;-1:No';
		$surveyAquila['fields']['uadOmRimb']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['fields']['uadOmRimb']->usesNoSelection = true;
		$surveyAquila['sheet']->addField($surveyAquila['fields']['uadOmRimb']);
		
		$surveyAquila['fields']['dss'] = new DropDownField('dss');
		$surveyAquila['fields']['dss']->label = 'DSS';
		$surveyAquila['fields']['dss']->options = '1:Si;-1:No';
		$surveyAquila['fields']['dss']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['fields']['dss']->usesNoSelection = true;
		$surveyAquila['sheet']->addField($surveyAquila['fields']['dss']);
		
		$surveyAquila['fields']['dokCrm'] = new DropDownField('dokCrm');
		$surveyAquila['fields']['dokCrm']->label = 'DokCRM';
		$surveyAquila['fields']['dokCrm']->options = '1:Si;-1:No';
		$surveyAquila['fields']['dokCrm']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['fields']['dokCrm']->usesNoSelection = true;
		$surveyAquila['sheet']->addField($surveyAquila['fields']['dokCrm']);


		$surveyAquila['fields']['dmsOt'] = new DropDownField('dmsOt');
		$surveyAquila['fields']['dmsOt']->label = 'DMS OT';
		$surveyAquila['fields']['dmsOt']->options = '1:Si;-1:No';
		$surveyAquila['fields']['dmsOt']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['fields']['dmsOt']->usesNoSelection = true;
		$surveyAquila['sheet']->addField($surveyAquila['fields']['dmsOt']);		

		$surveyAquila['fields']['irma'] = new DropDownField('irma');
		$surveyAquila['fields']['irma']->label = 'IRMA';
		$surveyAquila['fields']['irma']->options = '1:Si;-1:No';
		$surveyAquila['fields']['irma']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['fields']['irma']->usesNoSelection = true;
		$surveyAquila['sheet']->addField($surveyAquila['fields']['irma']);
		
		$surveyAquila['fields']['dbAuto'] = new DropDownField('dbAuto');
		$surveyAquila['fields']['dbAuto']->label = 'DB Auto';
		$surveyAquila['fields']['dbAuto']->options = '1:Si;-1:No';
		$surveyAquila['fields']['dbAuto']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['fields']['dbAuto']->usesNoSelection = true;
		$surveyAquila['sheet']->addField($surveyAquila['fields']['dbAuto']);
		
		$surveyAquila['fields']['mPay'] = new DropDownField('mPay');
		$surveyAquila['fields']['mPay']->label = 'M Pay';
		$surveyAquila['fields']['mPay']->options = '1:Si;-1:No';
		$surveyAquila['fields']['mPay']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['fields']['mPay']->usesNoSelection = true;
		$surveyAquila['sheet']->addField($surveyAquila['fields']['mPay']);
		
		$surveyAquila['fields']['oneShot'] = new DropDownField('oneShot');
		$surveyAquila['fields']['oneShot']->label = 'One Shot';
		$surveyAquila['fields']['oneShot']->options = '1:Si;-1:No';
		$surveyAquila['fields']['oneShot']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['fields']['oneShot']->usesNoSelection = true;
		$surveyAquila['sheet']->addField($surveyAquila['fields']['oneShot']);
		
		$surveyAquila['fields']['ricaricaEasy'] = new DropDownField('ricaricaEasy');
		$surveyAquila['fields']['ricaricaEasy']->label = 'Cruscotto Ricarica facile';
		$surveyAquila['fields']['ricaricaEasy']->options = '1:Si;-1:No';
		$surveyAquila['fields']['ricaricaEasy']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['fields']['ricaricaEasy']->usesNoSelection = true;
		$surveyAquila['sheet']->addField($surveyAquila['fields']['ricaricaEasy']);
		
		$surveyAquila['fields']['thd'] = new DropDownField('thd');
		$surveyAquila['fields']['thd']->label = 'THD';
		$surveyAquila['fields']['thd']->options = '1:Si;-1:No';
		$surveyAquila['fields']['thd']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['fields']['thd']->usesNoSelection = true;
		$surveyAquila['sheet']->addField($surveyAquila['fields']['thd']);
		
		
		$surveyAquila['fields']['cora'] = new DropDownField('cora');
		$surveyAquila['fields']['cora']->label = 'CO.Ra';
		$surveyAquila['fields']['cora']->options = '1:Si;-1:No';
		$surveyAquila['fields']['cora']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['fields']['cora']->usesNoSelection = true;
		$surveyAquila['sheet']->addField($surveyAquila['fields']['cora']);
		
		
		$surveyAquila['fields']['threeSat'] = new DropDownField('threeSat');
		$surveyAquila['fields']['threeSat']->label = '3SAT';
		$surveyAquila['fields']['threeSat']->options = '1:Si;-1:No';
		$surveyAquila['fields']['threeSat']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['fields']['threeSat']->usesNoSelection = true;
		$surveyAquila['sheet']->addField($surveyAquila['fields']['threeSat']);
		
		
		$surveyAquila['fields']['ccmMail'] = new DropDownField('ccmMail');
		$surveyAquila['fields']['ccmMail']->label = 'Tool Casistiche CCM+sez mail';
		$surveyAquila['fields']['ccmMail']->options = '1:Si;-1:No';
		$surveyAquila['fields']['ccmMail']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['fields']['ccmMail']->usesNoSelection = true;
		$surveyAquila['sheet']->addField($surveyAquila['fields']['ccmMail']);
		
		$surveyAquila['fields']['gc3'] = new DropDownField('gc3');
		$surveyAquila['fields']['gc3']->label = 'Tool gc3';
		$surveyAquila['fields']['gc3']->options = '1:Si;-1:No';
		$surveyAquila['fields']['gc3']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['fields']['gc3']->usesNoSelection = true;
		$surveyAquila['sheet']->addField($surveyAquila['fields']['gc3']);
		
		$surveyAquila['fields']['wellDone'] = new DropDownField('wellDone');
		$surveyAquila['fields']['wellDone']->label = 'E-Learning WellDone';
		$surveyAquila['fields']['wellDone']->options = '1:Si;-1:No';
		$surveyAquila['fields']['wellDone']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['fields']['wellDone']->usesNoSelection = true;
		$surveyAquila['sheet']->addField($surveyAquila['fields']['wellDone']);
		
		$surveyAquila['fields']['easyCimOutbound'] = new DropDownField('easyCimOutbound');
		$surveyAquila['fields']['easyCimOutbound']->label = 'EasyCIM Outbound';
		$surveyAquila['fields']['easyCimOutbound']->options = '1:Si;-1:No';
		$surveyAquila['fields']['easyCimOutbound']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['fields']['easyCimOutbound']->usesNoSelection = true;
		$surveyAquila['sheet']->addField($surveyAquila['fields']['easyCimOutbound']);
		
		$surveyAquila['fields']['genesysBar'] = new DropDownField('genesysBar');
		$surveyAquila['fields']['genesysBar']->label = 'Barra Genesys';
		$surveyAquila['fields']['genesysBar']->options = '1:Si;-1:No';
		$surveyAquila['fields']['genesysBar']->addFlag(Field::NOT_EMPTY());
		$surveyAquila['fields']['genesysBar']->usesNoSelection = true;
		$surveyAquila['sheet']->addField($surveyAquila['fields']['genesysBar']);
		
		

		
	}
	
		$surveyAquila['commands']['modify'] = new Command('modify');
		$surveyAquila['commands']['modify']->imageAddress = GetImageAddress('icons/modify_22.png');
		$surveyAquila['commands']['modify']->address = Language::GetAddress($surveyAquila['manager']->folder.'/');
		$surveyAquila['commands']['modify']->tooltip = 'Modifica';
		$surveyAquila['sheet']->addCommand($surveyAquila['commands']['modify']);
		

	if (Session::UserHasOneOfProfilesIn('1,2,6')) {
	


		$surveyAquila['commands']['delete'] = new Command('dodelete');
		$surveyAquila['commands']['delete']->imageAddress = GetImageAddress('icons/delete_22.png');
		$surveyAquila['commands']['delete']->address = Language::GetAddress($surveyAquila['manager']->folder.'/');
		$surveyAquila['commands']['delete']->onClick = "return confirm('Sicuro di voler cancellare l\\'elemento?')";
		$surveyAquila['commands']['delete']->tooltip = 'Elimina';
		$surveyAquila['sheet']->addCommand($surveyAquila['commands']['delete']);
	
	}




	$surveyAquila['buttons']['reset'] = new ResetButton('reset');
	$surveyAquila['buttons']['reset']->text = 'Reset';
	$surveyAquila['sheet']->addResetButton($surveyAquila['buttons']['reset']);

	$surveyAquila['buttons']['submit'] = new SubmitButton('submit');
	$surveyAquila['buttons']['submit']->text = 'Invia';
	$surveyAquila['sheet']->addSubmitButton($surveyAquila['buttons']['submit']);




?>
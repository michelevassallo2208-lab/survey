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


global $surveyLocker, $filter;


//ini_set('error_reporting', E_ALL);
//ini_set("display_errors", 1);

Template::ImportService('survey/surveyLocker','filters');

$surveyLocker['id'] = isset($_GET['_id']) ? intval($_GET['_id']) : intval(@$_POST['_id']);
$surveyLocker['command'] = isset($_GET['_command']) ? $_GET['_command'] : @$_POST['_command'];

$surveyLocker['manager'] = new TableManager();
$surveyLocker['manager']->table = 'surveys.survey_locker';
$surveyLocker['manager']->folder = 'survey/surveyLocker';


if (Session::UserHasOneOfProfilesIn('3')) {
	$surveyLocker['manager']->addFilter('userId', Session::GetUser('id'));
} 
$surveyLocker['manager']->selectFields .= " ,surveys.survey_locker.id AS id ";


$surveyLocker['sheet'] = new Sheet('sheet');
$surveyLocker['sheet']->errorsForeword = 'Non e\' stato possibile inviare i dati. Si sono verificati i seguenti errori';
$surveyLocker['sheet']->cssClass = 'tblForm';
$surveyLocker['sheet']->notEmptyMarker = '*';
$surveyLocker['sheet']->key = 'id';

	/*Includo questi componenti nell'interfaccia insert*/
	$interfaceIncluded=array('insert','','list','modify');
	if (in_array(@$surveyLocker['command'],$interfaceIncluded)){
		
		if(@$surveyLocker['command']=='' || @$surveyLocker['command']=='list'){
			$surveyLocker['fields']['insertDt'] = new DateTimeField('insertDt');
			$surveyLocker['fields']['insertDt']->label = 'Data/Ora inserimento';
			$surveyLocker['sheet']->addField($surveyLocker['fields']['insertDt']);
			
		}


		if(@$surveyLocker['command']=='' || @$surveyLocker['command']=='list' || @$surveyLocker['command']=='modify'){
		
			$surveyLocker['fields']['userId'] = new DropDownField('userId');
			$surveyLocker['fields']['userId']->label = 'Operatore';
			
			if(isSuperUser())
				$surveyLocker['fields']['userId']->sourceCursor = Database::ExecuteSelect("SELECT id, CONCAT(surname, ' ', name) AS _label FROM users ORDER BY _label");
			else
				$surveyLocker['fields']['userId']->sourceCursor = Database::ExecuteSelect("SELECT id, CONCAT(surname, ' ', name) AS _label FROM users WHERE users.job = '".Session::GetUser('job')."'  AND id IN (SELECT userId FROM pivot_users_profiles WHERE (profileId IN ('2','3','1'))) ORDER BY _label");
			
			$surveyLocker['fields']['userId']->usesNoSelection = true;
			$surveyLocker['fields']['userId']->sourceKey = 'id';
			$surveyLocker['fields']['userId']->sourceLabel = '_label';
			$surveyLocker['sheet']->addField($surveyLocker['fields']['userId']);
		}
		
		if(@$surveyLocker['command']=='' || @$surveyLocker['command']=='list'){
			
			// campi utente
			
		}	
		
		
		$surveyLocker['fields']['firstQ'] = new DropDownField('firstQ');
		$surveyLocker['fields']['firstQ']->label = 'Ciao, sei in possesso dell\'armadietto?';
		$surveyLocker['fields']['firstQ']->options = 'Si;No';
		$surveyLocker['fields']['firstQ']->addFlag(Field::NOT_EMPTY());
		$surveyLocker['fields']['firstQ']->usesNoSelection = true;
		$surveyLocker['sheet']->addField($surveyLocker['fields']['firstQ']);
		

		$surveyLocker['fields']['secondQ'] = new TextField('secondQ');
		$surveyLocker['fields']['secondQ']->label = 'INDICA IL NUMERO';
		$surveyLocker['sheet']->addField($surveyLocker['fields']['secondQ']);
		
		$surveyLocker['fields']['thirdQ'] = new DropDownField('thirdQ');
		$surveyLocker['fields']['thirdQ']->label = 'INDICA IN QUALE SALA  E\' UBICATO';
		$surveyLocker['fields']['thirdQ']->options = 'Piano Terra (SF);Piano Terra (PM);Primo piano Wind3';
		$surveyLocker['fields']['thirdQ']->usesNoSelection = true;
		$surveyLocker['sheet']->addField($surveyLocker['fields']['thirdQ']);
		// $surveyLocker['fields']['thirdQ']->addFlag(Field::NOT_EMPTY());

	}
	
		$surveyLocker['commands']['modify'] = new Command('modify');
		$surveyLocker['commands']['modify']->imageAddress = GetImageAddress('icons/modify_22.png');
		$surveyLocker['commands']['modify']->address = Language::GetAddress($surveyLocker['manager']->folder.'/');
		$surveyLocker['commands']['modify']->tooltip = 'Modifica';
		$surveyLocker['sheet']->addCommand($surveyLocker['commands']['modify']);
		

	if (Session::UserHasOneOfProfilesIn('1,2,6')) {
	


		$surveyLocker['commands']['delete'] = new Command('dodelete');
		$surveyLocker['commands']['delete']->imageAddress = GetImageAddress('icons/delete_22.png');
		$surveyLocker['commands']['delete']->address = Language::GetAddress($surveyLocker['manager']->folder.'/');
		$surveyLocker['commands']['delete']->onClick = "return confirm('Sicuro di voler cancellare l\\'elemento?')";
		$surveyLocker['commands']['delete']->tooltip = 'Elimina';
		$surveyLocker['sheet']->addCommand($surveyLocker['commands']['delete']);
	
	}




	$surveyLocker['buttons']['reset'] = new ResetButton('reset');
	$surveyLocker['buttons']['reset']->text = 'Reset';
	$surveyLocker['sheet']->addResetButton($surveyLocker['buttons']['reset']);

	$surveyLocker['buttons']['submit'] = new SubmitButton('submit');
	$surveyLocker['buttons']['submit']->text = 'Invia';
	$surveyLocker['sheet']->addSubmitButton($surveyLocker['buttons']['submit']);




?>
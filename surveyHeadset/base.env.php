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


global $surveyHeadset, $filter;


//ini_set('error_reporting', E_ALL);
//ini_set("display_errors", 1);

Template::ImportService('survey/surveyHeadset','filters');

$surveyHeadset['id'] = isset($_GET['_id']) ? intval($_GET['_id']) : intval(@$_POST['_id']);
$surveyHeadset['command'] = isset($_GET['_command']) ? $_GET['_command'] : @$_POST['_command'];

$surveyHeadset['manager'] = new TableManager();
$surveyHeadset['manager']->table = 'surveys.survey_headset';
$surveyHeadset['manager']->folder = 'survey/surveyHeadset';


if (Session::UserHasOneOfProfilesIn('3')) {
	$surveyHeadset['manager']->addFilter('userId', Session::GetUser('id'));
} 
$surveyHeadset['manager']->selectFields .= " ,surveys.survey_gym.id AS id ";


$surveyHeadset['sheet'] = new Sheet('sheet');
$surveyHeadset['sheet']->errorsForeword = 'Non e\' stato possibile inviare i dati. Si sono verificati i seguenti errori';
$surveyHeadset['sheet']->cssClass = 'tblForm';
$surveyHeadset['sheet']->notEmptyMarker = '*';
$surveyHeadset['sheet']->key = 'id';

	/*Includo questi componenti nell'interfaccia insert*/
	$interfaceIncluded=array('insert','','list','modify');
	if (in_array(@$surveyHeadset['command'],$interfaceIncluded)){
		
		if(@$surveyHeadset['command']=='' || @$surveyHeadset['command']=='list'){
			$surveyHeadset['fields']['insertDt'] = new DateTimeField('insertDt');
			$surveyHeadset['fields']['insertDt']->label = 'Data/Ora inserimento';
			$surveyHeadset['sheet']->addField($surveyHeadset['fields']['insertDt']);
			
		}


		if(@$surveyHeadset['command']=='' || @$surveyHeadset['command']=='list' || @$surveyHeadset['command']=='modify'){
		
			$surveyHeadset['fields']['userId'] = new DropDownField('userId');
			$surveyHeadset['fields']['userId']->label = 'Operatore';
			
			if(isSuperUser())
				$surveyHeadset['fields']['userId']->sourceCursor = Database::ExecuteSelect("SELECT id, CONCAT(surname, ' ', name) AS _label FROM users ORDER BY _label");
			else
				$surveyHeadset['fields']['userId']->sourceCursor = Database::ExecuteSelect("SELECT id, CONCAT(surname, ' ', name) AS _label FROM users WHERE users.job = '".Session::GetUser('job')."'  AND id IN (SELECT userId FROM pivot_users_profiles WHERE (profileId IN ('2','3','1'))) ORDER BY _label");
			
			$surveyHeadset['fields']['userId']->usesNoSelection = true;
			$surveyHeadset['fields']['userId']->sourceKey = 'id';
			$surveyHeadset['fields']['userId']->sourceLabel = '_label';
			$surveyHeadset['sheet']->addField($surveyHeadset['fields']['userId']);
		}
		
		if(@$surveyHeadset['command']=='' || @$surveyHeadset['command']=='list'){
			
			// campi utente
			
		}	
				
		$surveyHeadset['fields']['firstQ'] = new TextField('firstQ');
		$surveyHeadset['fields']['firstQ']->label = 'Seriale cuffie';
		$surveyHeadset['fields']['firstQ']->addFlag(Field::NOT_EMPTY());
		$surveyHeadset['sheet']->addField($surveyHeadset['fields']['firstQ']);
		
		$surveyHeadset['fields']['secondQ'] = new TextField('secondQ');
		$surveyHeadset['fields']['secondQ']->label = 'Seriale adattatore';
		$surveyHeadset['fields']['secondQ']->addFlag(Field::NOT_EMPTY());
		$surveyHeadset['sheet']->addField($surveyHeadset['fields']['secondQ']);

	}
	
		$surveyHeadset['commands']['modify'] = new Command('modify');
		$surveyHeadset['commands']['modify']->imageAddress = GetImageAddress('icons/modify_22.png');
		$surveyHeadset['commands']['modify']->address = Language::GetAddress($surveyHeadset['manager']->folder.'/');
		$surveyHeadset['commands']['modify']->tooltip = 'Modifica';
		$surveyHeadset['sheet']->addCommand($surveyHeadset['commands']['modify']);
		

	if (Session::UserHasOneOfProfilesIn('1,2,6')) {
	
		$surveyHeadset['commands']['delete'] = new Command('dodelete');
		$surveyHeadset['commands']['delete']->imageAddress = GetImageAddress('icons/delete_22.png');
		$surveyHeadset['commands']['delete']->address = Language::GetAddress($surveyHeadset['manager']->folder.'/');
		$surveyHeadset['commands']['delete']->onClick = "return confirm('Sicuro di voler cancellare l\\'elemento?')";
		$surveyHeadset['commands']['delete']->tooltip = 'Elimina';
		$surveyHeadset['sheet']->addCommand($surveyHeadset['commands']['delete']);
	
	}




	$surveyHeadset['buttons']['reset'] = new ResetButton('reset');
	$surveyHeadset['buttons']['reset']->text = 'Reset';
	$surveyHeadset['sheet']->addResetButton($surveyHeadset['buttons']['reset']);

	$surveyHeadset['buttons']['submit'] = new SubmitButton('submit');
	$surveyHeadset['buttons']['submit']->text = 'Invia';
	$surveyHeadset['sheet']->addSubmitButton($surveyHeadset['buttons']['submit']);




?>
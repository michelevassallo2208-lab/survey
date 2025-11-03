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


global $surveyGym, $filter;


//ini_set('error_reporting', E_ALL);
//ini_set("display_errors", 1);

Template::ImportService('survey/surveyGym','filters');

$surveyGym['id'] = isset($_GET['_id']) ? intval($_GET['_id']) : intval(@$_POST['_id']);
$surveyGym['command'] = isset($_GET['_command']) ? $_GET['_command'] : @$_POST['_command'];

$surveyGym['manager'] = new TableManager();
$surveyGym['manager']->table = 'surveys.survey_gym';
$surveyGym['manager']->folder = 'survey/surveyGym';


if (Session::UserHasOneOfProfilesIn('3')) {
	$surveyGym['manager']->addFilter('userId', Session::GetUser('id'));
} 
$surveyGym['manager']->selectFields .= " ,surveys.survey_gym.id AS id ";


$surveyGym['sheet'] = new Sheet('sheet');
$surveyGym['sheet']->errorsForeword = 'Non e\' stato possibile inviare i dati. Si sono verificati i seguenti errori';
$surveyGym['sheet']->cssClass = 'tblForm';
$surveyGym['sheet']->notEmptyMarker = '*';
$surveyGym['sheet']->key = 'id';

	/*Includo questi componenti nell'interfaccia insert*/
	$interfaceIncluded=array('insert','','list','modify');
	if (in_array(@$surveyGym['command'],$interfaceIncluded)){
		
		if(@$surveyGym['command']=='' || @$surveyGym['command']=='list'){
			$surveyGym['fields']['insertDt'] = new DateTimeField('insertDt');
			$surveyGym['fields']['insertDt']->label = 'Data/Ora inserimento';
			$surveyGym['sheet']->addField($surveyGym['fields']['insertDt']);
			
		}


		if(@$surveyGym['command']=='' || @$surveyGym['command']=='list' || @$surveyGym['command']=='modify'){
		
			$surveyGym['fields']['userId'] = new DropDownField('userId');
			$surveyGym['fields']['userId']->label = 'Operatore';
			
			if(isSuperUser())
				$surveyGym['fields']['userId']->sourceCursor = Database::ExecuteSelect("SELECT id, CONCAT(surname, ' ', name) AS _label FROM users ORDER BY _label");
			else
				$surveyGym['fields']['userId']->sourceCursor = Database::ExecuteSelect("SELECT id, CONCAT(surname, ' ', name) AS _label FROM users WHERE users.job = '".Session::GetUser('job')."'  AND id IN (SELECT userId FROM pivot_users_profiles WHERE (profileId IN ('2','3','1'))) ORDER BY _label");
			
			$surveyGym['fields']['userId']->usesNoSelection = true;
			$surveyGym['fields']['userId']->sourceKey = 'id';
			$surveyGym['fields']['userId']->sourceLabel = '_label';
			$surveyGym['sheet']->addField($surveyGym['fields']['userId']);
		}
		
		if(@$surveyGym['command']=='' || @$surveyGym['command']=='list'){
			
			// campi utente
			
		}	
		
		
		$surveyGym['fields']['firstQ'] = new DropDownField('firstQ');
		$surveyGym['fields']['firstQ']->label = 'Ti piacerebbe avere una palestra accanto al lavoro in esclusiva<br /> ed essere seguito da un personal trainer in percorsi singoli o di coppia?';
		$surveyGym['fields']['firstQ']->options = 'Si singolo;Si di coppia;No';
		$surveyGym['fields']['firstQ']->addFlag(Field::NOT_EMPTY());
		$surveyGym['fields']['firstQ']->usesNoSelection = true;
		$surveyGym['sheet']->addField($surveyGym['fields']['firstQ']);
		

		$surveyGym['fields']['secondQ'] = new DropDownField('secondQ');
		$surveyGym['fields']['secondQ']->label = 'Quanto spenderesti al mese per singolo percorso?';
		$surveyGym['fields']['secondQ']->options = 'Accesso singolo 1h al giorno per 2 giorni a settimana 70 euro;Accesso di coppia 1h al giorno per 2 giorni a settimana 100 euro';
		// $surveyGym['fields']['secondQ']->addFlag(Field::NOT_EMPTY());
		$surveyGym['fields']['secondQ']->usesNoSelection = true;
		$surveyGym['sheet']->addField($surveyGym['fields']['secondQ']);
		
		$surveyGym['fields']['thirdQ'] = new DropDownField('thirdQ');
		$surveyGym['fields']['thirdQ']->label = 'Ti farebbe piacere se fosse aperta anche di sabato e domenica?';
		$surveyGym['fields']['thirdQ']->options = 'Si;No';
		// $surveyGym['fields']['thirdQ']->addFlag(Field::NOT_EMPTY());
		$surveyGym['fields']['thirdQ']->usesNoSelection = true;
		$surveyGym['sheet']->addField($surveyGym['fields']['thirdQ']);
		
		$surveyGym['fields']['other'] = new TextField('other');
		$surveyGym['fields']['other']->label = 'Altro';
		// $surveyGym['fields']['other']->addFlag(Field::NOT_EMPTY());
		$surveyGym['sheet']->addField($surveyGym['fields']['other']);

	}
	
		$surveyGym['commands']['modify'] = new Command('modify');
		$surveyGym['commands']['modify']->imageAddress = GetImageAddress('icons/modify_22.png');
		$surveyGym['commands']['modify']->address = Language::GetAddress($surveyGym['manager']->folder.'/');
		$surveyGym['commands']['modify']->tooltip = 'Modifica';
		$surveyGym['sheet']->addCommand($surveyGym['commands']['modify']);
		

	if (Session::UserHasOneOfProfilesIn('1,2,6')) {
	


		$surveyGym['commands']['delete'] = new Command('dodelete');
		$surveyGym['commands']['delete']->imageAddress = GetImageAddress('icons/delete_22.png');
		$surveyGym['commands']['delete']->address = Language::GetAddress($surveyGym['manager']->folder.'/');
		$surveyGym['commands']['delete']->onClick = "return confirm('Sicuro di voler cancellare l\\'elemento?')";
		$surveyGym['commands']['delete']->tooltip = 'Elimina';
		$surveyGym['sheet']->addCommand($surveyGym['commands']['delete']);
	
	}




	$surveyGym['buttons']['reset'] = new ResetButton('reset');
	$surveyGym['buttons']['reset']->text = 'Reset';
	$surveyGym['sheet']->addResetButton($surveyGym['buttons']['reset']);

	$surveyGym['buttons']['submit'] = new SubmitButton('submit');
	$surveyGym['buttons']['submit']->text = 'Invia';
	$surveyGym['sheet']->addSubmitButton($surveyGym['buttons']['submit']);




?>
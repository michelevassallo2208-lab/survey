<?php
IncludeManager('table');
IncludeLib('datetimelib');
IncludeHandler('field');
IncludeField('text');
IncludeField('check');
IncludeField('datetime');
IncludeField('dropdown');
IncludeField('integer');
IncludeField('radiolist');
IncludeCommand('command');
IncludeButton('submit');
IncludeButton('reset');

global $survey_manageTypes, $filter;

//ini_set('error_reporting', E_ALL);
//ini_set("display_errors", 1);

$location = Session::GetUser('location');
$locationMarketClause="";
if($location == 'aquila'){
	$locationMarketClause=" AND FIND_IN_SET('{$location}',locations)";
}

Template::ImportService('survey/manageTypes','filters');



class CloseFieldHandler extends FieldHandler {
	function showAsListValue() {
		global $survey_manageTypes;		
		$this->field->listCommand = 'doclose';
		echo($this->field->toListValue());
	}
}



$survey_manageTypes['id'] = isset($_GET['_id']) ? intval($_GET['_id']) : intval(@$_POST['_id']);
$survey_manageTypes['command'] = isset($_GET['_command']) ? $_GET['_command'] : @$_POST['_command'];

$survey_manageTypes['manager'] = new TableManager();
$survey_manageTypes['manager']->table = 'surveys.survey_types';
$survey_manageTypes['manager']->folder = 'survey/manageTypes';



$survey_manageTypes['sheet'] = new Sheet('sheet');
$survey_manageTypes['sheet']->errorsForeword = 'Non e\' stato possibile inviare i dati. Si sono verificati i seguenti errori';
$survey_manageTypes['sheet']->cssClass = 'tblForm';
$survey_manageTypes['sheet']->notEmptyMarker = '*';
$survey_manageTypes['sheet']->key = 'id';





if (Session::UserHasOneOfProfilesIn('1,2,6')) {
	
	
	$survey_manageTypes['fields']['label'] = new TextField('label');
	$survey_manageTypes['fields']['label']->label = 'Tipologia';
	$survey_manageTypes['fields']['label']->addFlag(Field::NOT_EMPTY());
	$survey_manageTypes['sheet']->addField($survey_manageTypes['fields']['label']);
	
	$survey_manageTypes['fields']['viewable'] = new DropDownField('viewable');
	$survey_manageTypes['fields']['viewable']->label = 'Attiva?';
	$survey_manageTypes['fields']['viewable']->options = '1:Si;-1:No';
	$survey_manageTypes['fields']['viewable']->value = 'true';
	// $survey_manageTypes['fields']['viewable']->usesNoSelection = true;	
	$survey_manageTypes['fields']['viewable']->addFlag(Field::NOT_EMPTY());		
	$survey_manageTypes['sheet']->addField($survey_manageTypes['fields']['viewable']);
	

	
	
}





if (@$survey_manageTypes['command']!='export' && Session::UserHasOneOfProfilesIn('1,2,6')) {
	$survey_manageTypes['commands']['modify'] = new Command('modify');
	$survey_manageTypes['commands']['modify']->imageAddress = GetImageAddress('icons/modify_22.png');
	$survey_manageTypes['commands']['modify']->address = Language::GetAddress($survey_manageTypes['manager']->folder.'/');
	$survey_manageTypes['commands']['modify']->tooltip = 'Modifica';
	$survey_manageTypes['sheet']->addCommand($survey_manageTypes['commands']['modify']);

/* 	$survey_manageTypes['commands']['delete'] = new Command('dodelete');
	$survey_manageTypes['commands']['delete']->imageAddress = GetImageAddress('delete.gif');
	$survey_manageTypes['commands']['delete']->address = Language::GetAddress($survey['manager']->folder.'/');
	$survey_manageTypes['commands']['delete']->onClick = "return confirm('Sicuro di voler cancellare l\\'elemento?')";
	$survey_manageTypes['commands']['delete']->tooltip = 'Elimina';
	$survey_manageTypes['sheet']->addCommand($survey['commands']['delete']);  */
}

$survey_manageTypes['buttons']['reset'] = new ResetButton('reset');
$survey_manageTypes['buttons']['reset']->text = 'Reset';
$survey_manageTypes['sheet']->addResetButton($survey_manageTypes['buttons']['reset']);

$survey_manageTypes['buttons']['submit'] = new SubmitButton('submit');
$survey_manageTypes['buttons']['submit']->text = 'Invia';
$survey_manageTypes['buttons']['submti'] = array('port','new');
$survey_manageTypes['sheet']->addSubmitButton($survey_manageTypes['buttons']['submit']);
?>
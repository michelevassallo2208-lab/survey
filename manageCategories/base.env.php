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

global $survey_manageCategories, $filter;

//ini_set('error_reporting', E_ALL);
//ini_set("display_errors", 1);

$location = Session::GetUser('location');
$locationMarketClause="";
if($location == 'aquila'){
	$locationMarketClause=" AND FIND_IN_SET('{$location}',locations)";
}

Template::ImportService('survey/manageCategories','filters');



class CloseFieldHandler extends FieldHandler {
	function showAsListValue() {
		global $survey_manageCategories;		
		$this->field->listCommand = 'doclose';
		echo($this->field->toListValue());
	}
}



$survey_manageCategories['id'] = isset($_GET['_id']) ? intval($_GET['_id']) : intval(@$_POST['_id']);
$survey_manageCategories['command'] = isset($_GET['_command']) ? $_GET['_command'] : @$_POST['_command'];

$survey_manageCategories['manager'] = new TableManager();
$survey_manageCategories['manager']->table = 'surveys.survey_categories';
$survey_manageCategories['manager']->folder = 'survey/manageCategories';



$survey_manageCategories['sheet'] = new Sheet('sheet');
$survey_manageCategories['sheet']->errorsForeword = 'Non e\' stato possibile inviare i dati. Si sono verificati i seguenti errori';
$survey_manageCategories['sheet']->cssClass = 'tblForm';
$survey_manageCategories['sheet']->notEmptyMarker = '*';
$survey_manageCategories['sheet']->key = 'id';





if (Session::UserHasOneOfProfilesIn('1,2,6')) {
	
	
	$survey_manageCategories['fields']['label'] = new TextField('label');
	$survey_manageCategories['fields']['label']->label = 'Nome';
	$survey_manageCategories['fields']['label']->addFlag(Field::NOT_EMPTY());
	$survey_manageCategories['sheet']->addField($survey_manageCategories['fields']['label']);
	
	$survey_manageCategories['fields']['job'] = new DropDownField('job');
	$survey_manageCategories['fields']['job']->label = 'Commessa';
	$survey_manageCategories['fields']['job']->options = 'H3G;Poste;Sogei;TeamSystem';
	if($location == 'aquila'){
		$survey_manageCategories['fields']['job']->options = 'H3G';
	}
	$survey_manageCategories['fields']['job']->usesNoSelection = true;
	$survey_manageCategories['fields']['job']->addFlag(Field::NOT_EMPTY());
	$survey_manageCategories['sheet']->addField($survey_manageCategories['fields']['job']);
	
	$survey_manageCategories['fields']['marketId'] = new DropDownField('marketId');
	$survey_manageCategories['fields']['marketId']->label = 'Mercato';
	$survey_manageCategories['fields']['marketId']->sourceSelect = "id, label AS _label";
	$survey_manageCategories['fields']['marketId']->sourceTable = 'centre_ccsud.users_market';
	$survey_manageCategories['fields']['marketId']->sourceKey = 'id';
	$survey_manageCategories['fields']['marketId']->sourceLabel = '_label';
	$survey_manageCategories['fields']['marketId']->sourceQueryTail ="{$locationMarketClause} AND enabled='true' ORDER BY _label";
	$survey_manageCategories['fields']['marketId']->usesNoSelection = true;
	$survey_manageCategories['fields']['marketId']->allowsMultipleSelection = true;
	$survey_manageCategories['fields']['marketId']->addFlag(Field::NOT_EMPTY());
	$survey_manageCategories['sheet']->addField($survey_manageCategories['fields']['marketId']);
	
	

	
	
}





if (@$survey_manageCategories['command']!='export' && Session::UserHasOneOfProfilesIn('1,2,6')) {
	$survey_manageCategories['commands']['modify'] = new Command('modify');
	$survey_manageCategories['commands']['modify']->imageAddress = GetImageAddress('icons/modify_22.png');
	$survey_manageCategories['commands']['modify']->address = Language::GetAddress($survey_manageCategories['manager']->folder.'/');
	$survey_manageCategories['commands']['modify']->tooltip = 'Modifica';
	$survey_manageCategories['sheet']->addCommand($survey_manageCategories['commands']['modify']);

/* 	$survey_manageCategories['commands']['delete'] = new Command('dodelete');
	$survey_manageCategories['commands']['delete']->imageAddress = GetImageAddress('delete.gif');
	$survey_manageCategories['commands']['delete']->address = Language::GetAddress($survey['manager']->folder.'/');
	$survey_manageCategories['commands']['delete']->onClick = "return confirm('Sicuro di voler cancellare l\\'elemento?')";
	$survey_manageCategories['commands']['delete']->tooltip = 'Elimina';
	$survey_manageCategories['sheet']->addCommand($survey['commands']['delete']);  */
}

$survey_manageCategories['buttons']['reset'] = new ResetButton('reset');
$survey_manageCategories['buttons']['reset']->text = 'Reset';
$survey_manageCategories['sheet']->addResetButton($survey_manageCategories['buttons']['reset']);

$survey_manageCategories['buttons']['submit'] = new SubmitButton('submit');
$survey_manageCategories['buttons']['submit']->text = 'Invia';
$survey_manageCategories['buttons']['submti'] = array('port','new');
$survey_manageCategories['sheet']->addSubmitButton($survey_manageCategories['buttons']['submit']);
?>
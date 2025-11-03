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

global $survey_manageQuestions, $filter;

// ini_set('error_reporting', E_ALL);
// ini_set("display_errors", 1);

Template::ImportService('survey/manageQuestions','filters');



class CloseFieldHandler extends FieldHandler {
	function showAsListValue() {
		global $survey_manageQuestions;		
		$this->field->listCommand = 'doclose';
		echo($this->field->toListValue());
	}
}

$location = Session::GetUser('location');



$survey_manageQuestions['id'] = isset($_GET['_id']) ? intval($_GET['_id']) : intval(@$_POST['_id']);
$survey_manageQuestions['command'] = isset($_GET['_command']) ? $_GET['_command'] : @$_POST['_command'];

$survey_manageQuestions['manager'] = new TableManager();
$survey_manageQuestions['manager']->table = 'surveys.survey_questions';
$survey_manageQuestions['manager']->folder = 'survey/manageQuestions';



$survey_manageQuestions['sheet'] = new Sheet('sheet');
$survey_manageQuestions['sheet']->errorsForeword = 'Non e\' stato possibile inviare i dati. Si sono verificati i seguenti errori';
$survey_manageQuestions['sheet']->cssClass = 'tblForm';
$survey_manageQuestions['sheet']->notEmptyMarker = '*';
$survey_manageQuestions['sheet']->key = 'id';



$sectorIncluded=array('list','modify','insertQuestion','duplicate','');
$sectorExcluded=array('modify');	
$onlyList=array('list','');


if (Session::UserHasOneOfProfilesIn('1,2,6') && in_array(@$survey_manageQuestions['command'],$sectorIncluded)) {
	
	
	if(!in_array(@$survey_manageQuestions['command'],$sectorExcluded)){
		$survey_manageQuestions['fields']['job'] = new DropDownField('job');
		$survey_manageQuestions['fields']['job']->label = 'Commessa';
		$survey_manageQuestions['fields']['job']->options = 'H3G;Poste;Sogei;TeamSystem';
		$survey_manageQuestions['fields']['job']->usesNoSelection = true;
		if($location == 'aquila'){
			$survey_manageQuestions['fields']['job']->options = 'H3G';
		}
		$survey_manageQuestions['fields']['job']->addFlag(Field::NOT_EMPTY());
		$survey_manageQuestions['sheet']->addField($survey_manageQuestions['fields']['job']);
		
		$survey_manageQuestions['fields']['marketId'] = new DropDownField('marketId');
		$survey_manageQuestions['fields']['marketId']->label = 'Mercato';
		$survey_manageQuestions['fields']['marketId']->sourceSelect = "id, label AS _label";
		$survey_manageQuestions['fields']['marketId']->sourceTable = 'centre_ccsud.users_market';
		$survey_manageQuestions['fields']['marketId']->sourceKey = 'id';
		$survey_manageQuestions['fields']['marketId']->sourceLabel = '_label';
		$survey_manageQuestions['fields']['marketId']->sourceQueryTail ="AND enabled='true' ORDER BY _label";
		$survey_manageQuestions['fields']['marketId']->usesNoSelection = true; 
		$survey_manageQuestions['fields']['marketId']->addFlag(Field::NOT_EMPTY());
		$survey_manageQuestions['sheet']->addField($survey_manageQuestions['fields']['marketId']);
		
		
		$survey_manageQuestions['fields']['categoryId'] = new DropDownField('categoryId');
		$survey_manageQuestions['fields']['categoryId']->label = 'Categoria';
		$survey_manageQuestions['fields']['categoryId']->sourceSelect = "id, label AS _label";
		$survey_manageQuestions['fields']['categoryId']->sourceTable = 'surveys.survey_categories';
		$survey_manageQuestions['fields']['categoryId']->sourceKey = 'id';
		$survey_manageQuestions['fields']['categoryId']->sourceLabel = '_label';
		$survey_manageQuestions['fields']['categoryId']->sourceQueryTail ="AND enabled='true' ORDER BY _label";
		$survey_manageQuestions['fields']['categoryId']->usesNoSelection = true;
		$survey_manageQuestions['fields']['categoryId']->addFlag(Field::NOT_EMPTY());
		$survey_manageQuestions['sheet']->addField($survey_manageQuestions['fields']['categoryId']);
	
	}
	
	
	
	
	

	$survey_manageQuestions['fields']['label'] = new TextField('label');
	$survey_manageQuestions['fields']['label']->label = 'Testo Domanda';
	$survey_manageQuestions['fields']['label']->rows = '10';
	$survey_manageQuestions['fields']['label']->addFlag(Field::NOT_EMPTY());
	$survey_manageQuestions['sheet']->addField($survey_manageQuestions['fields']['label']);
	
	
	$survey_manageQuestions['fields']['enabled'] = new DropDownField('enabled');
	$survey_manageQuestions['fields']['enabled']->label = 'Attiva';	
	$survey_manageQuestions['fields']['enabled']->value = 'true';
	$survey_manageQuestions['fields']['enabled']->options = 'true:Si;false:No';
	$survey_manageQuestions['fields']['enabled']->usesNoSelection = true;
	$survey_manageQuestions['fields']['enabled']->addFlag(Field::NOT_EMPTY());
	$survey_manageQuestions['sheet']->addField($survey_manageQuestions['fields']['enabled']);
	

	
	
	
}

if($survey_manageQuestions['command']=='addAnswer'){
	
	$idQuestion = $_GET['_id'];
	
	$survey_manageQuestions['fields']['questionId'] = new IntegerField('questionId');
	$survey_manageQuestions['fields']['questionId']->label = 'ID DOMANDA';
	$survey_manageQuestions['fields']['questionId']->value =  $idQuestion;
	$survey_manageQuestions['fields']['questionId']->addFlag(Field::NOT_EMPTY());
	$survey_manageQuestions['sheet']->addField($survey_manageQuestions['fields']['questionId']);
	
	for($i=1;$i<=3;$i++){
		
		$survey_manageQuestions['fields']['label'.$i] = new TextField('label'.$i);
		$survey_manageQuestions['fields']['label'.$i]->label = 'Testo Risposta_'.$i;
		$survey_manageQuestions['fields']['label'.$i]->rows = '10';
		$survey_manageQuestions['fields']['label'.$i]->addFlag(Field::NOT_EMPTY());
		$survey_manageQuestions['sheet']->addField($survey_manageQuestions['fields']['label'.$i]);
		
		$survey_manageQuestions['fields']['correct'.$i] = new DropDownField('correct'.$i);
		$survey_manageQuestions['fields']['correct'.$i]->label = 'Corretta';	
		$survey_manageQuestions['fields']['correct'.$i]->options = '1:Si;0:No';
		$survey_manageQuestions['fields']['correct'.$i]->value = '0';
		$survey_manageQuestions['fields']['correct'.$i]->usesNoSelection = true;
		$survey_manageQuestions['fields']['correct'.$i]->addFlag(Field::NOT_EMPTY());
		$survey_manageQuestions['sheet']->addField($survey_manageQuestions['fields']['correct'.$i]);
		
		
		
	}
	
	
}



if (@$survey_manageQuestions['command']!='export' && Session::UserHasOneOfProfilesIn('1,2,6')) {
	
	$survey_manageQuestions['commands']['addAnswer'] = new Command('addAnswer');
	$survey_manageQuestions['commands']['addAnswer']->imageAddress = GetImageAddress('icons/plus_22.png');
	$survey_manageQuestions['commands']['addAnswer']->address = Language::GetAddress($survey_manageQuestions['manager']->folder.'/');
	$survey_manageQuestions['commands']['addAnswer']->tooltip = 'Aggiungi Risposte';
	$survey_manageQuestions['sheet']->addCommand($survey_manageQuestions['commands']['addAnswer']);
	
	

	$survey_manageQuestions['commands']['duplicate'] = new Command('duplicate');
	$survey_manageQuestions['commands']['duplicate']->imageAddress = GetImageAddress('icons/duplicate_24.png');
	$survey_manageQuestions['commands']['duplicate']->address = Language::GetAddress($survey_manageQuestions['manager']->folder.'/');
	$survey_manageQuestions['commands']['duplicate']->tooltip = 'Duplica domanda';
	$survey_manageQuestions['sheet']->addCommand($survey_manageQuestions['commands']['duplicate']);	
	
	
	$survey_manageQuestions['commands']['modify'] = new Command('modify');
	$survey_manageQuestions['commands']['modify']->imageAddress = GetImageAddress('icons/modify_22.png');
	$survey_manageQuestions['commands']['modify']->address = Language::GetAddress($survey_manageQuestions['manager']->folder.'/');
	$survey_manageQuestions['commands']['modify']->tooltip = 'Modifica';
	$survey_manageQuestions['sheet']->addCommand($survey_manageQuestions['commands']['modify']);
	
	
	
	

/* 	$survey_manageQuestions['commands']['delete'] = new Command('dodelete');
	$survey_manageQuestions['commands']['delete']->imageAddress = GetImageAddress('delete.gif');
	$survey_manageQuestions['commands']['delete']->address = Language::GetAddress($survey['manager']->folder.'/');
	$survey_manageQuestions['commands']['delete']->onClick = "return confirm('Sicuro di voler cancellare l\\'elemento?')";
	$survey_manageQuestions['commands']['delete']->tooltip = 'Elimina';
	$survey_manageQuestions['sheet']->addCommand($survey['commands']['delete']);  */
}

$survey_manageQuestions['buttons']['reset'] = new ResetButton('reset');
$survey_manageQuestions['buttons']['reset']->text = 'Reset';
$survey_manageQuestions['sheet']->addResetButton($survey_manageQuestions['buttons']['reset']);

$survey_manageQuestions['buttons']['submit'] = new SubmitButton('submit');
$survey_manageQuestions['buttons']['submit']->text = 'Invia';
$survey_manageQuestions['buttons']['submti'] = array('port','new');
$survey_manageQuestions['sheet']->addSubmitButton($survey_manageQuestions['buttons']['submit']);
?>
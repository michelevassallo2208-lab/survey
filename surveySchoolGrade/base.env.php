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


global $surveySchoolGrade, $filter;


//ini_set('error_reporting', E_ALL);
//ini_set("display_errors", 1);

Template::ImportService('survey/surveySchoolGrade','filters');

$surveySchoolGrade['id'] = isset($_GET['_id']) ? intval($_GET['_id']) : intval(@$_POST['_id']);
$surveySchoolGrade['command'] = isset($_GET['_command']) ? $_GET['_command'] : @$_POST['_command'];

$surveySchoolGrade['manager'] = new TableManager();
$surveySchoolGrade['manager']->table = 'surveys.surveySchoolGrade';
$surveySchoolGrade['manager']->folder = 'survey/surveySchoolGrade';




$surveySchoolGrade['sheet'] = new Sheet('sheet');
$surveySchoolGrade['sheet']->errorsForeword = 'Non e\' stato possibile inviare i dati. Si sono verificati i seguenti errori';
$surveySchoolGrade['sheet']->cssClass = 'tblForm';
$surveySchoolGrade['sheet']->notEmptyMarker = '*';
$surveySchoolGrade['sheet']->key = 'id';

	/*Includo questi componenti nell'interfaccia insert*/
	$interfaceIncluded=array('insert','','list','modify');
	if (in_array(@$surveySchoolGrade['command'],$interfaceIncluded)){
		
		if(@$surveySchoolGrade['command']=='' || @$surveySchoolGrade['command']=='list'){
			$surveySchoolGrade['fields']['insertDt'] = new DateTimeField('insertDt');
			$surveySchoolGrade['fields']['insertDt']->label = 'Data/Ora inserimento';
			$surveySchoolGrade['sheet']->addField($surveySchoolGrade['fields']['insertDt']);
			
		}


		if(@$surveySchoolGrade['command']=='' || @$surveySchoolGrade['command']=='list' || @$surveySchoolGrade['command']=='modify'){
		
			$surveySchoolGrade['fields']['userId'] = new DropDownField('userId');
			$surveySchoolGrade['fields']['userId']->label = 'Operatore';
			
			if(isSuperUser())
				$surveySchoolGrade['fields']['userId']->sourceCursor = Database::ExecuteSelect("SELECT id, CONCAT(surname, ' ', name) AS _label FROM users ORDER BY _label");
			else
				$surveySchoolGrade['fields']['userId']->sourceCursor = Database::ExecuteSelect("SELECT id, CONCAT(surname, ' ', name) AS _label FROM users WHERE users.job = '".Session::GetUser('job')."'  AND id IN (SELECT userId FROM pivot_users_profiles WHERE (profileId IN ('2','3','1'))) ORDER BY _label");
			
			$surveySchoolGrade['fields']['userId']->usesNoSelection = true;
			$surveySchoolGrade['fields']['userId']->sourceKey = 'id';
			$surveySchoolGrade['fields']['userId']->sourceLabel = '_label';
			$surveySchoolGrade['sheet']->addField($surveySchoolGrade['fields']['userId']);
		}
		
		if(@$surveySchoolGrade['command']=='' || @$surveySchoolGrade['command']=='list'){
			
			// campi utente
			
		}	
		
		
		$surveySchoolGrade['fields']['firstQ'] = new DropDownField('firstQ');
		$surveySchoolGrade['fields']['firstQ']->label = 'Quale diploma hai conseguito?';
		$surveySchoolGrade['fields']['firstQ']->sourceCursor =Database::ExecuteSelect("SELECT id, label FROM surveys.surveySchoolGradeDiploma  ORDER BY label");
		$surveySchoolGrade['fields']['firstQ']->sourceKey = 'id';
		$surveySchoolGrade['fields']['firstQ']->sourceLabel = 'label';
		$surveySchoolGrade['fields']['firstQ']->addFlag(Field::NOT_EMPTY());
		$surveySchoolGrade['fields']['firstQ']->usesNoSelection = true;
		$surveySchoolGrade['sheet']->addField($surveySchoolGrade['fields']['firstQ']);


		$surveySchoolGrade['fields']['yesOrNo'] = new DropDownField('yesOrNo');
		$surveySchoolGrade['fields']['yesOrNo']->label = 'Hai conseguito la laurea?';
		$surveySchoolGrade['fields']['yesOrNo']->options = 'Si;No';
		$surveySchoolGrade['fields']['yesOrNo']->addFlag(Field::NOT_EMPTY());
		$surveySchoolGrade['fields']['yesOrNo']->usesNoSelection = true;
		$surveySchoolGrade['sheet']->addField($surveySchoolGrade['fields']['yesOrNo']);
		



		$surveySchoolGrade['fields']['secondQ'] = new DropDownField('secondQ');
		$surveySchoolGrade['fields']['secondQ']->label = 'Seleziona la laurea che hai conseguito';
		$surveySchoolGrade['fields']['secondQ']->sourceCursor =Database::ExecuteSelect("SELECT id, label FROM surveys.surveySchoolGradeUniversity ORDER BY label");
		$surveySchoolGrade['fields']['secondQ']->sourceKey = 'id';
		$surveySchoolGrade['fields']['secondQ']->sourceLabel = 'label';
		
		$surveySchoolGrade['fields']['secondQ']->usesNoSelection = true;
		$surveySchoolGrade['sheet']->addField($surveySchoolGrade['fields']['secondQ']);


		
	if (Session::UserHasOneOfProfilesIn('1,2,6')) {
	


		$surveySchoolGrade['commands']['delete'] = new Command('dodelete');
		$surveySchoolGrade['commands']['delete']->imageAddress = GetImageAddress('icons/delete_22.png');
		$surveySchoolGrade['commands']['delete']->address = Language::GetAddress($surveySchoolGrade['manager']->folder.'/');
		$surveySchoolGrade['commands']['delete']->onClick = "return confirm('Sicuro di voler cancellare l\\'elemento?')";
		$surveySchoolGrade['commands']['delete']->tooltip = 'Elimina';
		$surveySchoolGrade['sheet']->addCommand($surveySchoolGrade['commands']['delete']);
	
	}




	$surveySchoolGrade['buttons']['reset'] = new ResetButton('reset');
	$surveySchoolGrade['buttons']['reset']->text = 'Reset';
	$surveySchoolGrade['sheet']->addResetButton($surveySchoolGrade['buttons']['reset']);

	$surveySchoolGrade['buttons']['submit'] = new SubmitButton('submit');
	$surveySchoolGrade['buttons']['submit']->text = 'Invia';
	$surveySchoolGrade['sheet']->addSubmitButton($surveySchoolGrade['buttons']['submit']);


	}

?>
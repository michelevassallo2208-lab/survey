<?php
IncludeManager('table');
IncludeLib('datetimelib');
IncludeHandler('field');
IncludeField('text');
IncludeField('label');
IncludeField('check');
IncludeField('datetime');
IncludeField('dropdown');
IncludeField('integer');
IncludeField('radiolist');
IncludeCommand('command');
IncludeButton('submit');
IncludeButton('reset');

global $survey, $filter;

 //ini_set('error_reporting', E_ALL);
 //ini_set("display_errors", 1);

Template::ImportService('survey','filters');

$location = Session::GetUser('location');
$locationMarketClause="";
$locationUsersClause="";
if($location == 'aquila'){
	$locationMarketClause=" AND FIND_IN_SET('{$location}',locations)";	
	$locationUsersClause = " AND users.location = '{$location}'";
}


class InfoTotalsFieldHandler extends FieldHandler {
	function isVisible($record) {	
	
		$countCompleted = Database::ExecuteScalar("SELECT COUNT(*) FROM surveys.survey
								LEFT JOIN surveys.survey_pivot_ca ON survey_pivot_ca.idSurvey = survey.id
								WHERE idSurvey = {$record['id']}
								AND completed = 'true'");
								
		$countTotal = Database::ExecuteScalar("SELECT COUNT(*) FROM surveys.survey
								LEFT JOIN surveys.survey_pivot_ca ON survey_pivot_ca.idSurvey = survey.id
								WHERE idSurvey = {$record['id']}");
	
	
		
		if($countCompleted > 0){	
		
		$percentage = floor(($countCompleted/$countTotal)*100);
		echo "<span><b>".$countCompleted."/".$countTotal."</b></span>";

		?>
		
		<div class="progressBar" id="progressBar_<?=$record['id']?>" data-percent="<?=$percentage?>"><div></div></div>
		
		<?php
			
		}
		return true;
	}
}




$survey['id'] = isset($_GET['_id']) ? intval($_GET['_id']) : intval(@$_POST['_id']);
$survey['command'] = isset($_GET['_command']) ? $_GET['_command'] : @$_POST['_command'];

$survey['manager'] = new TableManager();
$survey['manager']->table = 'surveys.survey';
$survey['manager']->folder = 'survey';
//if (Session::UserHasOneOfProfilesIn('3')) {
	//$survey['manager']->addFilter('userId', Session::GetUser('id'));
//}


$survey['sheet'] = new Sheet('sheet');
$survey['sheet']->errorsForeword = 'Non e\' stato possibile inviare i dati. Si sono verificati i seguenti errori';
$survey['sheet']->cssClass = 'tblForm';
$survey['sheet']->notEmptyMarker = '*';
$survey['sheet']->key = 'id';

if (Session::UserHasOneOfProfilesIn('1,2,6') || (@$survey['command']=='list') || (@$survey['command']=='')) {
	/* $survey['fields']['momentDt'] = new DateTimeField('momentDt');
	$survey['fields']['momentDt']->label = 'Data e ora Inserimento';
	$survey['fields']['momentDt']->value = DateTimeLib::NowAsDateTime();
	$survey['fields']['momentDt']->addFlag(Field::NOT_EMPTY());
	$survey['sheet']->addField($survey['fields']['momentDt']); */
}





if (Session::UserHasOneOfProfilesIn('1,2,6') && ($survey['command']=='makeSurvey' || $survey['command']=='list' || $survey['command']=='' || $survey['command'] == 'modify')) {
	
	
	if($survey['command']=='list' || $survey['command']==''){
		$survey['fields']['creationDt'] = new DateField('creationDt');
		$survey['fields']['creationDt']->label = 'Data Creazione';
		$survey['sheet']->addField($survey['fields']['creationDt']);
	}
	
	
	$survey['fields']['typeId'] = new DropDownField('typeId');
	$survey['fields']['typeId']->label = 'Tipologia questionario';
	$survey['fields']['typeId']->sourceSelect = "id, label";
	$survey['fields']['typeId']->sourceTable = 'surveys.survey_types';
	$survey['fields']['typeId']->sourceKey = 'id';
	$survey['fields']['typeId']->sourceLabel = 'label';
	$survey['fields']['typeId']->sourceQueryTail =" AND viewable=1";
	// $survey['fields']['typeId']->usesNoSelection = true;
	$survey['fields']['typeId']->addFlag(Field::NOT_EMPTY());
	$survey['sheet']->addField($survey['fields']['typeId']);
	
	
	$survey['fields']['label'] = new TextField('label');
	$survey['fields']['label']->label = 'Nome';
	$survey['fields']['label']->addFlag(Field::NOT_EMPTY());
	$survey['sheet']->addField($survey['fields']['label']);
	
	$survey['fields']['job'] = new DropDownField('job');
	$survey['fields']['job']->label = 'Commessa';
	$survey['fields']['job']->options = 'H3G;Poste;Sogei;TeamSystem';
	if($location == 'aquila'){
		$survey['fields']['job']->options = 'H3G';
	}
	if($survey['command'] == 'insert') 
		$survey['fields']['job']->addFlag(Field::NOT_EMPTY());
	if($survey['command'] == 'modify')
		$survey['fields']['job']->visibility=Field::AS_VALUE();
	$survey['fields']['job']->usesNoSelection = true;
	// $survey['fields']['job']->addFlag(Field::NOT_EMPTY());
	$survey['sheet']->addField($survey['fields']['job']);
	
	$survey['fields']['marketId'] = new DropDownField('marketId');
	$survey['fields']['marketId']->label = 'Mercato';
	$survey['fields']['marketId']->sourceSelect = "id, label AS _label";
	$survey['fields']['marketId']->sourceTable = 'centre_ccsud.users_market';
	$survey['fields']['marketId']->sourceKey = 'id';
	$survey['fields']['marketId']->sourceLabel = '_label';
	$survey['fields']['marketId']->sourceQueryTail ="{$locationMarketClause} AND enabled='true' ORDER BY _label";
	$survey['fields']['marketId']->allowsMultipleSelection = true;
	$survey['fields']['marketId']->usesNoSelection = true;

	if($survey['command'] == 'insert') 
		$survey['fields']['marketId']->addFlag(Field::NOT_EMPTY());

	$survey['sheet']->addField($survey['fields']['marketId']);
	
	
	$survey['fields']['location'] = new DropDownField('location');
	$survey['fields']['location']->label = 'Location';
	$survey['fields']['location']->options = "battipaglia:Battipaglia;roma:Roma;aquila:L'Aquila;settingiano:Settingiano;sulmona:Sulmona";
	$survey['fields']['location']->usesNoSelection = true;
	if(Session::GetUser('location') == 'aquila'){
		$survey['fields']['location']->options = "aquila:L'Aquila";
		$survey['fields']['location']->value = 'aquila';
		$survey['fields']['location']->usesNoSelection = false;			
	} else if(Session::GetUser('location') == 'roma'){
		$survey['fields']['location']->options = "roma:Roma";
		$survey['fields']['location']->value = 'roma';
		$survey['fields']['location']->usesNoSelection = false;			
	} else if(Session::GetUser('location') == 'settingiano'){
		$survey['fields']['location']->options = "settingiano:Settingiano";
		$survey['fields']['location']->value = 'settingiano';
		$survey['fields']['location']->usesNoSelection = false;			
	}	
	if($survey['command'] == 'insert') 
		$survey['fields']['location']->addFlag(Field::NOT_EMPTY());
	if($survey['command'] == 'modify')
		$survey['fields']['location']->visibility=Field::AS_VALUE();
	$survey['sheet']->addField($survey['fields']['location']);
	
	
	$survey['fields']['startDate'] = new DateField('startDate');
	$survey['fields']['startDate']->label = 'Data inizio';
	if($survey['command'] == 'insert') 
		$survey['fields']['startDate']->addFlag(Field::NOT_EMPTY());
	if($survey['command'] == 'modify') 
		$survey['fields']['startDate']->visibility=Field::AS_VALUE();
	$survey['sheet']->addField($survey['fields']['startDate']);
	
	
	$survey['buttons']['reset'] = new ResetButton('reset');
	$survey['buttons']['reset']->text = 'Reset';
	$survey['sheet']->addResetButton($survey['buttons']['reset']);
	
	$survey['buttons']['submit'] = new SubmitButton('submit');
	$survey['buttons']['submit']->text = 'Invia';
	$survey['sheet']->addSubmitButton($survey['buttons']['submit']);
	
	
}


if($survey['command']=='allocateSurvey'){
	
	$surveyId = $_GET['surveyId'];
	
	if(empty($surveyId)){
		Header::JsRedirect(Language::GetAddress('survey/?_command=list'));
	}
	
	$surveyInfo = Database::ExecuteRecord("SELECT survey.job AS _surveyJob, survey.marketId AS _marketId
										FROM surveys.survey 
										WHERE survey.id = {$surveyId}");
										
	$survey['fields']['tlId'] = new DropDownField('tlId');
	$survey['fields']['tlId']->label = 'Team Leader';
	$survey['fields']['tlId']->sourceCursor = Database::ExecuteSelect("SELECT users.id,CONCAT(surname, ' ', name) AS _label 
																		FROM centre_ccsud.users
																		LEFT JOIN centre_ccsud.pivot_users_market AS pum ON pum.userId = users.id
																		WHERE 1=1 
																		AND pum.marketId = {$surveyInfo['_marketId']} 
																		AND users.job = '{$surveyInfo['_surveyJob']}' 
																		AND status='active' 
																		AND (location != 'satu') {$locationUsersClause}
																		AND users.id IN (SELECT userId FROM pivot_users_profiles WHERE profileId=2) AND users.id NOT IN (SELECT userId FROM pivot_users_profiles WHERE profileId IN ( 26, 32, 4, 5, 6, 7)) ORDER BY _label ASC ");
	$survey['fields']['tlId']->usesNoSelection = true;
	$survey['fields']['tlId']->sourceKey = 'id';
	$survey['fields']['tlId']->sourceLabel = '_label';
	$survey['sheet']->addField($survey['fields']['tlId']);
	
	
}


if ( $survey['command']=="allocateSurveySingle"){
	
	
	$surveyId = $_GET['surveyId'];
	
	if(empty($surveyId)){
		Header::JsRedirect(Language::GetAddress('survey/?_command=list'));
	}
	
	$surveyInfo = Database::ExecuteRecord("SELECT survey.job AS _surveyJob, survey.marketId AS _marketId
										FROM surveys.survey 
										WHERE survey.id = {$surveyId}");
	

	$survey['fields']['userId'] = new DropDownField('userId');
	$survey['fields']['userId']->label = 'Operatore';
	
																		
	$survey['fields']['userId']->sourceCursor = Database::ExecuteSelect("SELECT users.id, CONCAT(surname, ' ', name) AS _label 
																		FROM centre_ccsud.users 
																		WHERE 1=1 																		
																		AND users.job = '{$surveyInfo['_surveyJob']}' AND status='active' 
																		AND (location != 'satu') {$locationUsersClause} 
																		AND users.id IN (SELECT userId FROM pivot_users_profiles WHERE profileId IN (2,3)) 
																		AND users.id NOT IN (SELECT idCa FROM surveys.survey_pivot_ca WHERE idSurvey = {$surveyId})
																		ORDER BY _label ASC ");

	$survey['fields']['userId']->sourceKey = 'id';
	$survey['fields']['userId']->sourceLabel = '_label';																	
	$survey['fields']['userId']->usesNoSelection = true;
	$survey['fields']['userId']->addFlag(Field::NOT_EMPTY());
	$survey['sheet']->addField($survey['fields']['userId']);
		
		
		
		
	$survey['buttons']['reset'] = new ResetButton('reset');
	$survey['buttons']['reset']->text = 'Reset';
	$survey['sheet']->addResetButton($survey['buttons']['reset']);

	$survey['buttons']['submit'] = new SubmitButton('submit');
	$survey['buttons']['submit']->text = 'Invia';
	$survey['sheet']->addSubmitButton($survey['buttons']['submit']);
			
}

if ( $survey['command']=="allocateSurveySkill"){
	
	
	$surveyId = $_GET['surveyId'];
	
	if(empty($surveyId)){
		Header::JsRedirect(Language::GetAddress('survey/?_command=list'));
	}
	
	$surveyInfo = Database::ExecuteRecord("SELECT survey.job AS _surveyJob, survey.marketId AS _marketId
										FROM surveys.survey 
										WHERE survey.id = {$surveyId}");
	

	$survey['fields']['skillId'] = new DropDownField('skillId');
	$survey['fields']['skillId']->label = 'Skill';
	
																		
	$survey['fields']['skillId']->sourceCursor = Database::ExecuteSelect("SELECT activities.id, activities.label AS _label
																		FROM centre_ccsud.activities 
																		WHERE centre_ccsud.activities.id IN (57,75,96,59,110,116,113,97,41,91)");

	$survey['fields']['skillId']->sourceKey = 'id';
	$survey['fields']['skillId']->sourceLabel = '_label';																	
	$survey['fields']['skillId']->usesNoSelection = true;
	$survey['fields']['skillId']->addFlag(Field::NOT_EMPTY());
	$survey['sheet']->addField($survey['fields']['skillId']);

	$survey['fields']['location'] = new DropDownField('location');
	$survey['fields']['location']->label = 'Location';
	$survey['fields']['location']->options = "battipaglia:Battipaglia;roma:Roma;aquila:L'Aquila;settingiano:Settingiano";
	$survey['fields']['location']->usesNoSelection = true; 
	$survey['fields']['location']->addFlag(Field::NOT_EMPTY());
	$survey['sheet']->addField($survey['fields']['location']);
		
		
		
		
	$survey['buttons']['reset'] = new ResetButton('reset');
	$survey['buttons']['reset']->text = 'Reset';
	$survey['sheet']->addResetButton($survey['buttons']['reset']);

	$survey['buttons']['submit'] = new SubmitButton('submit');
	$survey['buttons']['submit']->text = 'Invia';
	$survey['sheet']->addSubmitButton($survey['buttons']['submit']);
			
}




if (@$survey['command']!='export' && Session::UserHasOneOfProfilesIn('1,2,6')) {
	
	$survey['commands']['infoField'] = new LabelField('infoField');
	$survey['commands']['infoField']->address = Language::GetAddress($survey['manager']->folder.'/');
	$survey['commands']['infoField']->tooltip = 'HL';
	$survey['commands']['infoField']->cssClass = 'commandInfo';
	$survey['commands']['infoField']->setHandler(new InfoTotalsFieldHandler());
	$survey['sheet']->addCommand($survey['commands']['infoField']);
	
	
	
	
	$survey['commands']['handle'] = new Command('handle');
	$survey['commands']['handle']->imageAddress = GetImageAddress('icons/mind_map_22.png');
	$survey['commands']['handle']->address = Language::GetAddress($survey['manager']->folder.'/');
	$survey['commands']['handle']->tooltip = 'Gestisci';
	$survey['commands']['handle']->cssClass = 'commandInfo';
	$survey['sheet']->addCommand($survey['commands']['handle']);
	
	$survey['commands']['modify'] = new Command('modify');
	$survey['commands']['modify']->imageAddress = GetImageAddress('icons/modify_22.png');
	$survey['commands']['modify']->address = Language::GetAddress($survey['manager']->folder.'/');
	$survey['commands']['modify']->tooltip = 'Modifica';
	$survey['sheet']->addCommand($survey['commands']['modify']);

/* 	$survey['commands']['delete'] = new Command('dodelete');
	$survey['commands']['delete']->imageAddress = GetImageAddress('delete.gif');
	$survey['commands']['delete']->address = Language::GetAddress($survey['manager']->folder.'/');
	$survey['commands']['delete']->onClick = "return confirm('Sicuro di voler cancellare l\\'elemento?')";
	$survey['commands']['delete']->tooltip = 'Elimina';
	$survey['sheet']->addCommand($survey['commands']['delete']);  */
}


?>
<?php
if (!isset($config)) require_once('../kernel.inc.php');

global $survey;

$survey['id'] = isset($_GET['_id']) ? intval($_GET['_id']) : intval(@$_POST['_id']);
$survey['command'] = isset($_GET['_command']) ? $_GET['_command'] : @$_POST['_command'];




if($survey['command']=='allocateSurveySingle' || $survey['command']=='insert' || $survey['command']=='allocateSurveySkill'){
	Template::SetTemplate('crm');
}else{
	
	if(Session::GetUser('job') == 'Poste'){
		Template::SetTemplate('basicP');
	}elseif(Session::GetUser('job') == 'H3G'){
		Template::SetTemplate('basic');
	}else if(Session::GetUser('job') == 'TeamSystem'){
		Template::SetTemplate('basic_generic_2024');
	
	}
	
	if(Session::GetUser('location') == 'aquila'){
		Template::SetTemplate('basic_c2c');
	}
	
	if(Session::GetUser('location') == 'roma'){
		Template::SetTemplate('basic_rm');
	}else if(Session::GetUser('location') == 'sulmona'){
        Template::SetTemplate('basic_SL');
    
}	
	
	if(Session::GetUser('location') == 'settingiano'){
		Template::SetTemplate('basic_cz');
	}	
	
}
Template::SetSectionTitle('Survey');
Template::GeneratePage();
?>
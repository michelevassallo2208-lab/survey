<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if (!isset($config)) require_once('../kernel.inc.php');

global $surveySchoolGrade;

$surveySchoolGrade['id'] = isset($_GET['_id']) ? intval($_GET['_id']) : intval(@$_POST['_id']);
$surveySchoolGrade['command'] = isset($_GET['_command']) ? $_GET['_command'] : @$_POST['_command'];







//Template::SetTemplate('crm');
if(Session::GetUser('job') == 'Poste'){
	if(Session::GetUser('location') == 'roma'){
		Template::SetTemplate('basic_rm');
	
	}else if(Session::GetUser('location') == 'settingiano'){
			Template::SetTemplate('basic_cz');
		
	}else if(Session::GetUser('location') == 'sulmona'){
		Template::SetTemplate('basic_SL');
	
}else{
		Template::SetTemplate('basicP');
	}


}else if(Session::GetUser('job') == 'TeamSystem'){
	Template::SetTemplate('basic_generic_2024');

}else if(Session::GetUser('job') == 'Sogei'){
	Template::SetTemplate('basic_rmSg');

}else if(Session::GetUser('job') == 'H3G'){
	if(Session::GetUser('location') == 'aquila'){
		Template::SetTemplate('basic_c2c');
	}else{

		Template::SetTemplate('basic');
	}
}





if(Session::UserHasOneOfProfilesIn('3') && $surveySchoolGrade['command'] != 'insert' && $surveySchoolGrade['command'] != 'debug')
	die('Accesso Non consentito');



Template::SetSectionTitle('Questionario');
Template::GeneratePage();
?>
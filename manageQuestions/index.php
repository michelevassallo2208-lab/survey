<?php
if (!isset($config)) require_once('../kernel.inc.php');

if(!Session::UserHasOneOfProfilesIn('1,4,6,32')){
	die("Sessione non abilitata al profilo corrente");
}

global $survey_manageQuestions;

$survey_manageQuestions['id'] = isset($_GET['_id']) ? intval($_GET['_id']) : intval(@$_POST['_id']);
$survey_manageQuestions['command'] = isset($_GET['_command']) ? $_GET['_command'] : @$_POST['_command'];


if(Session::GetUser('job') == 'Poste'){
        Template::SetTemplate('basicP');
}elseif(Session::GetUser('job') == 'H3G'){
        Template::SetTemplate('basic');
}elseif(Session::GetUser('job') == 'TeamSystem'){
        Template::SetTemplate('basic_generic_2024');
}

if(Session::GetUser('location') == 'aquila'){
	//Header::JsRedirect(Language::GetAddress('survey/?_command=list'));
	Template::SetTemplate('basic_c2c');
}


if(Session::GetUser('location') == 'roma'){	
	//Header::JsRedirect(Language::GetAddress('survey/?_command=list'));
	Template::SetTemplate('basic_rm');
}

if(Session::GetUser('location') == 'settingiano'){	
	Template::SetTemplate('basic_cz');
}

Template::SetSectionTitle('Survey - Gestione Domande/Risposte');
Template::GeneratePage();
?>
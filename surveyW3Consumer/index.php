<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if (!isset($config)) require_once('../kernel.inc.php');

global $surveyW3Consumer;

$surveyW3Consumer['id'] = isset($_GET['_id']) ? intval($_GET['_id']) : intval(@$_POST['_id']);
$surveyW3Consumer['command'] = isset($_GET['_command']) ? $_GET['_command'] : @$_POST['_command'];


Template::SetTemplate('basic');

if(Session::GetUser('job') == 'Poste')
	Template::SetTemplate('basicP');

if(Session::GetUser('location') == 'aquila')  {
	Template::SetTemplate('basic_c2c');	
} 

if(Session::UserHasOneOfProfilesIn('3') && $surveyW3Consumer['command'] != 'insert' && $surveyW3Consumer['command'] != 'debug')
	die('Accesso Non consentito');



Template::SetSectionTitle('Questionario L\'Aquila');
Template::GeneratePage();
?>
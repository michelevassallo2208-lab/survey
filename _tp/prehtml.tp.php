<?php

Session::PageWantsLogin();

IncludeObject('message');

global $survey;

Template::ImportService($survey['manager']->folder);

$survey['message'] = new Message();

switch (@$_GET['_msg']) {
	case 'inserted':	
		$survey['message']->setMessage('L\'inserimento dei dati e\' stato correttamente effettuato.', Message::TYPE_OK());
		break;
	case 'modified':
		$survey['message']->setMessage('L\'aggiornamento dei dati e\' stato correttamente effettuato.', Message::TYPE_OK());
		break;
	case 'deleted':
		$survey['message']->setMessage('La cancellazione dei dati e\' stata correttamente effettuata.', Message::TYPE_OK());
		break;	
	
	case 'warning':
		$survey['message']->setMessage('Richiesta gi&agrave; effettuta per l\'utente: impossibile effettuare la richiesta!', Message::TYPE_ERROR());
	break;		
		
	case 'closed':
		$survey['message']->setMessage('Record Chiuso.', Message::TYPE_OK());
		break;		
}

$topProfiles = '1,4,6,32';

switch (@$survey['command']) {
	case 'insert':
		Template::SetInterface('insert'); 
		break;		
		
	case 'modify':
		Template::SetInterface('modify'); 
		break;	
		
	case 'allocateSurvey':
		if(!Session::UserHasOneOfProfilesIn($topProfiles)){
			die("Funzionalità non abilitata al profilo corrente");
		}else
			Template::SetInterface('allocateSurvey'); 
		break;	
		
	case 'allocateSurveySingle':
		if(!Session::UserHasOneOfProfilesIn($topProfiles)){
			die("Funzionalità non abilitata al profilo corrente");
		}else
			Template::SetInterface('allocateSurveySingle'); 
		break;		

	case 'allocateSurveySkill':
		if(!Session::UserHasOneOfProfilesIn($topProfiles)){
			die("Funzionalità non abilitata al profilo corrente");
		}else
				Template::SetInterface('allocateSurveySkill');
		break;

	case 'configSurvey':
		if(!Session::UserHasOneOfProfilesIn($topProfiles)){
			die("Funzionalità non abilitata al profilo corrente");
		}else
			Template::SetInterface('configSurvey'); 
		break;	

	
	case 'makeSurvey':
		if(!Session::UserHasOneOfProfilesIn($topProfiles)){
			die("Funzionalità non abilitata al profilo corrente");
		}else
			Template::SetInterface('makeSurvey'); 
		break;

	case 'handle':
		if(!Session::UserHasOneOfProfilesIn($topProfiles)){
			die("Funzionalità non abilitata al profilo corrente");
		}else
			Template::SetInterface('handle'); 
		break;		
		
	case 'modify':
		if(!Session::UserHasOneOfProfilesIn($topProfiles)){
			die("Funzionalità non abilitata al profilo corrente");
		}else
			Template::SetInterface('modify'); 
		break;

	case 'doclose':	
		if(!Session::UserHasOneOfProfilesIn($topProfiles)){
			die("Funzionalità non abilitata al profilo corrente");
		}else
			Template::SetInterface('doclose'); 
		break;	
		
	case 'dodelete':
		if(!Session::UserHasOneOfProfilesIn($topProfiles)){
			die("Funzionalità non abilitata al profilo corrente");
		}else
			Template::SetInterface('dodelete'); 
		break;
	
	case 'export':
		if(!Session::UserHasOneOfProfilesIn($topProfiles)){
			die("Funzionalità non abilitata al profilo corrente");
		}else
			Template::IncludePart('export'); 
		break;	

	case 'exportQuestions':
		if(!Session::UserHasOneOfProfilesIn($topProfiles)){
			die("Funzionalità non abilitata al profilo corrente");
		}else
			Template::IncludePart('exportQuestions'); 
		break;		
		
		
		
		
	case 'detail':
		if(!Session::UserHasOneOfProfilesIn($topProfiles)){
			die("Funzionalità non abilitata al profilo corrente");
		}else
			Template::SetInterface('detail'); 
		break;		

	default:		
		Template::SetInterface('list'); 
		break;
}
?>
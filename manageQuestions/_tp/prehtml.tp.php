<?php

Session::PageWantsLogin();

IncludeObject('message');

global $survey_manageQuestions;

Template::ImportService($survey_manageQuestions['manager']->folder);

$survey_manageQuestions['message'] = new Message();

switch (@$_GET['_msg']) {
	case 'inserted':	
		$survey_manageQuestions['message']->setMessage('L\'inserimento dei dati e\' stato correttamente effettuato.', Message::TYPE_OK());
		break;
	case 'modified':
		$survey_manageQuestions['message']->setMessage('L\'aggiornamento dei dati e\' stato correttamente effettuato.', Message::TYPE_OK());
		break;
	case 'deleted':
		$survey_manageQuestions['message']->setMessage('La cancellazione dei dati e\' stata correttamente effettuata.', Message::TYPE_OK());
		break;	
	
	case 'warning':
		$survey_manageQuestions['message']->setMessage('Richiesta gi&agrave; effettuta per l\'utente: impossibile effettuare la richiesta!', Message::TYPE_ERROR());
	break;		
		
	case 'closed':
		$survey_manageQuestions['message']->setMessage('Record Chiuso.', Message::TYPE_OK());
		break;		
}

switch (@$survey_manageQuestions['command']) {
	case 'insert':
		Template::SetInterface('insert'); 
		break;		
		
	case 'duplicate':
		Template::SetInterface('duplicate'); 
		break;	
		
	case 'insertQuestion':
		Template::SetInterface('insertQuestion'); 
		break;	
		
	case 'addAnswer':
		Template::SetInterface('addAnswer'); 
		break;		
	
		
	case 'modify':
		Template::SetInterface('modify'); 
		break;

		case 'modifyAnswer':
			Template::SetInterface('modifyAnswer'); 
			break;	
		
	case 'dodelete':
		Template::SetInterface('dodelete'); 
		break;
	
	case 'export':
		Template::IncludePart('export'); 
		break;	

	case 'detail':
		Template::SetInterface('detail'); 
		break;		

	default:		
		Template::SetInterface('list'); 
		break;
}
?>
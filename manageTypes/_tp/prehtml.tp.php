<?php

Session::PageWantsLogin();

IncludeObject('message');

global $survey_manageTypes;

Template::ImportService($survey_manageTypes['manager']->folder);

$survey_manageTypes['message'] = new Message();

switch (@$_GET['_msg']) {
	case 'inserted':	
		$survey_manageTypes['message']->setMessage('L\'inserimento dei dati e\' stato correttamente effettuato.', Message::TYPE_OK());
		break;
	case 'modified':
		$survey_manageTypes['message']->setMessage('L\'aggiornamento dei dati e\' stato correttamente effettuato.', Message::TYPE_OK());
		break;
	case 'deleted':
		$survey_manageTypes['message']->setMessage('La cancellazione dei dati e\' stata correttamente effettuata.', Message::TYPE_OK());
		break;	
	
	case 'warning':
		$survey_manageTypes['message']->setMessage('Richiesta gi&agrave; effettuta per l\'utente: impossibile effettuare la richiesta!', Message::TYPE_ERROR());
	break;		
		
	case 'closed':
		$survey_manageTypes['message']->setMessage('Record Chiuso.', Message::TYPE_OK());
		break;		
}

switch (@$survey_manageTypes['command']) {
	case 'insert':
		Template::SetInterface('insert'); 
		break;		
		
	case 'insertType':
		Template::SetInterface('insertType'); 
		break;	
		
	
		
	case 'modify':
		Template::SetInterface('modify'); 
		break;
		
	

	case 'doclose':		
		Template::SetInterface('doclose'); 
		break;	
		
	case 'dodelete':
		Template::SetInterface('dodelete'); 
		break;


	case 'detail':
		Template::SetInterface('detail'); 
		break;		

	default:		
		Template::SetInterface('list'); 
		break;
}
?>
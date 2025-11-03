<?php

Session::PageWantsLogin();

IncludeObject('message');

global $survey_manageCategories;

Template::ImportService($survey_manageCategories['manager']->folder);

$survey_manageCategories['message'] = new Message();

switch (@$_GET['_msg']) {
	case 'inserted':	
		$survey_manageCategories['message']->setMessage('L\'inserimento dei dati e\' stato correttamente effettuato.', Message::TYPE_OK());
		break;
	case 'modified':
		$survey_manageCategories['message']->setMessage('L\'aggiornamento dei dati e\' stato correttamente effettuato.', Message::TYPE_OK());
		break;
	case 'deleted':
		$survey_manageCategories['message']->setMessage('La cancellazione dei dati e\' stata correttamente effettuata.', Message::TYPE_OK());
		break;	
	
	case 'warning':
		$survey_manageCategories['message']->setMessage('Richiesta gi&agrave; effettuta per l\'utente: impossibile effettuare la richiesta!', Message::TYPE_ERROR());
	break;		
		
	case 'closed':
		$survey_manageCategories['message']->setMessage('Record Chiuso.', Message::TYPE_OK());
		break;		
}

switch (@$survey_manageCategories['command']) {
	case 'insert':
		Template::SetInterface('insert'); 
		break;		
		
	case 'insertCategory':
		Template::SetInterface('insertCategory'); 
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
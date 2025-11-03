<?php
IncludeObject('message');

global $surveyW3Consumer;

Template::ImportService($surveyW3Consumer['manager']->folder);

$surveyW3Consumer['message'] = new Message();

switch (@$_GET['_msg']) {
	case 'inserted':	
		$surveyW3Consumer['message']->setMessage('L\'inserimento dei dati e\' stato correttamente effettuato.', Message::TYPE_OK());
		break;
	case 'modified':
		$surveyW3Consumer['message']->setMessage('L\'aggiornamento dei dati e\' stato correttamente effettuato.', Message::TYPE_OK());
		break;
	case 'deleted':
		$surveyW3Consumer['message']->setMessage('La cancellazione dei dati e\' stata correttamente effettuata.', Message::TYPE_OK());
		break;	
	
	case 'takeCharged':
		$surveyW3Consumer['message']->setMessage('La pratica e\' stata correttamente presa in carico.', Message::TYPE_OK());
		break;
	case 'takeNotCharged':
		$surveyW3Consumer['message']->setMessage('La pratica non e\' stata presa in carico.', Message::TYPE_WARNING());
		break;
}

switch (@$surveyW3Consumer['command']) {
	case 'insert':
		Template::SetInterface('insert'); 
		break;	
	
		
	case 'modify':
		Template::SetInterface('modify'); 
		break;
		
	case 'dodelete':
		Template::SetInterface('dodelete'); 
		break;

	case 'debug':
		Template::SetInterface('debug'); 
		break;

	case 'detail':
		Template::SetInterface('detail'); 
		break;	

	case 'exportXls':
		Template::includePart('exportXls'); 
		break;
		
	case 'list':
		Template::SetInterface('list'); 
		break;

	case 'actionvalidate':
		Template::SetInterface('actionvalidate'); 
	break;	

	default:		
		Template::SetInterface('list'); 
		break;
}
?>
<?php
IncludeObject('message');

global $surveyAquila;

Template::ImportService($surveyAquila['manager']->folder);

$surveyAquila['message'] = new Message();

switch (@$_GET['_msg']) {
	case 'inserted':	
		$surveyAquila['message']->setMessage('L\'inserimento dei dati e\' stato correttamente effettuato.', Message::TYPE_OK());
		break;
	case 'modified':
		$surveyAquila['message']->setMessage('L\'aggiornamento dei dati e\' stato correttamente effettuato.', Message::TYPE_OK());
		break;
	case 'deleted':
		$surveyAquila['message']->setMessage('La cancellazione dei dati e\' stata correttamente effettuata.', Message::TYPE_OK());
		break;	
	
	case 'takeCharged':
		$surveyAquila['message']->setMessage('La pratica e\' stata correttamente presa in carico.', Message::TYPE_OK());
		break;
	case 'takeNotCharged':
		$surveyAquila['message']->setMessage('La pratica non e\' stata presa in carico.', Message::TYPE_WARNING());
		break;
}

switch (@$surveyAquila['command']) {
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
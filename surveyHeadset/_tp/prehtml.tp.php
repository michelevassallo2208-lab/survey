<?php
IncludeObject('message');

global $surveyHeadset;

Template::ImportService($surveyHeadset['manager']->folder);

$surveyHeadset['message'] = new Message();

switch (@$_GET['_msg']) {
	case 'inserted':	
		$surveyHeadset['message']->setMessage('L\'inserimento dei dati e\' stato correttamente effettuato.', Message::TYPE_OK());
		break;
	case 'modified':
		$surveyHeadset['message']->setMessage('L\'aggiornamento dei dati e\' stato correttamente effettuato.', Message::TYPE_OK());
		break;
	case 'deleted':
		$surveyHeadset['message']->setMessage('La cancellazione dei dati e\' stata correttamente effettuata.', Message::TYPE_OK());
		break;	
	
	case 'takeCharged':
		$surveyHeadset['message']->setMessage('La pratica e\' stata correttamente presa in carico.', Message::TYPE_OK());
		break;
	case 'takeNotCharged':
		$surveyHeadset['message']->setMessage('La pratica non e\' stata presa in carico.', Message::TYPE_WARNING());
		break;
}

switch (@$surveyHeadset['command']) {
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
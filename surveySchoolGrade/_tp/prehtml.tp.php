<?php
IncludeObject('message');

global $surveySchoolGrade;

Template::ImportService($surveySchoolGrade['manager']->folder);

$surveySchoolGrade['message'] = new Message();

switch (@$_GET['_msg']) {
	case 'inserted':	
		$surveySchoolGrade['message']->setMessage('L\'inserimento dei dati e\' stato correttamente effettuato.', Message::TYPE_OK());
		break;
	case 'modified':
		$surveySchoolGrade['message']->setMessage('L\'aggiornamento dei dati e\' stato correttamente effettuato.', Message::TYPE_OK());
		break;
	case 'deleted':
		$surveySchoolGrade['message']->setMessage('La cancellazione dei dati e\' stata correttamente effettuata.', Message::TYPE_OK());
		break;	
	
	case 'takeCharged':
		$surveySchoolGrade['message']->setMessage('La pratica e\' stata correttamente presa in carico.', Message::TYPE_OK());
		break;
	case 'takeNotCharged':
		$surveySchoolGrade['message']->setMessage('La pratica non e\' stata presa in carico.', Message::TYPE_WARNING());
		break;
}

switch (@$surveySchoolGrade['command']) {
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
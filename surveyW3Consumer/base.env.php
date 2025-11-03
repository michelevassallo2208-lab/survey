<?php

Session::PageWantsLogin();

IncludeManager('table');
IncludeLib('datetimelib');
IncludeField('text');
IncludeField('email');
IncludeField('double');
IncludeField('check');
IncludeField('datetime');
IncludeField('time');
IncludeField('dropdown');
IncludeField('integer');
IncludeCommand('command');
IncludeButton('submit');
IncludeButton('reset');
IncludeHandler('field');
IncludeHandler('command');
IncludeField('file');


global $surveyW3Consumer, $filter;


//ini_set('error_reporting', E_ALL);
//ini_set("display_errors", 1);

Template::ImportService('survey/surveyW3Consumer','filters');

$surveyW3Consumer['id'] = isset($_GET['_id']) ? intval($_GET['_id']) : intval(@$_POST['_id']);
$surveyW3Consumer['command'] = isset($_GET['_command']) ? $_GET['_command'] : @$_POST['_command'];

$surveyW3Consumer['manager'] = new TableManager();
$surveyW3Consumer['manager']->table = 'surveys.surveyW3Consumer';
$surveyW3Consumer['manager']->folder = 'survey/surveyW3Consumer';




$surveyW3Consumer['sheet'] = new Sheet('sheet');
$surveyW3Consumer['sheet']->errorsForeword = 'Non e\' stato possibile inviare i dati. Si sono verificati i seguenti errori';
$surveyW3Consumer['sheet']->cssClass = 'tblForm';
$surveyW3Consumer['sheet']->notEmptyMarker = '*';
$surveyW3Consumer['sheet']->key = 'id';

	/*Includo questi componenti nell'interfaccia insert*/
	$interfaceIncluded=array('insert','','list','modify');
	if (in_array(@$surveyW3Consumer['command'],$interfaceIncluded)){
		
		if(@$surveyW3Consumer['command']=='' || @$surveyW3Consumer['command']=='list'){
			$surveyW3Consumer['fields']['insertDt'] = new DateTimeField('insertDt');
			$surveyW3Consumer['fields']['insertDt']->label = 'Data/Ora inserimento';
			$surveyW3Consumer['sheet']->addField($surveyW3Consumer['fields']['insertDt']);
			
		}


		if(@$surveyW3Consumer['command']=='' || @$surveyW3Consumer['command']=='list' || @$surveyW3Consumer['command']=='modify'){
		
			$surveyW3Consumer['fields']['userId'] = new DropDownField('userId');
			$surveyW3Consumer['fields']['userId']->label = 'Operatore';
			
			if(isSuperUser())
				$surveyW3Consumer['fields']['userId']->sourceCursor = Database::ExecuteSelect("SELECT id, CONCAT(surname, ' ', name) AS _label FROM users ORDER BY _label");
			else
				$surveyW3Consumer['fields']['userId']->sourceCursor = Database::ExecuteSelect("SELECT id, CONCAT(surname, ' ', name) AS _label FROM users WHERE users.job = '".Session::GetUser('job')."'  AND id IN (SELECT userId FROM pivot_users_profiles WHERE (profileId IN ('2','3','1'))) ORDER BY _label");
			
			$surveyW3Consumer['fields']['userId']->usesNoSelection = true;
			$surveyW3Consumer['fields']['userId']->sourceKey = 'id';
			$surveyW3Consumer['fields']['userId']->sourceLabel = '_label';
			$surveyW3Consumer['sheet']->addField($surveyW3Consumer['fields']['userId']);
		}
		
		if(@$surveyW3Consumer['command']=='' || @$surveyW3Consumer['command']=='list'){
			
			// campi utente
			
		}	
		
		
		$surveyW3Consumer['fields']['firstQ'] = new DropDownField('firstQ');
		$surveyW3Consumer['fields']['firstQ']->label = 'quanto ritieni fruibile l alberatura di Whit-U ?';
		$surveyW3Consumer['fields']['firstQ']->options = '1;2;3;4;5;6;7;8;9;10';
		$surveyW3Consumer['fields']['firstQ']->addFlag(Field::NOT_EMPTY());
		$surveyW3Consumer['fields']['firstQ']->usesNoSelection = true;
		$surveyW3Consumer['sheet']->addField($surveyW3Consumer['fields']['firstQ']);
		

		$surveyW3Consumer['fields']['secondQ'] = new TextField('secondQ');
		$surveyW3Consumer['fields']['secondQ']->label = 'se hai dato una valutazione inferiore a 6 motivalo di seguito e fornisci degli spunti di miglioramento';
		$surveyW3Consumer['fields']['secondQ']->addFlag(Field::NOT_EMPTY());
		$surveyW3Consumer['fields']['secondQ']->rows = 6;

		$surveyW3Consumer['sheet']->addField($surveyW3Consumer['fields']['secondQ']);
		
		$surveyW3Consumer['fields']['thirdQ'] = new DropDownField('thirdQ');
		$surveyW3Consumer['fields']['thirdQ']->label = 'ritieni completa ed efficace l organizzazione con gli attuali livelli dell alberatura ?';
		$surveyW3Consumer['fields']['thirdQ']->options ='1;2;3;4;5;6;7;8;9;10';
		$surveyW3Consumer['fields']['thirdQ']->addFlag(Field::NOT_EMPTY());
		$surveyW3Consumer['fields']['thirdQ']->usesNoSelection = true;
		$surveyW3Consumer['sheet']->addField($surveyW3Consumer['fields']['thirdQ']);
		


		$surveyW3Consumer['fields']['fourthQ'] = new TextField('fourthQ');
		$surveyW3Consumer['fields']['fourthQ']->label = 'se hai dato una valutazione inferiore a 6 motivalo di seguito e fornisci degli spunti di miglioramento';
		$surveyW3Consumer['fields']['fourthQ']->addFlag(Field::NOT_EMPTY());
		$surveyW3Consumer['fields']['fourthQ']->rows = 6;

		$surveyW3Consumer['sheet']->addField($surveyW3Consumer['fields']['fourthQ']);


			
		$surveyW3Consumer['fields']['fifthQ'] = new DropDownField('fifthQ');
		$surveyW3Consumer['fields']['fifthQ']->label = 'trovi i titoli dei rami dell alberatura intuitivi e parlanti?';
		$surveyW3Consumer['fields']['fifthQ']->options ='1;2;3;4;5;6;7;8;9;10';
		$surveyW3Consumer['fields']['fifthQ']->usesNoSelection = true;
		$surveyW3Consumer['fields']['fifthQ']->addFlag(Field::NOT_EMPTY());
		$surveyW3Consumer['sheet']->addField($surveyW3Consumer['fields']['fifthQ']);



		$surveyW3Consumer['fields']['sixtQ'] = new TextField('sixtQ');
		$surveyW3Consumer['fields']['sixtQ']->label = 'se hai dato una valutazione inferiore a 6 motivalo di seguito e fornisci degli spunti di miglioramento';
		$surveyW3Consumer['fields']['sixtQ']->addFlag(Field::NOT_EMPTY());
		$surveyW3Consumer['fields']['sixtQ']->rows = 6;

		$surveyW3Consumer['sheet']->addField($surveyW3Consumer['fields']['sixtQ']);
		

		$surveyW3Consumer['fields']['seventhQ'] = new TextField('seventhQ');
		$surveyW3Consumer['fields']['seventhQ']->label ='ci sono rami che vorresti rinominare?';
		$surveyW3Consumer['fields']['seventhQ']->addFlag(Field::NOT_EMPTY());
		$surveyW3Consumer['fields']['seventhQ']->rows = 6;

		$surveyW3Consumer['sheet']->addField($surveyW3Consumer['fields']['seventhQ']);

		$surveyW3Consumer['fields']['eightQ'] = new TextField('eightQ');
		$surveyW3Consumer['fields']['eightQ']->label ='ci sono rami che ritieni debbano essere posizionati diversamente?';
		$surveyW3Consumer['fields']['eightQ']->addFlag(Field::NOT_EMPTY());
		$surveyW3Consumer['fields']['eightQ']->rows = 6;

		$surveyW3Consumer['sheet']->addField($surveyW3Consumer['fields']['eightQ']);


		$surveyW3Consumer['fields']['nineQ'] = new TextField('nineQ');
		$surveyW3Consumer['fields']['nineQ']->label ='ci sono dei contenuti che secondo te dovrebbero essere posizionati diversamente? In un ramo differente oppure nuovo?';
		$surveyW3Consumer['fields']['nineQ']->addFlag(Field::NOT_EMPTY());
		$surveyW3Consumer['fields']['nineQ']->rows = 6;

		$surveyW3Consumer['sheet']->addField($surveyW3Consumer['fields']['nineQ']);



		$surveyW3Consumer['fields']['tenQ'] = new TextField('tenQ');
		$surveyW3Consumer['fields']['tenQ']->label ='cerchi le informazioni che ti servono in altri mercati di With U? Perche? Quali?';
		$surveyW3Consumer['fields']['tenQ']->addFlag(Field::NOT_EMPTY());
		$surveyW3Consumer['fields']['tenQ']->rows = 6;

		$surveyW3Consumer['sheet']->addField($surveyW3Consumer['fields']['tenQ']);


		$surveyW3Consumer['fields']['elevenQ'] = new TextField('elevenQ');
		$surveyW3Consumer['fields']['elevenQ']->label ='per la ricerca dei contenuti cosa utilizzi maggiormente, l alberatura o il motore di ricerca?';
		$surveyW3Consumer['fields']['elevenQ']->addFlag(Field::NOT_EMPTY());
		$surveyW3Consumer['fields']['elevenQ']->rows = 6;

		$surveyW3Consumer['sheet']->addField($surveyW3Consumer['fields']['elevenQ']);

		$surveyW3Consumer['fields']['twelveQ'] = new TextField('twelveQ');
		$surveyW3Consumer['fields']['twelveQ']->label ='cerchi le informazioni che ti servono sul sito ufficiale www.windtre.it?';
		$surveyW3Consumer['fields']['twelveQ']->addFlag(Field::NOT_EMPTY());
		$surveyW3Consumer['fields']['twelveQ']->rows = 6;
		$surveyW3Consumer['sheet']->addField($surveyW3Consumer['fields']['twelveQ']);



		$surveyW3Consumer['fields']['thirtenQ'] = new DropDownField('thirtenQ');
		$surveyW3Consumer['fields']['thirtenQ']->label = 'quanto sei soddisfatto complessivamente di come e organizzata l alberatura di WiTH U?';
		$surveyW3Consumer['fields']['thirtenQ']->options ='1;2;3;4;5;6;7;8;9;10';
		$surveyW3Consumer['fields']['thirtenQ']->usesNoSelection = true;
		$surveyW3Consumer['fields']['thirtenQ']->addFlag(Field::NOT_EMPTY());
		$surveyW3Consumer['sheet']->addField($surveyW3Consumer['fields']['thirtenQ']);



		$surveyW3Consumer['fields']['fourtenthQ'] = new TextField('fourtenthQ');
		$surveyW3Consumer['fields']['fourtenthQ']->label = 'se hai ulteriori suggerimenti indicali nel campo libero qui di seguito';
		$surveyW3Consumer['fields']['fourtenthQ']->rows = 6;
		$surveyW3Consumer['fields']['fourtenthQ']->addFlag(Field::NOT_EMPTY());
		$surveyW3Consumer['sheet']->addField($surveyW3Consumer['fields']['fourtenthQ']);
		
	}
	
		$surveyW3Consumer['commands']['modify'] = new Command('modify');
		$surveyW3Consumer['commands']['modify']->imageAddress = GetImageAddress('icons/modify_22.png');
		$surveyW3Consumer['commands']['modify']->address = Language::GetAddress($surveyW3Consumer['manager']->folder.'/');
		$surveyW3Consumer['commands']['modify']->tooltip = 'Modifica';
		$surveyW3Consumer['sheet']->addCommand($surveyW3Consumer['commands']['modify']);
		

	if (Session::UserHasOneOfProfilesIn('1,2,6')) {
	


		$surveyW3Consumer['commands']['delete'] = new Command('dodelete');
		$surveyW3Consumer['commands']['delete']->imageAddress = GetImageAddress('icons/delete_22.png');
		$surveyW3Consumer['commands']['delete']->address = Language::GetAddress($surveyW3Consumer['manager']->folder.'/');
		$surveyW3Consumer['commands']['delete']->onClick = "return confirm('Sicuro di voler cancellare l\\'elemento?')";
		$surveyW3Consumer['commands']['delete']->tooltip = 'Elimina';
		$surveyW3Consumer['sheet']->addCommand($surveyW3Consumer['commands']['delete']);
	
	}




	$surveyW3Consumer['buttons']['reset'] = new ResetButton('reset');
	$surveyW3Consumer['buttons']['reset']->text = 'Reset';
	$surveyW3Consumer['sheet']->addResetButton($surveyW3Consumer['buttons']['reset']);

	$surveyW3Consumer['buttons']['submit'] = new SubmitButton('submit');
	$surveyW3Consumer['buttons']['submit']->text = 'Invia';
	$surveyW3Consumer['sheet']->addSubmitButton($surveyW3Consumer['buttons']['submit']);




?>
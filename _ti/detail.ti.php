<?php 
global $survey;

	$id = $_GET['_id'];
	
	$classInfo = Database::ExecuteRecord("SELECT suggest_form_class.label AS _classLabel,DATE_FORMAT(suggest_form_class.momentDt,'%d-%m-%Y') AS _classMomentDt
											FROM  `suggest_form_class` 
											WHERE suggest_form_class.id =  '$id'");
	
	echo "<h2>".$classInfo['_classLabel']." ".$classInfo['_classMomentDt']."</h2>";
	
	
	$numberParticipants = Database::ExecuteScalar("SELECT COUNT(*) AS _totPart FROM suggest_form WHERE suggest_form.classId =  '$id'");

	echo "<h3>Numero Partecipanti: ".$numberParticipants."</h3>";
	$cur = Database::ExecuteQuery("SELECT CONCAT(users.name, ' ', users.surname) AS _username,suggest_form_class.label AS _classLabel,suggest_form_class.momentDt AS _classMomentDt
FROM  `suggest_form_class` 
INNER JOIN suggest_form ON suggest_form.classId = suggest_form_class.id

INNER JOIN users ON users.id = suggest_form.userId
WHERE suggest_form_class.id =  '$id'");
	
	
	echo "<table border=1><tr><th>Operatore</th><th>Gestione</th></tr>";
	
	while ( $record = Database::FetchRecord($cur) )
	{
		
		echo "<tr><td>".$record['_username']."</td><td> X </td></tr>";
		
	}
	
	echo "</table>";
	
	
	//print_r ($rec);
	//
	//
	//print_r ($recordSupport);
	
?>

<a class="tolist" href="<?=Language::GetAddress($survey['manager']->folder . '/')?>">Torna all'elenco</a>

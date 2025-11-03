<?php
//ini_set('error_reporting', E_ALL);
//ini_set("display_errors", 1);

$c=0;

$localToken = hash("sha256",Session::GetUser('id').$_GET['idSurvey']);	
$userId = Session::GetUser('id');
		if(isset($_POST['submit'])) {
			
			$outcomeCaId = Database::ExecuteInsert("INSERT INTO surveys.survey_outcome_ca (id, userId, surveyId, momentDt) VALUES (NULL, {$userId}, {$_GET['idSurvey']}, NOW())");
			unset($_POST['submit']);
			unset($_POST['token']);
			foreach($_POST AS $k=>$v){				
				Database::ExecuteInsert("INSERT INTO surveys.survey_outcome_answers (id, answerId, outcomeCaId) VALUES (NULL, {$v}, {$outcomeCaId})");
			}
			
			Database::ExecuteUpdate("UPDATE surveys.survey_pivot_ca SET endDtSurvey = NOW(), completed = 'true' WHERE token = '{$localToken}'");
			
			Javascript("window.close()");
			Javascript("window.opener.location.reload()");
		}else{ ?>		

<form name="sheet" id="sheet" method="post" action=" <?php echo $_SERVER['REQUEST_URI']; ?>" class="tblForm">
<input type="hidden" id="token" name="token" value="<?=$localToken?>">
<?php		              


$existQuestions = Database::ExecuteScalar("SELECT idQuestion FROM surveys.survey_pivot_questions WHERE idSurvey = {$_GET['idSurvey']} AND idCa = {$userId}");

if(!empty($existQuestions)){
		
		$queryQuestions = "SELECT survey_questions.id AS _id, survey_questions.label AS _label
	FROM surveys.survey_questions
	WHERE id IN ({$existQuestions})
	AND enabled =  'true'
	ORDER BY RAND( ) ";
	
	$curQuestions = Database::ExecuteQuery($queryQuestions);
	while($recordQuestions=Database::FetchRecord($curQuestions)){
		
				
		$queryAnswer = "SELECT survey_answers.id AS _id, survey_answers.label AS _label
					FROM  surveys.survey_answers 
					WHERE questionId = {$recordQuestions['_id']}
					AND enabled = 'true'
					ORDER BY RAND() ";
			echo "<h3>{$recordQuestions['_label']}</h3>";
		$curAnswer = Database::ExecuteQuery($queryAnswer);
	while($recordAnswer = Database::FetchRecord($curAnswer)){
		$c++;
		?>
			<input type="radio" id="<?=$recordQuestions['_id']."_".$c?>" name="<?=$recordQuestions['_id']?>" value="<?=$recordAnswer['_id']?>">
			<label for="<?=$recordQuestions['_id']."_".$c?>"><span><span></span></span><?=$recordAnswer['_label']?></label><br/>
		<?php
	}
	$c=0;
	echo "<br/>";
		
		
	}
	
	

}else{
	
$questions = array();



Database::ExecuteUpdate("UPDATE surveys.survey_pivot_ca SET startDtSurvey = NOW() WHERE token = '{$localToken}'");

$queryConfig = "SELECT idCategory, totalQuestions 
				FROM  surveys.survey_pivot_categories
				WHERE  idSurvey = {$_GET['idSurvey']}
				ORDER BY RAND( )
				";

$curConfig = Database::ExecuteQuery($queryConfig);

while($recordConfig=Database::FetchRecord($curConfig)){
	
	$queryQuestions = "SELECT survey_questions.id AS _id, survey_questions.label AS _label
	FROM surveys.survey_questions
	WHERE categoryId = {$recordConfig['idCategory']}
	AND enabled =  'true'
	ORDER BY RAND( ) 
	LIMIT {$recordConfig['totalQuestions']}";
	
	$curQuestions = Database::ExecuteQuery($queryQuestions);
	while($recordQuestions=Database::FetchRecord($curQuestions)){
		
		array_push($questions,$recordQuestions['_id']);
		
		$queryAnswer = "SELECT survey_answers.id AS _id, survey_answers.label AS _label
					FROM  surveys.survey_answers 
					WHERE questionId = {$recordQuestions['_id']}
					AND enabled =  'true'
					ORDER BY RAND() ";
			echo "<h3>{$recordQuestions['_label']}</h3>";
		$curAnswer = Database::ExecuteQuery($queryAnswer);
	while($recordAnswer = Database::FetchRecord($curAnswer)){
		$c++;
		?>
			<input type="radio" id="<?=$recordQuestions['_id']."_".$c?>" name="<?=$recordQuestions['_id']?>" value="<?=$recordAnswer['_id']?>">
			<label for="<?=$recordQuestions['_id']."_".$c?>"><span><span></span></span><?=$recordAnswer['_label']?></label><br/>
		<?php
	}
	$c=0;
	echo "<br/>";
		
		
	}
	
	
}
	$q = implode(',',$questions);
	
	Database::ExecuteInsert("INSERT IGNORE INTO surveys.survey_pivot_questions (idQuestion, idSurvey, idCa) VALUES ('{$q}',{$_GET['idSurvey']} , {$userId})");

}

?>
<button class="btn-sub" name="submit">Inserisci</button>
</form>
<?php } ?>

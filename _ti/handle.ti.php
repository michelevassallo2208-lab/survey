<?php 
global $survey;

$location = Session::GetUser('location');


$surveyId = $_GET['_id'];
if(empty($surveyId)){
	Header::JsRedirect(Language::GetAddress('survey/?_command=list'));
}

$surveyLabel = Database::ExecuteScalar("SELECT label FROM surveys.survey WHERE id = {$surveyId}");

echo "<h2>Gestione questionario {$surveyLabel}</h2>";

$onclick = "window.open('".Language::GetAddress($survey['manager']->folder.'/?_id='.$id.'&_command=allocateSurveySingle&surveyId='.$surveyId)."', 'opInsert', 'width=450,height=200,scrollbars=auto,resizable=yes')";
$onclick1 = "window.open('".Language::GetAddress($survey['manager']->folder.'/?_id='.$id.'&_command=allocateSurveySkill&surveyId='.$surveyId)."', 'opInsert', 'width=450,height=200,scrollbars=auto,resizable=yes')";

$exportOnClick = "window.location.href = '".Language::GetAddress($survey['manager']->folder.'/?_id='.$id.'&_command=export&_id='.$surveyId)."'";
?>

<div class='floatL'>
	<a href="<?=Language::GetAddress('survey/?_command=configSurvey&surveyId='.$surveyId)?>"><img src="<?=GetImageAddress('icons/settings_survey_100.png')?>" /><p>Configura Questionario</p></a>	
</div>

<div class='floatL'>
	<a href="<?=Language::GetAddress('survey/?_command=allocateSurvey&surveyId='.$surveyId)?>"><img src="<?=GetImageAddress('icons/associate_100.png')?>" /><p>Distribuisci a Team</p></a>	
</div>

<div class='floatL'>
	<a href="#" onclick="<?=$onclick?>"><img src="<?=GetImageAddress('icons/single_associate-100.png')?>" /><p>Associa a singolo ca</p></a>	
</div>

<div class='floatL'>
	<a href="#" onclick="<?=$onclick1?>"><img src="<?=GetImageAddress('icons/associate_100.png')?>" /><p>Distribuisci per Skill</p></a>	
</div>

<div class='floatL'>
	<a href="#" onclick="<?=$exportOnClick?>"><img src="<?=GetImageAddress('icons/excel_100.png')?>" /><p>Export questionario</p></a>	
</div>
<div class='clear'></div>



<br/><br/>

<?php 

$surveyInfo = Database::ExecuteRecord("SELECT survey.label AS _surveyName, users_market.label AS _marketName, DATE_FORMAT(startDate,'%d-%m-%Y') AS _startDate, survey.job AS _surveyJob, survey.marketId AS _marketId 
										FROM surveys.survey 
										LEFT JOIN centre_ccsud.users_market ON users_market.id = survey.marketId
										WHERE survey.id = {$surveyId}");
										
$topWrongQuestions = Database::ExecuteQuery("SELECT surveys.survey_questions.*, COUNT(survey_answers.id) as _wrongCount
												FROM surveys.survey 
												INNER JOIN surveys.survey_outcome_ca ON surveys.survey_outcome_ca.surveyId = surveys.survey.id
												LEFT JOIN surveys.survey_outcome_answers ON survey_outcome_answers.outcomeCaId = survey_outcome_ca.id
												LEFT JOIN surveys.survey_answers ON survey_answers.id = survey_outcome_answers.answerId
												LEFT JOIN surveys.survey_questions ON survey_questions.id = survey_answers.questionId
												WHERE survey.id = {$surveyId} AND surveys.survey_answers.correct = 0 
												GROUP BY questionId 
												ORDER BY COUNT(survey_answers.id) DESC
												limit 3");
$questionsArray = array();
$wrongTot = 0;

											
while($recordQuest = Database::FetchRecord($topWrongQuestions)) {
	$idx = $recordQuest['id'];
	$questionsArray[$idx]['_wrongCount'] = $recordQuest['_wrongCount'];
	$questionsArray[$idx]['label'] = $recordQuest['label'];	
	$wrongTot += $recordQuest['_wrongCount'];
	
}
												
if(!empty($wrongTot)){
	$topWrongCategoryCur = Database::ExecuteQuery("SELECT categoryId, survey_categories.label AS _cat, COUNT(survey_answers.id) AS _totWrong FROM surveys.`survey` 
													INNER JOIN surveys.survey_outcome_ca ON surveys.survey_outcome_ca.surveyId = surveys.survey.id
													LEFT JOIN surveys.survey_outcome_answers ON survey_outcome_answers.outcomeCaId = survey_outcome_ca.id
													LEFT JOIN surveys.survey_answers ON survey_answers.id = survey_outcome_answers.answerId
													LEFT JOIN surveys.survey_questions ON survey_questions.id = survey_answers.questionId
													LEFT JOIN surveys.`survey_categories` ON survey_categories.id = survey_questions.`categoryId`
													WHERE survey.id = {$surveyId} AND surveys.survey_answers.correct = 0
													GROUP BY categoryId 
													ORDER BY _totWrong DESC");
		
	$topWrongCategories = array();
	
	while($recordCat = Database::FetchRecord($topWrongCategoryCur)) {
		$array_index = $recordCat['categoryId'];
		$topWrongCategories[$array_index]['label'] = $recordCat['_cat'];
		$topWrongCategories[$array_index]['wrongCount'] = $recordCat['_totWrong'];
		
	}
	// echo $topWrongCategories[172]['label'];
	
	
	echo "<h2>Configurazione attuale</h2>
	<p>Mercato: {$surveyInfo['_marketName']}</p>
	<p>Commessa: {$surveyInfo['_surveyJob']}</p>
	<p>Data inizio: {$surveyInfo['_startDate']}</p><br>";
	
	
	echo "<h2>Statistiche questionario</h2>
	<p>Domanda/e sbagliata/e maggiormente: <ul>";
	
	foreach($questionsArray as $innerArray => $val) {
		$letterToPut = $questionsArray[$innerArray]['_wrongCount'] > 1 ? 'e' : 'a';
		
		echo "<li><b>\"{$questionsArray[$innerArray]['label']}</b>\", sbagliata {$questionsArray[$innerArray]['_wrongCount']} volt{$letterToPut}</li>";
		
		
	}
	
	?>
	</ul><br><br></b><p>Categoria/e con pi&ugrave; errori: <ul>
	
	<?php
	foreach($topWrongCategories as $innerValue => $key) 
		echo "<li>{$topWrongCategories[$innerValue]['label']} ({$topWrongCategories[$innerValue]['wrongCount']} errore/i)</li>";
	
}
echo '</ul><br><br>';

$totalCategories = Database::ExecuteScalar("SELECT SUM( totalQuestions ) 
												FROM  surveys.survey_pivot_categories
												WHERE idSurvey = {$surveyId}");


if($totalCategories > 0){
	echo "<h2>Domande configurate: {$totalCategories}</h2>";	
}



$totCa = Database::ExecuteScalar("SELECT COUNT(*) FROM surveys.survey_pivot_ca WHERE idSurvey = {$surveyId}");

if($totCa > 0){	
	echo "<h2>Ca associati: {$totCa}</h2>";
	
	
	
	if($location == 'aquila'){
		echo "<table class='tableList'><thead class='green'><tr><td>CA</td><td>TL</td><td>Data/ora</td><td>Stato</td><td>Durata</td><td>Rimuovi</td></tr></thead>";
	}else{
		echo "<table class='tableList'><thead class='green'><tr><td>CA</td><td>TL</td><td>Data/ora</td><td>Stato</td><td>Durata</td><td>Esito1</td><td>Rimuovi</td></tr></thead>";
	}
	
	
	$query = "SELECT survey_pivot_ca.id AS _id, usr.id AS _usrId, CONCAT( usr.surname,  ' ', usr.name ) AS _username, CONCAT( usrTl.surname,  ' ', usrTl.name ) AS _usernameTl,
	CASE WHEN survey_pivot_ca.completed = 'true' THEN 'Completo' ELSE 'Non Completo' END AS _status,
	CASE WHEN TIMEDIFF(survey_pivot_ca.endDtSurvey,survey_pivot_ca.startDtSurvey) IS  NOT NULL THEN TIMEDIFF(survey_pivot_ca.endDtSurvey,survey_pivot_ca.startDtSurvey) ELSE '' END AS _duration
				FROM surveys.survey_pivot_ca
				LEFT JOIN centre_ccsud.users AS usr ON usr.id = survey_pivot_ca.idCa
				LEFT JOIN centre_ccsud.users AS usrTl ON usrTl.id = usr.tlId
				WHERE idSurvey = {$surveyId}
				ORDER BY _usernameTl ASC, _username ASC";
	$curCa = Database::ExecuteQuery($query); 
	
	
	
	while($record=Database::FetchRecord($curCa)){
		
		?>
		<tr class='green'>
				<td><?=$record['_username']?></td>
				<td><?=$record['_usernameTl']?></td>
				<td><a href='#' id='momentDtSurvey_<?=$record['_id']?>' data-type='datetime' data-pk='<?=$record['_id']?>' class='editable editable-click'></a></td>
				<td><?=$record['_status']?></td>
				<td><?=$record['_duration']?></td>
				<td>
					<?php 					
						$queryOutcome= "SELECT COUNT( * ) AS _result, correct AS _outcome
											FROM  surveys.survey_outcome_ca
											LEFT JOIN surveys.survey_outcome_answers AS soa ON soa.outcomeCaId = survey_outcome_ca.id
											LEFT JOIN surveys.survey_answers AS sa ON sa.id = soa.answerId
											WHERE surveys.survey_outcome_ca.surveyId ={$surveyId}
											AND surveys.survey_outcome_ca.userId ={$record['_usrId']}
											GROUP BY correct
											ORDER BY correct DESC
											";
						$outcomeCur = Database::ExecuteQuery($queryOutcome);
						while($recordOutcome = Database::FetchRecord($outcomeCur)){
							if($location != 'aquila'){
								$recordOutcome['_outcome'] == '1' ? $imgSrc = GetImageAddress('icons/like_20.png') : $imgSrc = GetImageAddress('icons/dislike_20.png')?>
								<span><?=$recordOutcome['_result']?></span>
								<span><img class='vote' src="<?=$imgSrc?>"/></span>
							<?php }
							
							
						 } ?>	
				
				</td>
				<td class='tdrmv'>
					<?php if($record['_status'] == 'Non Completo'){?>
					<a href="#" name="<?=$record['_id']?>" id="<?=$record['_id']?>" onclick="if(confirm('Sicuro di voler cancellare l\'elemento?')) removeUserFromSurvey(<?=$record['_usrId']?>,<?=$surveyId?>)"> 
						<img class='rmvUsr' src="<?=GetImageAddress('icons/removeUser.png')?>"/>
					</a>
					<?php } ?>
				</td>
			</tr>		
		<?php 		
	}		
	echo "</table>";	
}
?>

<a style="margin-top:50px;" class="tolist" href="<?=Language::GetAddress($survey['manager']->folder . '/?_command=list')?>">Torna ai questionari</a>
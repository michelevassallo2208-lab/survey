<?php
global $survey;
#ini_set('error_reporting', E_ALL);
#ini_set("display_errors", 1);

$surveyId = $_GET['surveyId'];

if(empty($surveyId)){
	Header::JsRedirect(Language::GetAddress('survey/?_command=list'));
}


$surveyInfo = Database::ExecuteRecord("SELECT survey.label AS _surveyName, users_market.label AS _marketName, DATE_FORMAT(startDate,'%d-%m-%Y') AS _startDate, survey.job AS _surveyJob, survey.marketId AS _marketId 
										FROM surveys.survey 
										LEFT JOIN centre_ccsud.users_market ON users_market.id = survey.marketId
										WHERE survey.id = {$surveyId}");


echo "<h2>Distribuisci questionario {$surveyInfo['_surveyName']}</h2>
<p>Mercato: {$surveyInfo['_marketName']}</p>
<p>Commessa: {$surveyInfo['_surveyJob']}</p>
<p>Data inizio: {$surveyInfo['_startDate']}</p>";

$survey['sheet']->show();
?>
<input type="hidden" id="surveyId" name="surveyId" value="<?=$surveyId?>">
<input id="allocateSurvey" name="submit" type="submit" value="Associa" class="buttonGeneric">
<br/><br/><br/>
<?php

$totCa = Database::ExecuteScalar("SELECT COUNT(*) FROM surveys.survey_pivot_ca WHERE idSurvey = {$surveyId}");

if($totCa > 0){
	
	echo "<h2>Ca gi&agrave; associati: {$totCa}</h2>";
	echo "<table class='tableList'><thead class='green'><tr><td>CA</td><td>TL</td><td>Data/ora</td><td>Stato</td><td>Durata</td><td>Esito</td><td>Rimuovi</td></tr></thead>";
	
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
					<?
					
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
							$recordOutcome['_outcome'] == '1' ? $imgSrc = GetImageAddress('icons/like_20.png') : $imgSrc = GetImageAddress('icons/dislike_20.png')?>
							<span><?=$recordOutcome['_result']?></span>
							<span><img class='vote' src="<?=$imgSrc?>"/></span>
							
						<?php } ?>
				
				</td>
				<td class='tdrmv'>
					<?php if($record['_status'] == 'Non Completo'){?>
					<a href='#' name='<?=$record['_id']?>' id='<?=$record['_id']?>' onclick='removeUserFromSurvey(<?=$record['_usrId']?>,<?=$surveyId?>)'> 
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



<a class="tolist" href="<?=Language::GetAddress($survey['manager']->folder . '/?_command=handle&_id='.$surveyId)?>">Torna all'elenco</a>
<script type="text/javascript" language="javascript" src="/_js/jquery-ui.js"> </script>
<script src="/_js/jquery.ui.datepicker-it.js" language="javascript" type="text/javascript"></script>
<link href="/_css/jquery-ui.css" type="text/css" rel="stylesheet"></link>
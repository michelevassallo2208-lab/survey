<?php 

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=EsitiQuestionari.xls" );


include GetPath('portal/survey/_classes/Survey.class.php');
include GetPath('portal/survey/_classes/SurveyUser.class.php');
include GetPath('portal/survey/_classes/SurveyRepository.class.php');

global $survey, $filter;

if(Session::GetUser('location') == 'aquila'){
	Header::JsRedirect(Language::GetAddress('survey/?_command=list'));
	die;
}

$filter['sheet']->setAndCheck();



if ($filter['sheet']->isFiltered()) {
	if ($filter['sheet']->getFilterValue('creationDtFrom')!='') $survey['manager']->addWhereClause("DATE(surveys.survey.creationDt) >= '".$filter['sheet']->getFilterValue('creationDtFrom')."'");
	if ($filter['sheet']->getFilterValue('creationDtTo')!='') $survey['manager']->addWhereClause("DATE(surveys.survey.creationDt) <= '".$filter['sheet']->getFilterValue('creationDtTo')."'");	
	if ($filter['sheet']->getFilterValue('startDateFrom')!='') $survey['manager']->addWhereClause("DATE(surveys.survey.startDate) >= '".$filter['sheet']->getFilterValue('startDateFrom')."'");
	if ($filter['sheet']->getFilterValue('endDateTo')!='') $survey['manager']->addWhereClause("DATE(surveys.survey.startDate) <= '".$filter['sheet']->getFilterValue('endDateTo')."'");	
	if ($filter['sheet']->getFilterValue('job')!='') $survey['manager']->addWhereClause("surveys.survey.job = '".$filter['sheet']->getFilterValue('job')."'");
	if ($filter['sheet']->getFilterValue('marketId')>0) $survey['manager']->addWhereClause("surveys.survey.marketId = ".$filter['sheet']->getFilterValue('marketId'));
	if ($filter['sheet']->getFilterValue('id')>0) $survey['manager']->addWhereClause("surveys.survey.id = ".$filter['sheet']->getFilterValue('id'));
} 

if($survey['id'] > 0) { 		// significa che l'export è stato lanciato dal dettaglio di un questionario
	
	$survey['manager']->addWhereClause("survey.id = {$survey['id']}");
	$surveyObj = new Survey();
	$surveyRepo = new SurveyRepository();
	$surveyObj->id = $survey['id'];
	
	$wrongGroupedAnswers = $surveyRepo->getGroupedWrongAnswers($surveyObj);
	

}

if(Session::GetUser('location') == 'aquila'){
	$survey['manager']->addWhereClause("surveys.survey.location = 'aquila'");
}

// $recapArray = array(); 
// $totalErrors = 0;
// $summaryQuery = Database::ExecuteQuery("SELECT IF(_tlUsers.username IS NULL, 'n/a', _tlUsers.username) AS username, COUNT(survey_answers.id) AS _wrongCount
// 										FROM surveys.survey 
// 										INNER JOIN surveys.survey_outcome_ca ON surveys.survey_outcome_ca.surveyId = surveys.survey.id
// 										INNER JOIN users ON users.id = surveys.survey_outcome_ca.`userId`
// 										LEFT OUTER JOIN users _tlUsers ON _tlUsers.id = users.`tlId`
// 										LEFT JOIN surveys.survey_outcome_answers ON survey_outcome_answers.outcomeCaId = survey_outcome_ca.id
// 										LEFT JOIN surveys.survey_answers ON survey_answers.id = survey_outcome_answers.answerId
// 										LEFT JOIN surveys.survey_questions ON survey_questions.id = survey_answers.questionId
// 										WHERE survey.id = {$survey['id']} AND surveys.survey_answers.correct = 0
// 										GROUP BY _tlUsers.id
// 										ORDER BY COUNT(survey_answers.id) DESC");
// ?>		
<table border="1px">
<thead>
<tr>
	<th>TL</th>
	<th>Errori</th>
</tr>
<tbody>

					
<?php
$userObj = new SurveyUser();

foreach($wrongGroupedAnswers as $idx => $value) {
	$userObj->tlId = $idx;
	$tlUsername = $userObj->getTlUsername();
	
	echo "<td>{$tlUsername}</td><td>";
		
	
	foreach($value as $errors => $qty)
		echo "{$qty} opt {$errors} errore/i; ";
	
	echo '</td></tr>';
		
	
}

echo "</tr></tbody></table><br><br>";



$query = "SELECT 
DATE_FORMAT(survey_outcome_ca.momentDt,  '%d-%m-%Y %T') AS _date, 
survey.label AS _test,
 survey_questions.label AS _question, 
 survey_answers.label AS _answer, 
CASE (survey_answers.correct) WHEN  '1' THEN  'Corretta' ELSE  'Errata' END AS _outcome, 
CASE(survey_answers.correct) WHEN '1' THEN '#99cc33' ELSE '#FF0000' END AS _color,
CONCAT(users.surname, ' ', users.name) AS _username,
users.username as _caUsername,
users.location AS _location,
um.label AS _market,
CASE WHEN HR.companyId = 1 THEN 'CCSUD' 
       WHEN HR.companyId = 2 THEN 'INNOVATION' 
       WHEN HR.companyId = 3 THEN 'WORKFORCE'
       WHEN HR.companyId = 4 THEN 'FORMARE_FUTURO' 
       WHEN HR.companyId = 5 THEN 'ASTREA' 
       WHEN HR.companyId = 6 THEN 'C2c' 
       WHEN HR.companyId = 7 THEN 'CCNORD' 
       WHEN HR.companyId = 8 THEN 'RANDSTAND' 
	   ELSE 'altro' END AS _compagnia_id,
survey_categories.label AS _category,
CONCAT(_tlusers.surname, ' ', _tlusers.name) AS _tlUsername,
	SEC_TO_TIME(
    CASE 
        WHEN survey_pivot_ca.endDtSurvey IS NOT NULL AND survey_pivot_ca.startDtSurvey IS NOT NULL 
        THEN TIMESTAMPDIFF(SECOND, survey_pivot_ca.startDtSurvey, survey_pivot_ca.endDtSurvey)
        ELSE NULL
    END
) AS _duration,
( SELECT GROUP_CONCAT(DISTINCT surveys.survey_answers.label SEPARATOR '; ') FROM surveys.survey_answers WHERE survey_answers.questionId = survey_questions.id AND survey_answers.correct = 1 ) as _correctAnswer,
( SELECT GROUP_CONCAT(DISTINCT surveys.survey_answers.label SEPARATOR '; ') FROM surveys.survey_answers WHERE survey_answers.questionId = survey_questions.id ) as _possibleAnswers
FROM  surveys.survey_outcome_ca
LEFT JOIN centre_ccsud.users AS users ON users.id = surveys.survey_outcome_ca.userId
LEFT JOIN 
  humanresources.resources AS HR ON HR.userId = surveys.survey_outcome_ca.userId 
LEFT JOIN 
  humanresources.resources_companies ON resources_companies.id = HR.companyId
LEFT JOIN centre_ccsud.users AS _tlusers ON users.tlId = _tlusers.id
LEFT JOIN centre_ccsud.pivot_users_market AS pum ON pum.userId = users.id
LEFT JOIN centre_ccsud.users_market AS um ON pum.marketId = um.id
LEFT JOIN surveys.survey_pivot_ca ON survey_pivot_ca.idCa = users.id
LEFT JOIN surveys.survey ON survey.id = survey_outcome_ca.surveyId
LEFT JOIN surveys.survey_outcome_answers ON survey_outcome_answers.outcomeCaId = survey_outcome_ca.id
LEFT JOIN surveys.survey_answers ON survey_answers.id = survey_outcome_answers.answerId
LEFT JOIN surveys.survey_questions ON survey_questions.id = survey_answers.questionId
LEFT JOIN surveys.survey_categories ON survey_categories.id = survey_questions.categoryId
{$survey['manager']->getWhere()}
AND surveys.survey_pivot_ca.idSurvey = {$survey['id']}
";

 
$cur = Database::ExecuteQuery($query);
?>

<table border='1' cellpadding='2' cellspacing='0' align='right' style='border:1px solid #000000' width="100%">
		<tr>
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Test</th>
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Data</th>
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Categoria</th>
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Domanda</th>			
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Risposta data</th>
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Risposte possibili</th>
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Risposta/e corretta/e</th>
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Esito</th>
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Ca</th>
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Username</th>
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Durata questionario</th>			
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Location</th>
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Mercato</th>
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">TL</th>	
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Compagnia</th>		
		</tr>


<?php while ($record = Database::FetchRecord($cur)) { ?>
	<tr>
			<td><?=$record['_test']?></td>
			<td><?=$record['_date']?></td>
			<td><?=$record['_category']?></td>
			<td><?=$record['_question']?></td>
			<td><?=$record['_answer']?></td>
			<td><?=$record['_possibleAnswers']?></td>
			<td><?=$record['_correctAnswer']?></td>
			<td style="background-color:<?=$record['_color']?>;color:#FFFFFF;font-weight:bold;"><?=$record['_outcome']?></td>
			<td><?=$record['_username']?></td>
			<td><?=$record['_caUsername']?></td>
			<td><?=$record['_duration']?></td>
			<td><?=$record['_location']?></td>
			<td><?=$record['_market']?></td>			
			<td><?=$record['_tlUsername']?></td>
			<td><?=$record['_compagnia_id']?></td>

		</tr>			
	<?php } ?>
	</table>	
<?php die(); ?>	

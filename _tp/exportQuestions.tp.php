<?php 

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=EsitiBaseDomande.xls" );

global $survey, $filter;

//ini_set('display_errors','On');
//error_reporting(E_ALL);

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
	if ($filter['sheet']->getFilterValue('location')!='') $survey['manager']->addWhereClause("surveys.survey.location = '".$filter['sheet']->getFilterValue('location')."'");
}else{
	die("Selezionare almeno un filtro");
}

$surveysIds = Database::ExecuteCsv("SELECT id FROM surveys.survey {$survey['manager']->getWhere()}");
$questions = Database::ExecuteCsv("SELECT idQuestion FROM surveys.survey_pivot_questions WHERE idSurvey IN ({$surveysIds})");


$questions_array = explode(",",$questions);
$questions_array = array_unique($questions_array);
$questions_array = implode(",",$questions_array);


$queryResult = "SELECT survey_categories.label AS _cat,users_market.label AS _market,survey_questions.label AS _question,SUM(correct) AS _correct,SUM(CASE WHEN correct = 1 THEN 0 ELSE 1 END) AS _wrong
FROM surveys.survey_outcome_ca
LEFT JOIN surveys.survey_outcome_answers ON survey_outcome_answers.outcomeCaId = survey_outcome_ca.id
LEFT JOIN surveys.survey_answers ON survey_answers.id = survey_outcome_answers.answerId
LEFT JOIN surveys.survey_questions ON survey_questions.id = survey_answers.questionId
LEFT JOIN surveys.survey_categories ON survey_categories.id = survey_questions.categoryId
LEFT JOIN centre_ccsud.users_market ON users_market.id = survey_categories.marketId
WHERE surveyId IN({$surveysIds})
AND questionId IN ({$questions_array})
GROUP BY survey_questions.label
ORDER BY _cat ASC
";
// echo $questions_array;

$curResult = Database::ExecuteQuery($queryResult);
?>

<table border='1' cellpadding='2' cellspacing='0' align='right' style='border:1px solid #000000' width="100%">
	<tr>
		<th bgcolor="#66d8ff" style="color:#FFFFFF;">Categoria</th>
		<th bgcolor="#66d8ff" style="color:#FFFFFF;">Mercato</th>
		<th bgcolor="#66d8ff" style="color:#FFFFFF;">Domanda</th>
		<th bgcolor="#66d8ff" style="color:#FFFFFF;">Corrette</th>			
		<th bgcolor="#66d8ff" style="color:#FFFFFF;">Sbagliate </th>				
	</tr>


<?php


	while($recordResult = Database::FetchRecord($curResult)) { 
	?>
	<tr>
		<td><?=$recordResult['_cat']?></td>
		<td><?=$recordResult['_market']?></td>
		<td><?=$recordResult['_question']?></td>
		<td><?=$recordResult['_correct']?></td>
		<td><?=$recordResult['_wrong']?></td>			
	</tr>			
	<?php } ?>
</table>	
<?php die(); ?>

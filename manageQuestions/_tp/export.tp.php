<?php 

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=Domande.xls" );

global $survey_manageQuestions, $filter;



$filter['sheet']->setAndCheck();

$location = Session::GetUser('location');
$locationMarketClause="";
if($location == 'aquila'){
	$locationMarketClause=" AND FIND_IN_SET('{$location}',locations)";			
}



if ($filter['sheet']->isFiltered()) {
	if ($filter['sheet']->getFilterValue('label')!='') $survey_manageQuestions['manager']->addWhereClause("surveys.survey_questions.label LIKE '%".$filter['sheet']->getFilterValue('label')."%'");

	
	if ($filter['sheet']->getFilterValue('job')!='') $survey_manageQuestions['manager']->addWhereClause("surveys.survey_categories.job = '".$filter['sheet']->getFilterValue('job')."'");
	
	if ($filter['sheet']->getFilterValue('marketId')>0) $survey_manageQuestions['manager']->addWhereClause("surveys.survey_categories.marketId = '".$filter['sheet']->getFilterValue('marketId')."'");
	if ($filter['sheet']->getFilterValue('categoryId')>0) $survey_manageQuestions['manager']->addWhereClause("surveys.survey_questions.categoryId = '".$filter['sheet']->getFilterValue('categoryId')."'");
	if ($filter['sheet']->getFilterValue('enabled')!='') {		
		if($filter['sheet']->getFilterValue('enabled')=='Si'){
			$survey_manageQuestions['manager']->addWhereClause(" surveys.survey_questions.enabled = 'true'");
		}elseif($filter['sheet']->getFilterValue('enabled')=='No'){
			$survey_manageQuestions['manager']->addWhereClause(" surveys.survey_questions.enabled = 'false'");
		}		
	}	
} 

if($location == 'aquila'){
	$enabled_market_ids = Database::ExecuteCsv("SELECT DISTINCT(users_market.id) FROM surveys.survey_categories INNER JOIN centre_ccsud.users_market ON users_market.id = survey_categories.marketId WHERE 1 {$locationMarketClause}");
	$survey_manageQuestions['manager']->addWhereClause("surveys.survey_categories.marketId IN ({$enabled_market_ids})");	
}



$query = "SELECT 
survey_questions.label AS _question, 
survey_categories.job AS _job,
survey_categories.label AS _category,
centre_ccsud.users_market.label AS _market,
CASE survey_categories.enabled WHEN 'true' THEN 'Attiva' ELSE 'Disattiva' END AS _status 
FROM surveys.survey_questions
LEFT OUTER JOIN surveys.survey_categories ON surveys.survey_categories.id = surveys.survey_questions.categoryId
LEFT JOIN centre_ccsud.users_market ON centre_ccsud.users_market.id = surveys.survey_categories.marketId
{$survey_manageQuestions['manager']->getWhere()}";


$cur = Database::ExecuteSelect($query);
?>

<table border='1' cellpadding='2' cellspacing='0' align='right' style='border:1px solid #000000' width="100%">
		<tr>			
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Commessa</th>
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Mercato</th>		
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Categoria</th>
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Testo Domanda</th>
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Attiva</th>					
		</tr>


<?
	while ($record = Database::FetchRecord($cur)) { 
	?>
	<tr>
			
			<td><?=$record['_job']?></td>
			<td><?=$record['_market']?></td>
			<td><?=$record['_category']?></td>			
			<td><?=$record['_question']?></td>			
			<td><?=$record['_status']?></td>
		</tr>
			
	<?	} ?>

	</table>	
<?
die();

?>	

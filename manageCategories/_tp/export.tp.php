<?php 

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=Categorie.xls" );

global $survey_manageCategories, $filter;

$location = Session::GetUser('location');
$locationMarketClause="";
if($location == 'aquila'){
	$locationMarketClause=" AND FIND_IN_SET('{$location}',locations)";			
}



$filter['sheet']->setAndCheck();



if ($filter['sheet']->isFiltered()) {
	if ($filter['sheet']->getFilterValue('label')!='') $survey_manageCategories['manager']->addWhereClause("surveys.survey_categories.label LIKE '%".$filter['sheet']->getFilterValue('label')."%'");
	if ($filter['sheet']->getFilterValue('job')!='') $survey_manageCategories['manager']->addWhereClause("surveys.survey_categories.job = '".$filter['sheet']->getFilterValue('job')."'");	
	if ($filter['sheet']->getFilterValue('marketId')>0) $survey_manageCategories['manager']->addWhereClause("surveys.survey_categories.marketId = '".$filter['sheet']->getFilterValue('marketId')."'");

} 

if($location == 'aquila'){
	$categoriesIds = Database::ExecuteCsv("SELECT survey_categories.id FROM surveys.survey_categories INNER JOIN centre_ccsud.users_market ON users_market.id = survey_categories.marketId WHERE 1 {$locationMarketClause}");
	$survey_manageCategories['manager']->addWhereClause("surveys.survey_categories.id IN ({$categoriesIds})");
}

$query = "SELECT 
survey_categories.label AS _name, 
survey_categories.job AS _job,
centre_ccsud.users_market.label AS _market,
CASE survey_categories.enabled WHEN 'true' THEN 'Attiva' ELSE 'Disattiva' END AS _status 
FROM surveys.survey_categories
LEFT JOIN centre_ccsud.users_market ON centre_ccsud.users_market.id = surveys.survey_categories.marketId
{$survey_manageCategories['manager']->getWhere()}";


$cur = Database::ExecuteSelect($query);
?>

<table border='1' cellpadding='2' cellspacing='0' align='right' style='border:1px solid #000000' width="100%">
		<tr>
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Nome</th>
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Commessa</th>
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Mercato</th>		
			<th bgcolor="#66d8ff" style="color:#FFFFFF;">Stato</th>			
		</tr>


<?
	while ($record = Database::FetchRecord($cur)) { 
	?>
	<tr>
			<td><?=$record['_name']?></td>
			<td><?=$record['_job']?></td>
			<td><?=$record['_market']?></td>
			<td><?=$record['_status']?></td>
		</tr>
			
	<?	} ?>

	</table>	
<?
die();

?>	

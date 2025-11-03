<?php

include('../../../kernel.inc.php');

$location = Session::GetUser('location');
$locationMarketClause="";
if($location == 'aquila'){
	$locationMarketClause=" AND FIND_IN_SET('{$location}',locations)";
}

switch($_GET['qType']){
	case 'market':
		$job = $_GET['job'];
		$query = "SELECT id, label FROM centre_ccsud.users_market WHERE job='{$job}' {$locationMarketClause} AND enabled = 'true' ORDER BY label";
	break;
	
	
	case 'category':
		$marketId = $_GET['marketId'];
		$query = "SELECT id, label FROM surveys.survey_categories WHERE marketId = {$marketId} AND enabled = 'true' ORDER BY label";
	break;
		
	default:
		break;
	
}

$result = "<option value='0'>Seleziona una voce</option>";

$cur = Database::ExecuteQuery($query);
  
while($record = Database::FetchRecord($cur)){
	$result .= "<option value='{$record['id']}'>{$record['label']}</option>";
}

echo $result;

?>

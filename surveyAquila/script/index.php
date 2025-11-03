<?php

include('../../../kernel.inc.php');


switch($_GET['qType']){
	
	case 'getArea':
		$type = $_GET['val'];
		$query = "SELECT id, label FROM poste.disaster_areas WHERE typeId = '".$type."' AND enabled = 'true' ORDER BY label";
	break;
	
	case 'getSubArea':
		$area = $_GET['val'];
		$query = "SELECT id, label FROM poste.disaster_subareas WHERE areaId = '".$area."' AND enabled = 'true' ORDER BY label";
	break;
	

	
	default:
		break;
	
}

$result = "<option value='0'>Seleziona una voce</option>";

$cur = Database::ExecuteQuery($query);
  
  while($record = Database::FetchRecord($cur)){
   $result .= "<option value=\"$record[id]\">".$record['label']."</option>";
  }

echo $result;

?>

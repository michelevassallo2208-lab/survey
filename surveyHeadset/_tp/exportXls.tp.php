<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

global $surveyHeadset, $filter;

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=export_sondaggio_cuffie.xls");


if ($filter['sheet']->isFiltered()) {
    if ($filter['sheet']->getFilterValue('userId')>0) 				$surveyHeadset['manager']->addWhereClause("surveys.survey_gym.userId = ".$filter['sheet']->getFilterValue('userId')."");
	if ($filter['sheet']->getFilterValue('tlId')!='') 				$surveyHeadset['manager']->addWhereClause("centre_ccsud.users.tlId = '".$filter['sheet']->getFilterValue('tlId')."'");
}
$query = "	SELECT 
					surveys.survey_headset.*,
					CONCAT(_u.name,' ',_u.surname)  AS _opt
					

					FROM surveys.survey_headset
					LEFT JOIN centre_ccsud.users AS _u ON _u.id = surveys.survey_headset.userId
					".$surveyHeadset['manager']->getWhere();
		
					
	$cur = Database::ExecuteQuery($query); 
	?>
	<table border="1" class="list1">
			<thead>
				<tr>
					<th bgcolor="#f58142" style="color:#FFFFFF">Data inserimento</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Operatore</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Seriale Cuffie</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Seriale Adattatore</th>

				</tr>
			</thead>
	<?php while ($record = Database::FetchRecord($cur)) { ?>


			<tr>
				<td><?=DbToHr::DateTimeToDateTime($record['insertDt'])?></td>
				<td><?=$record['_opt']?></td>
				<td><?=$record['firstQ']?></td>
				<td><?=$record['secondQ']?></td>
			</tr>		
		<?php
		}

		?>
	</table>	
<?
die();
?>
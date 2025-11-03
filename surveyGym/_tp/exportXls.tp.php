<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

global $surveyGym, $filter;

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=export_sondaggio_palestra.xls");


if ($filter['sheet']->isFiltered()) {
    if ($filter['sheet']->getFilterValue('userId')>0) 				$surveyGym['manager']->addWhereClause("surveys.survey_gym.userId = ".$filter['sheet']->getFilterValue('userId')."");
	if ($filter['sheet']->getFilterValue('tlId')!='') 				$surveyGym['manager']->addWhereClause("centre_ccsud.users.tlId = '".$filter['sheet']->getFilterValue('tlId')."'");
	if ($filter['sheet']->getFilterValue('firstQ')!='') 				$surveyGym['manager']->addWhereClause("surveys.survey_gym.firstQ = \"".$filter['sheet']->getFilterValue('firstQ')."\"");
	if ($filter['sheet']->getFilterValue('secondQ')!='') 				$surveyGym['manager']->addWhereClause("surveys.survey_gym.secondQ = \"".$filter['sheet']->getFilterValue('secondQ')."\"");
}
$query = "	SELECT 
					surveys.survey_gym.*,
					CONCAT(_u.name,' ',_u.surname)  AS _opt
					

					FROM surveys.survey_gym
					LEFT JOIN centre_ccsud.users AS _u ON _u.id = surveys.survey_gym.userId
					".$surveyGym['manager']->getWhere();
		
					
	$cur = Database::ExecuteQuery($query); 
	?>
	<table border="1" class="list1">
			<thead>
				<tr>
					<th bgcolor="#f58142" style="color:#FFFFFF">Data inserimento</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Operatore</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Domanda 1</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Domanda 2</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Domanda 3</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Altro</th>

				</tr>
			</thead>
	<?php while ($record = Database::FetchRecord($cur)) { ?>


			<tr>
				<td><?=DbToHr::DateTimeToDateTime($record['insertDt'])?></td>
				<td><?=$record['_opt']?></td>
				<td><?=$record['firstQ']?></td>
				<td><?=$record['secondQ']?></td>
				<td><?=$record['thirdQ']?></td>
				<td><?=$record['other']?></td>

			</tr>		
		<?php
		}

		?>
	</table>	
<?
die();
?>
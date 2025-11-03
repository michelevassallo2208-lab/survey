<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

global $surveyLocker, $filter;

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=export_sondaggio_palestra.xls");


if ($filter['sheet']->isFiltered()) {
    if ($filter['sheet']->getFilterValue('userId')>0) 				$surveyLocker['manager']->addWhereClause("surveys.survey_locker.userId = ".$filter['sheet']->getFilterValue('userId')."");
	if ($filter['sheet']->getFilterValue('tlId')!='') 				$surveyLocker['manager']->addWhereClause("centre_ccsud.users.tlId = '".$filter['sheet']->getFilterValue('tlId')."'");
	if ($filter['sheet']->getFilterValue('firstQ')!='') 				$surveyLocker['manager']->addWhereClause("surveys.survey_locker.firstQ = \"".$filter['sheet']->getFilterValue('firstQ')."\"");
	if ($filter['sheet']->getFilterValue('secondQ')!='') 				$surveyLocker['manager']->addWhereClause("surveys.survey_locker.secondQ = \"".$filter['sheet']->getFilterValue('secondQ')."\"");
	if ($filter['sheet']->getFilterValue('thirdQ')!='') 				$surveyLocker['manager']->addWhereClause("surveys.survey_locker.thirdQ = \"".$filter['sheet']->getFilterValue('thirdQ')."\"");
}
$query = "	SELECT 
					surveys.survey_locker.*,
					CONCAT(_u.name,' ',_u.surname)  AS _opt
					

					FROM surveys.survey_locker
					LEFT JOIN centre_ccsud.users AS _u ON _u.id = surveys.survey_locker.userId
					".$surveyLocker['manager']->getWhere();
		
					
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
				

				</tr>
			</thead>
	<?php while ($record = Database::FetchRecord($cur)) { ?>


			<tr>
				<td><?=DbToHr::DateTimeToDateTime($record['insertDt'])?></td>
				<td><?=$record['_opt']?></td>
				<td><?=$record['firstQ']?></td>
				<td><?=$record['secondQ']?></td>
				<td><?=$record['thirdQ']?></td>
	

			</tr>		
		<?php
		}

		?>
	</table>	
<?
die();
?>
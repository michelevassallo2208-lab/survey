<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

global $surveyW3Consumer, $filter;

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=export_sondaggioW3Consumer.xls");


if ($filter['sheet']->isFiltered()) {
    if ($filter['sheet']->getFilterValue('userId')>0) 				$surveyW3Consumer['manager']->addWhereClause("surveys.survey_locker.userId = ".$filter['sheet']->getFilterValue('userId')."");
	if ($filter['sheet']->getFilterValue('tlId')!='') 				$surveyW3Consumer['manager']->addWhereClause("centre_ccsud.users.tlId = '".$filter['sheet']->getFilterValue('tlId')."'");

}
$query = "	SELECT 
					surveys.surveyW3Consumer.*,
					CONCAT(_u.name,' ',_u.surname)  AS _opt
					

					FROM surveys.surveyW3Consumer
					LEFT JOIN centre_ccsud.users AS _u ON _u.id = surveys.surveyW3Consumer.userId
					".$surveyW3Consumer['manager']->getWhere();
		
					
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
					<th bgcolor="#f58142" style="color:#FFFFFF">Domanda 4</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Domanda 5</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Domanda 6</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Domanda 7</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Domanda 8</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Domanda 9</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Domanda 10</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Domanda 11<</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Domanda 12</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Domanda 13</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Domanda 14</th>

					
				

				</tr>
			</thead>
	<?php while ($record = Database::FetchRecord($cur)) { ?>


			<tr>
				<td><?=DbToHr::DateTimeToDateTime($record['insertDt'])?></td>
				<td><?=$record['_opt']?></td>
				<td><?=$record['firstQ']?></td>
				<td><?=$record['secondQ']?></td>
				<td><?=$record['thirdQ']?></td>
				<td><?=$record['fourthQ']?></td>
				<td><?=$record['fifthQ']?></td>
				<td><?=$record['sixtQ']?></td>
				<td><?=$record['seventhQ']?></td>
				<td><?=$record['eightQ']?></td>
				<td><?=$record['nineQ']?></td>
				<td><?=$record['tenQ']?></td>
				<td><?=$record['elevenQ']?></td>
				<td><?=$record['twelveQ']?></td>
				<td><?=$record['thirtenQ']?></td>
				<td><?=$record['fourtenthQ']?></td>
			
			</tr>		
		<?php
		}

		?>
	</table>	
<?
die();
?>
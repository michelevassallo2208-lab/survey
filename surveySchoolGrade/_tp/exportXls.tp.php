<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

global $surveySchoolGrade, $filter;

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=export_sondaggio.xls");


if ($filter['sheet']->isFiltered()) {
    if ($filter['sheet']->getFilterValue('userId')>0) 				$surveySchoolGrade['manager']->addWhereClause("surveys.survey_locker.userId = ".$filter['sheet']->getFilterValue('userId')."");
	if ($filter['sheet']->getFilterValue('tlId')!='') 				$surveySchoolGrade['manager']->addWhereClause("centre_ccsud.users.tlId = '".$filter['sheet']->getFilterValue('tlId')."'");

}
$query = "	SELECT 
					surveys.surveySchoolGrade.*,
					CONCAT(_u.surname,' ',_u.name)  AS _opt,
d.label AS Diploma,
un.label AS University
					

					FROM surveys.surveySchoolGrade
					LEFT JOIN centre_ccsud.users AS _u ON _u.id = surveys.surveySchoolGrade.userId
					LEFT JOIN surveys.surveySchoolGradeDiploma AS d ON d.id = surveys.surveySchoolGrade.firstQ
						LEFT JOIN surveys.surveySchoolGradeUniversity AS un ON un.id = surveys.surveySchoolGrade.secondQ
					".$surveySchoolGrade['manager']->getWhere();
		
					
	$cur = Database::ExecuteQuery($query); 
	?>
	<table border="1" class="list1">
			<thead>
				<tr>
					<th bgcolor="#f58142" style="color:#FFFFFF">Data inserimento</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Operatore</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Domanda 1</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Domanda 2</th>
				

					
				

				</tr>
			</thead>
	<?php while ($record = Database::FetchRecord($cur)) { ?>


			<tr>
				<td><?=DbToHr::DateTimeToDateTime($record['insertDt'])?></td>
				<td><?=$record['_opt']?></td>
				<td><?=$record['Diploma']?></td>
				<td><?=$record['University']?></td>

			
			</tr>		
		<?php
		}

		?>
	</table>	
<?
die();
?>
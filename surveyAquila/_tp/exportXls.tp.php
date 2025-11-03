<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

global $surveyAquila, $filter;

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=export_questionario_accessi_aq.xls");


if ($filter['sheet']->isFiltered()) {
    if ($filter['sheet']->getFilterValue('userId')>0) 				$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.userId = ".$filter['sheet']->getFilterValue('userId')."");
	if ($filter['sheet']->getFilterValue('tlId')!='') 				$surveyAquila['manager']->addWhereClause("centre_ccsud.users.tlId = '".$filter['sheet']->getFilterValue('tlId')."'");
	if ($filter['sheet']->getFilterValue('login')!='') 				$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.login = '".$filter['sheet']->getFilterValue('login')."'");
	if ($filter['sheet']->getFilterValue('withU')!='') 				$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.withU = '".$filter['sheet']->getFilterValue('withU')."'");
	if ($filter['sheet']->getFilterValue('pplSoft')!='') 			$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.pplSoft = '".$filter['sheet']->getFilterValue('pplSoft')."'");
	if ($filter['sheet']->getFilterValue('uadOmRimb')!='') 			$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.uadOmRimb = '".$filter['sheet']->getFilterValue('uadOmRimb')."'");
	if ($filter['sheet']->getFilterValue('dss')!='') 				$surveyAquila['manager']->addWhereClause("DATE(surveys.survey_access_aquila.dss) >= '".$filter['sheet']->getFilterValue('dss')."'");
	if ($filter['sheet']->getFilterValue('dokCrm')!='') 			$surveyAquila['manager']->addWhereClause("DATE(surveys.survey_access_aquila.dokCrm) <= '".$filter['sheet']->getFilterValue('dokCrm')."'");
	if ($filter['sheet']->getFilterValue('irma')!='') 				$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.irma = '".$filter['sheet']->getFilterValue('irma')."'");
	if ($filter['sheet']->getFilterValue('dbAuto')!='') 			$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.dbAuto = '".$filter['sheet']->getFilterValue('dbAuto')."'");
	if ($filter['sheet']->getFilterValue('mPay')!='') 				$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.mPay = '".$filter['sheet']->getFilterValue('mPay')."'");
	if ($filter['sheet']->getFilterValue('oneShot')!='') 			$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.oneShot = '".$filter['sheet']->getFilterValue('oneShot')."'");
	if ($filter['sheet']->getFilterValue('ricaricaEasy')!='') 		$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.ricaricaEasy = '".$filter['sheet']->getFilterValue('ricaricaEasy')."'");
	if ($filter['sheet']->getFilterValue('thd')!='') 				$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.thd = '".$filter['sheet']->getFilterValue('thd')."'");
	if ($filter['sheet']->getFilterValue('cora')!='') 				$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.cora = '".$filter['sheet']->getFilterValue('cora')."'");
	if ($filter['sheet']->getFilterValue('threeSat')!='') 			$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.threeSat = '".$filter['sheet']->getFilterValue('threeSat')."'");
	if ($filter['sheet']->getFilterValue('ccmMail')!='') 			$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.ccmMail = '".$filter['sheet']->getFilterValue('ccmMail')."'");
	if ($filter['sheet']->getFilterValue('gc3')!='') 				$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.gc3 = '".$filter['sheet']->getFilterValue('gc3')."'");
	if ($filter['sheet']->getFilterValue('wellDone')!='') 			$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.wellDone = '".$filter['sheet']->getFilterValue('wellDone')."'");
	if ($filter['sheet']->getFilterValue('easyCimOutbound')!='') 	$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.easyCimOutbound = '".$filter['sheet']->getFilterValue('easyCimOutbound')."'");
	if ($filter['sheet']->getFilterValue('genesysBar')!='') 		$surveyAquila['manager']->addWhereClause("surveys.survey_access_aquila.genesysBar = '".$filter['sheet']->getFilterValue('genesysBar')."'");
}
$query = "	SELECT 
					surveys.survey_access_aquila.*,
					CONCAT(_u.name,' ',_u.surname)  AS _opt
					

					FROM surveys.survey_access_aquila
					LEFT JOIN centre_ccsud.users AS _u ON _u.id = surveys.survey_access_aquila.userId
					".$surveyAquila['manager']->getWhere();
		
					
	$cur = Database::ExecuteQuery($query); 
	?>
	<table border="1" class="list1">
			<thead>
				<tr>
					<th bgcolor="#f58142" style="color:#FFFFFF">Data inserimento</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Operatore</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Login</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Token</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">With U</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Peoplesoft</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">UAD+Omaggi e rimborsi</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">DSS</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">DokCRM</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">DMS OT</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">IRMA</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">DB AUTO</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">M Pay</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">One Shot</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Cruscotto Ricarica Facile</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">THD</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">CO.Ra</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">3SAT</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Casistiche CCM+sez mail</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Tool GC3</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">E-learning WellDone</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">EasyCIM Outbound</th>
					<th bgcolor="#f58142" style="color:#FFFFFF">Barra Genesys</th>
				</tr>
			</thead>
	<?php while ($record = Database::FetchRecord($cur)) { ?>


			<tr>
				<td><?=DbToHr::DateTimeToDateTime($record['insertDt'])?></td>
				<td><?=$record['_opt']?></td>
				<td><?=$record['login']?></td>
				<td><?=$record['token']?></td>
				<td><?=subLabel($record['withU'])?></td>
				<td><?=subLabel($record['pplSoft'])?></td>		
				<td><?=subLabel($record['uadOmRimb'])?></td>	
				<td><?=subLabel($record['dss'])?></td>
				<td><?=subLabel($record['dokCrm'])?></td>
				<td><?=subLabel($record['dmsOt'])?></td>
				<td><?=subLabel($record['irma'])?></td>
				<td><?=subLabel($record['dbAuto'])?></td>
				<td><?=subLabel($record['mPay'])?></td>
				<td><?=subLabel($record['oneShot'])?></td>
				<td><?=subLabel($record['ricaricaEasy'])?></td>
				<td><?=subLabel($record['thd'])?></td>
				<td><?=subLabel($record['cora'])?></td>
				<td><?=subLabel($record['threeSat'])?></td>
				<td><?=subLabel($record['ccmMail'])?></td>
				<td><?=subLabel($record['gc3'])?></td>
				<td><?=subLabel($record['wellDone'])?></td>
				<td><?=subLabel($record['easyCimOutbound'])?></td>
				<td><?=subLabel($record['genesysBar'])?></td>
			</tr>		
		<?php
		}
function subLabel($label) {
	if($label == -1) 
		return "No";
	else 
		return "Si";
	
}
		?>
	</table>	
<?
die();
?>
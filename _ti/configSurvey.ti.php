<?
ini_set('error_reporting', E_ALL);
ini_set("display_errors", 1);
global $survey;

$surveyId = $_GET['surveyId'];


if(empty($surveyId)){
	Header::JsRedirect(Language::GetAddress('survey/?_command=list'));
}

$surveyInfo = Database::ExecuteRecord("SELECT 
survey.label AS _surveyName, 
users_market.label AS _marketName,
DATE_FORMAT(startDate, '%d-%m-%Y') AS _startDate, 
survey.job AS _surveyJob, 
survey.marketId AS _marketId
FROM 
surveys.survey
LEFT JOIN 
centre_ccsud.users_market 
ON FIND_IN_SET(users_market.id, survey.marketId) > 0
										WHERE survey.id = {$surveyId}");

echo "<h2>Configura questionario {$surveyInfo['_surveyName']}</h2>
<p>Mercato: {$surveyInfo['_marketName']}</p>
<p>Commessa: {$surveyInfo['_surveyJob']}</p>
<p>Data inizio: {$surveyInfo['_startDate']}</p>";


$totalCategories = Database::ExecuteScalar("SELECT SUM( totalQuestions ) 
												FROM  surveys.survey_pivot_categories
												WHERE idSurvey = {$surveyId}");


if($totalCategories > 0){
	
	echo "<h2>Domande gi&agrave; configurate per il questionario: {$totalCategories}</h2>";
	
	$curCategories = Database::ExecuteQuery("SELECT survey_pivot_categories.id AS _id, surveys.survey_categories.label AS _labelCat, SUM( totalQuestions ) AS _totQuest 
											FROM  surveys.survey_pivot_categories
											LEFT JOIN surveys.survey_categories ON survey_categories.id = surveys.survey_pivot_categories.idCategory
											WHERE idSurvey = {$surveyId}
											GROUP BY survey_categories.label");
	
	
		
	echo "<table class='tableList'><thead class='green'><tr><td>Categoria</td><td>Totale Domande</td></tr></thead>";
	
	
	
	while($record=Database::FetchRecord($curCategories)){
		echo	"<tr class='green'>
					<td>{$record['_labelCat']}</td>					
					<td><a href='#' id='totalQuestions_{$record['_id']}' data-type='text' data-pk='{$record['_id']}' class='editable editable-click'></a></td>
				</tr>";
	}
	
	echo "</table>";
	
}//else{



$queryCat = "SELECT id, label FROM surveys.survey_categories WHERE marketId IN( {$surveyInfo['_marketId']}) AND job = '{$surveyInfo['_surveyJob']}' AND enabled='true'";

$cur = Database::ExecuteQuery($queryCat);
?>


<table class="tableList">
	<thead class='blue'><tr><td>Categoria</td><td>Domande Richieste</td></tr></thead>
<?

while($record=Database::FetchRecord($cur)){	

	$sumExistCat = Database::ExecuteScalar("SELECT CASE WHEN SUM( totalQuestions ) IS NULL
												THEN 0
												ELSE SUM( totalQuestions )
												END AS _t
												FROM surveys.survey_pivot_categories
												WHERE idSurvey = {$surveyId}
												AND idCategory = {$record['id']}");
	$countCat = Database::ExecuteScalar("SELECT COUNT(*) FROM surveys.survey_questions WHERE categoryId = {$record['id']} AND enabled='true'");
	
	
	$totCat = $countCat - $sumExistCat;
	
	if($totCat>0){
		$select = "<select id='cat_{$record['id']}' class='' name='cat_{$record['id']}'><option selected='' value='0'>Seleziona una voce</option>";
		for($i=1;$i<=$totCat;$i++){
			$select .= "<option value='{$i}'>{$i}</option>"; 	
		}	
		echo "<tr class='blue'><td><label for='cat_{$record['id']}'>{$record['label']}</label></td><td>{$select}</td></tr>";
	}
}

echo "</table>";


?>
<input type="hidden" id="surveyId" name="surveyId" value="<?=$surveyId?>">
<input id="generateSurvey" name="submit" type="submit" value="Aggiungi Domande" class="buttonGeneric">
<?//}?>

<a style="margin-top:50px;" class="tolist" href="<?=Language::GetAddress($survey['manager']->folder . '/?_command=handle&_id='.$surveyId)?>">Torna alla gestione</a>

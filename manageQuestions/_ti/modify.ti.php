<?php
global $survey_manageQuestions;

$questionInfo = Database::ExecuteRecord("SELECT survey_categories.label AS _cat, 
survey_categories.job AS _job,
users_market.label AS _market 
FROM surveys.survey_questions 
LEFT JOIN surveys.survey_categories ON survey_categories.id = survey_questions.categoryId 
LEFT JOIN centre_ccsud.users_market ON users_market.id = survey_categories.marketId
WHERE surveys.survey_questions.id = {$survey_manageQuestions['id']}
");

echo "<table class='tableList'>
		<tr><th>Categoria</th><td>{$questionInfo['_cat']}</td></tr>
		<tr><th>Commessa</th><td>{$questionInfo['_job']}</td></tr>
		<tr><th>Mercato</th><td>{$questionInfo['_market']}</td></tr>
	  </table>
	  <br/>";

$record = $survey_manageQuestions['manager']->readById($survey_manageQuestions['id']);
$survey_manageQuestions['sheet']->fromDbRecord($record);		

		
$survey_manageQuestions['sheet']->setAndCheck();



if ($survey_manageQuestions['sheet']->wasSubmitted() && !$survey_manageQuestions['sheet']->hasErrors()) {
	
	
	$record = $survey_manageQuestions['sheet']->toDbRecord();
	
		
	$survey_manageQuestions['manager']->updateById($record, $survey_manageQuestions['id']);		
	
	Header::JsRedirect(Self(false, '_msg=modified'));
	
}else{
	$survey_manageQuestions['buttons']['submit']->text = 'Salva';	
	$survey_manageQuestions['sheet']->command = 'modify';
	$survey_manageQuestions['sheet']->show();
}
?>

<a class="tolist" href="<?=Language::GetAddress($survey_manageQuestions['manager']->folder . '/')?>">Torna all'elenco</a>
<?php 
global $surveySchoolGrade;

$surveySchoolGrade['sheet']->fromDbRecord($surveySchoolGrade['manager']->readById($surveySchoolGrade['id']));
$surveySchoolGrade['sheet']->cssClass = 'detail1';
$surveySchoolGrade['sheet']->showAsDetail(); 
?>

<a class="tolist" href="<?=Language::GetAddress($surveySchoolGrade['manager']->folder . '/')?>">Torna all'elenco</a>

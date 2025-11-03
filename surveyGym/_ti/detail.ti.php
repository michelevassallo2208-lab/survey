<?php 
global $surveyGym;

$surveyGym['sheet']->fromDbRecord($surveyGym['manager']->readById($surveyGym['id']));
$surveyGym['sheet']->cssClass = 'detail1';
$surveyGym['sheet']->showAsDetail(); 
?>

<a class="tolist" href="<?=Language::GetAddress($surveyGym['manager']->folder . '/')?>">Torna all'elenco</a>

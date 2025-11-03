<?php 
global $surveyAquila;

$surveyAquila['sheet']->fromDbRecord($surveyAquila['manager']->readById($surveyAquila['id']));
$surveyAquila['sheet']->cssClass = 'detail1';
$surveyAquila['sheet']->showAsDetail(); 
?>

<a class="tolist" href="<?=Language::GetAddress($surveyAquila['manager']->folder . '/')?>">Torna all'elenco</a>

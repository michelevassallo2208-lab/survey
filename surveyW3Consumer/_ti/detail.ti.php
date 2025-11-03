<?php 
global $surveyW3Consumer;

$surveyW3Consumer['sheet']->fromDbRecord($surveyW3Consumer['manager']->readById($surveyW3Consumer['id']));
$surveyW3Consumer['sheet']->cssClass = 'detail1';
$surveyW3Consumer['sheet']->showAsDetail(); 
?>

<a class="tolist" href="<?=Language::GetAddress($surveyW3Consumer['manager']->folder . '/')?>">Torna all'elenco</a>

<?php 
global $surveyLocker;

$surveyLocker['sheet']->fromDbRecord($surveyLocker['manager']->readById($surveyLocker['id']));
$surveyLocker['sheet']->cssClass = 'detail1';
$surveyLocker['sheet']->showAsDetail(); 
?>

<a class="tolist" href="<?=Language::GetAddress($surveyLocker['manager']->folder . '/')?>">Torna all'elenco</a>

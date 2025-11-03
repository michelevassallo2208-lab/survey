<?php
global $surveyAquila;

$surveyAquila['manager']->deleteById($surveyAquila['id']);

Header::JsRedirect(Self(false, '_msg=deleted'));
?>
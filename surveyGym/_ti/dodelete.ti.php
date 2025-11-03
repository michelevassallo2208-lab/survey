<?php
global $surveyGym;

$surveyGym['manager']->deleteById($surveyGym['id']);

Header::JsRedirect(Self(false, '_msg=deleted'));
?>
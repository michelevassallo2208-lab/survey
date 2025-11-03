<?php
global $surveyHeadset;

$surveyHeadset['manager']->deleteById($surveyHeadset['id']);

Header::JsRedirect(Self(false, '_msg=deleted'));
?>
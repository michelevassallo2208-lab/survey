<?php
global $surveyLocker;

$surveyLocker['manager']->deleteById($surveyLocker['id']);

Header::JsRedirect(Self(false, '_msg=deleted'));
?>
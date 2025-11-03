<?php
global $surveyW3Consumer;

$surveyW3Consumer['manager']->deleteById($surveyW3Consumer['id']);

Header::JsRedirect(Self(false, '_msg=deleted'));
?>
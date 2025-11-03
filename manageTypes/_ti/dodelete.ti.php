<?php
global $survey_manageTypes;

$survey_manageTypes['manager']->deleteById($survey['id']);

Header::JsRedirect(Self(false, '_msg=deleted'));
?>
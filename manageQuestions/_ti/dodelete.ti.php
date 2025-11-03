<?php
global $survey_manageQuestions;

$survey_manageQuestions['manager']->deleteById($survey['id']);

Header::JsRedirect(Self(false, '_msg=deleted'));
?>
<?php
global $survey_manageCategories;

$survey_manageCategories['manager']->deleteById($survey['id']);

Header::JsRedirect(Self(false, '_msg=deleted'));
?>
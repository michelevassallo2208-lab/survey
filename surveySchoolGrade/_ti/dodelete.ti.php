<?php
global $surveySchoolGrade;

$surveySchoolGrade['manager']->deleteById($surveySchoolGrade['id']);

Header::JsRedirect(Self(false, '_msg=deleted'));
?>
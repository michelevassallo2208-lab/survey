<?php
global $survey;

$survey['manager']->deleteById($survey['id']);

Header::JsRedirect(Self(false, '_msg=deleted'));
?>
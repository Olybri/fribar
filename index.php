<?php

require_once "include/database.php";

ob_start();
require "fribar/".(filter_input(INPUT_GET, "url") ?: "home").".php";
$content = ob_get_contents();
ob_end_clean();

$title = "Fribar - ".$title;
require "template.php";
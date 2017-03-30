<?php

require_once "include/database.php";
require_once "include/template.php";
require_once "include/revision.php";

require "fribar/".(filter_input(INPUT_GET, "url") ?: "home").".php";

if(!isset($title) || !isset($tpl))
    die("<br><b>Error</b>: title and/or template not defined.");

$main_tpl = new Template("main");
$main_tpl->set("title", $title);
$main_tpl->set("content", $tpl->html());

$footer = $git_not_found ? "" :
    "FriBar revision #$rev_num ($last_rev)<br>$rev_date";

$main_tpl->set("footer", $footer);

echo $main_tpl->html();
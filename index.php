<?php

require_once "include/database.php";
require_once "include/template.php";
require_once "include/revision.php";

$request_file = "fribar/"
    .(empty($_GET["url"]) ? "home" : $_GET["url"]).".php";

if(!file_exists($request_file))
{
    $title = "Erreur 404";
    $tpl = new Template("error");
    $tpl->set("message", "La page demandée n'existe plus.");
}
else
{
    require $request_file;
    if(!isset($title) || !isset($tpl))
        die("<br><b>Error</b>: title and/or template not defined.");
}

$footer = $git_not_found ? "" :
    "FriBar revision #$rev_num ($last_rev)<br>$rev_date";

$main_tpl = new Template("main");
$main_tpl->set("title", $title);
$main_tpl->set("content", $tpl->html());
$main_tpl->set("footer", $footer);

echo $main_tpl->html();

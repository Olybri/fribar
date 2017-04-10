<?php

try
{
    require_once "vendor/autoload.php";
    
    require_once "include/template.php";
    require_once "include/revision.php";
    require_once "include/database.php";
    
    $db = new Database();
    
    $request_file = "fribar/".(empty($_GET["url"]) ? "home" : $_GET["url"]).".php";
    
    if(!file_exists($request_file))
    {
        $title = "Erreur";
        $tpl = new Template("error");
        $tpl->set("message", "La page demandée n'existe plus.");
    }
    else
    {
        require $request_file;
        if(!isset($title) || !isset($tpl))
            throw new Exception("Title and/or template not defined.");
    }
    
    $footer = $git_not_found ? "" :
        "FriBar revision #$rev_num ($last_rev)<br>$rev_date";
    
    $main_tpl = new Template("main");
    $main_tpl->set("title", $title);
    $main_tpl->set("content", $tpl->html());
    $main_tpl->set("footer", $footer);
    
    echo $main_tpl->html();
}
catch(Exception $e)
{
    die("<br><b>Error</b>: ".$e->getMessage()."<br>"
        ."<br><b>Thrown</b> in ".$e->getFile()." on line ".$e->getLine()."<br>"
        ."<br><b>Stack trace</b>:<br>".nl2br($e->getTraceAsString()));
}

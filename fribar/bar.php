<?php

if(!isset($_GET["id"]))
{
    $title = "Bars";
    echo "<h2>$title</h2>";
    require "include/bar_list.php";
}

else
{
    $res = $db->query("SELECT name FROM bar WHERE id = ".$_GET["id"]);
    if($res->rowCount() == 0)
        die("Bar inexistant.");
    
    $title = $res->fetch()["name"];
    echo "<h2>".$title."</h2>Description.<br>";
    
    echo "<h3>Bières servies :</h3>";
    require "include/product_list.php";
}
<?php

if(!isset($_GET["id"]))
{
    $title = "Bières";
    echo "<h2>$title</h2>";
    require "include/product_list.php";
}

else
{
    $res = $db->query("SELECT name FROM product WHERE id = ".$_GET["id"]);
    if($res->rowCount() == 0)
        die("Produit inexistant.");
    
    $title = $res->fetch()["name"];
    echo "<h2>".$title."</h2>Description.<br>";
    
    echo "<h3>Servie à :</h3>";
    require "include/bar_list.php";
}

?>
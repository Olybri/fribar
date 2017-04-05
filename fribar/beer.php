<?php

// Si on veut la liste des bières
if(!isset($_GET["id"]) && empty($_POST))
{
    $title = "Bières";
    $tpl = new Template("beer_list");
    
    $beer_table = "";
    foreach($db->query("SELECT * FROM product") as $beer)
    {
        $beer_table .= "<tr>"
            ."<td><a href='".$_SERVER["REQUEST_URI"]."?id=".$beer["id"]."'>".$beer["name"]."</td>"
            ."</tr>\n";
    }
    
    $tpl->set("beer_table", $beer_table);
}

// Si on veut consulter une bière
else if(isset($_GET["id"]))
{
    $title = $db->query("SELECT name FROM product WHERE id = ".$_GET["id"])->fetchColumn();
    if(!$title)
        die("Produit inexistant.");
    
    $service_list = $db->query("SELECT * FROM service WHERE product_id = ".$_GET["id"]);
    
    if($service_list->rowCount() == 0)
        $tpl = new Template("not_served");
    
    else
    {
        $tpl = new Template("beer");
        
        $bar_table = "";
        foreach($service_list as $service)
        {
            $bar = $db->query("SELECT * FROM bar WHERE id = ".$service["bar_id"])->fetch();
            $bar_table .= "<tr>"
                ."<td><a href='bar?id=".$bar["id"]."'>".$bar["name"]."</td>"
                ."<td>".($service["volume"] / 100)." dl</td>"
                ."<td>CHF ".($service["price"] / 100)."</td>"
                ."</tr>\n";
        }
        
        $tpl->set("bar_table", $bar_table);
    }
}

// Si on veut ajouter une bière
else if(isset($_POST["form"]))
{
    $title = "Ajouter une bière";
    $tpl = new Template("beer_form");
}

// Si on veut soumettre une bière
else if(isset($_POST["submit"]))
{
    $title = "Bières";
    $tpl = new Template("data_sent");
    
    $db->query("INSERT INTO product (name) VALUES ('".$_POST["name"]."')");
    
    $tpl->set("text", "Nouvelle bière envoyée");
    $tpl->set("back", "/beer");
}

<?php

// Si on veut la liste des bières
if(!isset($_GET["id"]) && empty($_POST))
{
    $title = "Bières";
    $tpl = new Template("beer_list");
    
    $product_table = "";
    foreach($db->products() as $product)
    {
        $name = $product["name"];
        $url = "/beer?id=".$product["id"];
        
        $product_table .= "<tr>"
            ."<td><a href='$url'>$name</a></td>"
            ."</tr>\n";
    }
    
    $tpl->set("beer_table", $product_table);
}

// Si on veut consulter une bière
else if(isset($_GET["id"]))
{
    $product = $db->product($_GET["id"]);
    
    $title = $product["name"];
    if(!$title)
        die("Produit inexistant.");
    
    $services = $db->product_services($_GET["id"]);
    
    if(empty($services))
        $tpl = new Template("not_served");
    
    else
    {
        $tpl = new Template("beer");
        
        $bar_table = "";
        foreach($services as $service)
        {
            $bar = $db->bar($service["bar_id"]);
            
            $name = $bar["name"];
            $url = "bar?id=".$bar["id"];
            
            $volume = $service["volume"] / 100;
            $price = $service["price"] / 100;
            
            $bar_table .= "<tr>"
                ."<td><a href='$url'>$name</a></td>"
                ."<td>$volume dl</td>"
                ."<td>CHF $price</td>"
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
    
    $db->add_product($_POST["name"]);
    
    $tpl->set("text", "Nouvelle bière envoyée");
    $tpl->set("back", "/beer");
}

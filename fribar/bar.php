<?php

// Si on veut la liste des bars
if(!isset($_GET["id"]) && empty($_POST))
{
    $title = "Bars";
    $tpl = new Template("bar_list");
    
    $bar_table = "";
    foreach($db->bars() as $bar)
    {
        $name = $bar["name"];
        $url = "/bar?id=".$bar["id"];
        
        $product_count = $db->product_count($bar["id"]);
        
        $best_price = $db->best_price($bar["id"]);
        $best_price = ($best_price == 0 ? "—" : "CHF $best_price / litre");
        
        $bar_table .= "<tr>"
            ."<td><a href='$url'>$name</a></td>"
            ."<td>$product_count</td>"
            ."<td>$best_price</td>"
            ."</tr>\n";
    }
    
    $tpl->set("bar_table", $bar_table);
}

// Si on veut consulter un bar
else if(isset($_GET["id"]))
{
    $bar = $db->bar($_GET["id"]);
    
    $title = $bar["name"];
    if(!$title)
        die("Bar inexistant.");
    
    $tpl = new Template("bar");
    
    $product_table = "";
    foreach($db->bar_services($bar["id"]) as $service)
    {
        $product = $db->product($service["product_id"]);
        
        $name = $product["name"];
        $url = "beer?id=".$product["id"];
        
        $volume = $service["volume"] / 100;
        $price = $service["price"] / 100;
        
        $product_table .= "<tr>"
            ."<td><a href='$url'>$name</a></td>"
            ."<td>$volume dl</td>"
            ."<td>CHF $price</td>"
            ."</tr>\n";
    }
    
    $tpl->set("beer_table", $product_table);
}

// Si on veut ajouter un bar
else if(isset($_POST["form"]))
{
    $title = "Ajouter un bar";
    $tpl = new Template("bar_form");
    
    $product_list = "";
    foreach($db->products() as $product)
        $product_list .= "<option value='".$product["id"]."'>".$product["name"]."</option>\n";
    
    $tpl->set("beer_list", $product_list);
}

// Si on veut soumettre un bar
else if(isset($_POST["submit"]))
{
    $title = "Bars";
    $tpl = new Template("data_sent");
    
    $bar_id = $db->add_bar($_POST["name"]);
    $db->add_services($bar_id, $_POST["beer"], $_POST["volume"], $_POST["price"]);
    
    $tpl->set("text", "Nouveau bar envoyé");
    $tpl->set("back", "/bar");
}

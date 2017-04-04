<?php

// Si on veut la liste des bars
if(!isset($_GET["id"]) && empty($_POST))
{
    $title = "Bars";
    $tpl = new Template("bar_list");
    
    $bar_table = "";
    foreach($db->query("SELECT * FROM bar") as $bar)
    {
        // Nom du bar
        $name = $bar["name"];
        $url = $_SERVER["REQUEST_URI"]."?id=".$bar["id"];
        
        // Nombre de bières
        $count = $db->query("SELECT COUNT(DISTINCT product_id)FROM service WHERE bar_id = ".$bar["id"])->fetch()[0];
        
        // Meilleur prix (pour un litre)
        $best = 0;
        foreach($db->query("SELECT * FROM service WHERE bar_id = ".$bar["id"]) as $barProduct)
        {
            $price = $barProduct["price"] / $barProduct["volume"] * 10;
            if($best == 0 || $price < $best)
                $best = $price;
        }
        
        $bar_table .= "<tr>"
            ."<td><a href='$url'>$name</td>"
            ."<td>$count</td>"
            ."<td>CHF $best / litre</td>"
            ."</tr>\n";
    }
    
    $tpl->set("bar_table", $bar_table);
}

// Si on veut consulter un bar
else if(isset($_GET["id"]))
{
    $res = $db->query("SELECT name FROM bar WHERE id = ".$_GET["id"]);
    if($res->rowCount() == 0)
        die("Bar inexistant.");
    
    $title = $res->fetch()["name"];
    $tpl = new Template("bar");
    
    $beer_table = "";
    foreach($db->query("SELECT * FROM service WHERE bar_id = ".$_GET["id"]) as $row)
    {
        $product = $db->query("SELECT * FROM product WHERE id = ".$row["product_id"])->fetch();
        $beer_table .= "<tr>"
            ."<td><a href='beer?id=".$product["id"]."'>".$product["name"]."</td>"
            ."<td>".($row["volume"] / 100)." dl</td>"
            ."<td>CHF ".($row["price"] / 100)."</td>"
            ."</tr>\n";
    }
    
    $tpl->set("beer_table", $beer_table);
}

// Si on veut ajouter un bar
else if(isset($_POST["form"]))
{
    $title = "Ajouter un bar";
    $tpl = new Template("bar_form");
    
    $beer_list = "";
    foreach($db->query("SELECT * FROM product") as $beer)
        $beer_list .= "<option value='".$beer["id"]."'>".$beer["name"]."</option>\n";
    
    $tpl->set("beer_list", $beer_list);
}

// Si on veut soumettre un bar
else if(isset($_POST["submit"]))
{
    $title = "Bars";
    $tpl = new Template("data_sent");
    
    $db->query("INSERT INTO bar (name) VALUES ('".$_POST["name"]."')");
    $bar_id = $db->query("SELECT LAST_INSERT_ID()")->fetch()[0];
    
    foreach($_POST["beer"] as $key => $beer_id)
    {
        $volume = $_POST["volume"][$key];
        $price = $_POST["price"][$key];
        $db->query("INSERT INTO service (bar_id, product_id, volume, price)"
            ."VALUES ($bar_id, $beer_id, $volume, $price)");
    }
    
    $tpl->set("text", "Nouveau bar envoyé");
    $tpl->set("back", "/bar");
}

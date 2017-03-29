<?php

if(!isset($_GET["id"]))
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

else
{
    $res = $db->query("SELECT name FROM product WHERE id = ".$_GET["id"]);
    if($res->rowCount() == 0)
        die("Produit inexistant.");
    
    $title = $res->fetch()["name"];
    
    $res = $db->query("SELECT * FROM service WHERE product_id = ".$_GET["id"]);
    
    if($res->rowCount() == 0)
        $tpl = new Template("not_served");
    
    else
    {
        $tpl = new Template("beer");
        
        $bar_table = "";
        foreach($res as $row)
        {
            $bar = $db->query("SELECT * FROM bar WHERE id = ".$row["bar_id"])->fetch();
            $bar_table .= "<tr>"
                ."<td><a href='bar?id=".$bar["id"]."'>".$bar["name"]."</td>"
                ."<td>".($row["volume"] / 100)." dl</td>"
                ."<td>CHF ".($row["price"] / 100)."</td>"
                ."</tr>\n";
        }
        
        $tpl->set("bar_table", $bar_table);
    }
}

?>
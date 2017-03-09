<?php

if(!isset($_GET['id']))
{
    echo "<table><tr>"
        ."<th>Nom</th>"
        ."</tr>";
    
    foreach($db->query("SELECT * FROM product") as $beer)
    {
        echo "<tr>";
        echo "<td><a href='".$_SERVER["REQUEST_URI"]."?id=".$beer["id"]."'>".$beer["name"]."</td>";
        echo "</tr>\n";
    }
    
    echo "</table>";
}

else
{
    echo "<table><tr>"
        ."<th>Bière</th><th>Volume</th><th>Prix</th>"
        ."</tr>";
    
    foreach($db->query("SELECT * FROM service WHERE barID = ".$_GET["id"]) as $row)
    {
        $product = $db->query("SELECT * FROM product WHERE id = ".$row["productID"])->fetch();
        echo "<tr>";
        echo "<td><a href='beer?id=".$product["id"]."'>".$product["name"]."</td>";
        echo "<td>".($row["volume"] / 100)." dl</td>";
        echo "<td>CHF ".($row["price"] / 100)."</td>";
        echo "</tr>\n";
    }
    
    echo "</table>";
}
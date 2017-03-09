<?php

if(!isset($_GET['id']))
{
    echo "<table><tr>"
        ."<th>Nom</th>"
        ."</tr>";
    
    foreach($db->query("SELECT * FROM bar") as $bar)
    {
        echo "<tr>";
        echo "<td><a href='".$_SERVER["REQUEST_URI"]."?id=".$bar["id"]."'>".$bar["name"]."</td>";
        echo "</tr>\n";
    }
    
    echo "</table>";
}

else
{
    $res = $db->query("SELECT * FROM service WHERE productID = ".$_GET["id"]);
    if($res->rowCount() == 0)
        echo "Cette bière n'est actuellement servie dans aucun bar.";
    
    else
    {
        echo "<table><tr>"
            ."<th>Bar</th><th>Volume</th><th>Prix</th>"
            ."</tr>";
    
        foreach($res as $row)
        {
            $bar = $db->query("SELECT * FROM bar WHERE id = ".$row["barID"])->fetch();
            echo "<tr>";
            echo "<td><a href='bar?id=".$bar["id"]."'>".$bar["name"]."</td>";
            echo "<td>".($row["volume"] / 100)." dl</td>";
            echo "<td>CHF ".($row["price"] / 100)."</td>";
            echo "</tr>\n";
        }
    
        echo "</table>";
    }
}
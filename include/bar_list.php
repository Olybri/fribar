<?php

// Si on est pas sur la page d'une bière
if(!isset($_GET['id']))
{
    echo "<table><tr>"
        ."<th>Nom</th><th>Nombre de bières</th><th>Meilleur prix</th>"
        ."</tr>";
    
    foreach($db->query("SELECT * FROM bar") as $bar)
    {
        // Nom du bar
        $name = $bar["name"];
        $url = $_SERVER["REQUEST_URI"]."?id=".$bar["id"];
        
        // Nombre de bières
        $count = $db->query("SELECT COUNT(DISTINCT productID)FROM service WHERE barID = ".$bar["id"])->fetch()[0];
        
        // Meilleur prix (pour un litre)
        $best = 0;
        foreach($db->query("SELECT * FROM service WHERE barID = ".$bar["id"]) as $barProduct)
        {
            $price = $barProduct["price"] / $barProduct["volume"] * 10;
            if($best == 0 || $price < $best)
                $best = $price;
        }
        
        echo "<tr>";
        echo "<td><a href='$url'>$name</td>";
        echo "<td>$count</td>";
        echo "<td>CHF $best / litre</td>";
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
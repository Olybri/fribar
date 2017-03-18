<script>
    function addFields(id)
    {
        var fields = "<br><fieldset>" + document.getElementById(id).innerHTML + "</fieldset>";
        document.getElementById(id).insertAdjacentHTML("afterend", fields);
    }
</script>

<?php

// Si on veut ajouter un bar
if(isset($_POST["form"]))
{
    $title = "Ajouter un bar";
    
    echo "<h2>$title</h2>"
        ."<form id='form' action='".$_SERVER["REQUEST_URI"]."' method='post'>"
        ."<fieldset>"
        ."<legend>Informations</legend>"
        ."Nom : <input name='name' type='text' placeholder='Nom' required><br>"
        ."</fieldset>"
        ."<table><tr>";
    
    echo "<td><h3>Bières servies :</h3>"
        ."<fieldset id='beer'>"
        ."<legend>Bière</legend>"
        ."Nom : <select name='beer[]'>";
    
    foreach($db->query("SELECT * FROM product") as $beer)
        echo "<option value='".$beer["id"]."'>".$beer["name"]."</option>";
    
    echo "</select><br>"
        ."Volume : <input name='volume[]' type='number' placeholder='Volume' required> centilitres<br>"
        ."Prix : <input name='price[]' type='number' step='0.05' placeholder='Prix' required> CHF"
        ."</fieldset>"
        ."<p><input type='button' onclick='addFields(\"beer\")' value='Ajouter une bière'></td></p>";
    
    echo "<td><h3>Heures d'ouvertures :</h3>"
        ."<fieldset id='schedule'>"
        ."<legend>Horaire</legend>"
        ."Jour : <select name='day[]'>"
        ."<option value=1>Lundi</option>"
        ."<option value=2>Mardi</option>"
        ."<option value=3>Mercredi</option>"
        ."<option value=4>Jeudi</option>"
        ."<option value=5>Vendredi</option>"
        ."<option value=6>Samedi</option>"
        ."<option value=7>Dimanche</option>"
        ."</select><br>"
        ."Ouverture : <input name='open[]' type='time' required><br>"
        ."Fermeture : <input name='closed[]' type='time' required>"
        ."</fieldset>"
        ."<p><input type='button' onclick='addFields(\"schedule\")' value='Ajouter un jour'></td></p>";
    
    echo "</table><p><button name='submit'>Envoyer</button></p></form>";
}

// Si on veut soumettre un bar
else if(isset($_POST["submit"]))
{
    // TODO: mettre la bdd à jour
    
    echo "<h2>Nouveau bar envoyé</h2>"
        ."</h2><p><a href=".$_SERVER["REQUEST_URI"].">Retour</a></p>";
}

// Si on veut consulter un bar
else if(isset($_GET["id"]))
{
    $res = $db->query("SELECT name FROM bar WHERE id = ".$_GET["id"]);
    if($res->rowCount() == 0)
        die("Bar inexistant.");
    
    $title = $res->fetch()["name"];
    echo "<h2>".$title."</h2>Description.<br>";
    
    echo "<h3>Bières servies :</h3>";
    require "include/product_list.php";
}

// Si on veut la liste des bars
else
{
    $title = "Bars";
    
    echo "<h2>$title</h2>"
        ."<p><form action='".$_SERVER["REQUEST_URI"]."' method='post'>"
        ."<button name='form'>Ajouter un bar</button>"
        ."</form></p>";
    
    require "include/bar_list.php";
}
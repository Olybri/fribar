<?php
try
{
    $db = new PDO("mysql:host=localhost;dbname=fribar;charset=utf8", "root");
}
catch(Exception $e)
{
    die("<br><b>Error</b>: ".$e->getMessage());
}
<?php
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=php1st;charset=utf8mb4_unicode_ci', 'root', '');
}catch(Exception $e)
{
    die('Erreur'.$e ->getMessage());
}
?>
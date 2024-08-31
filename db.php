<?php
try
{
    $db = new PDO('mysql:host=localhost;dbname=EntranceWebDb2;charset=utf8', 'username', 'password');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
    die();
}
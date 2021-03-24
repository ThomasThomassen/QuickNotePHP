<?php

$username = "root";
$password = "";

try {

    $dbCon = new PDO('mysql:host=localhost;dbname=quicknotedb;charset=utf8', $username, $password);

    return $dbCon;

} catch (PDOException $err) {

    echo "Error!: " . $err->getMessage() . "<br/>";

    die();
}
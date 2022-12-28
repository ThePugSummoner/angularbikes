<?php
require_once 'inc/functions.php';
require_once 'inc/headers.php';

try{
    $dbcon = openDb();
    $sql = "SELECT * FROM tilaus";
    $query = $dbcon->query($sql);
    $results = $query->fetchAll(PDO::FETCH_ASSOC);
    header('HTTP/1.1 200 OK');
    print json_encode($results);
} catch (PDOException $pdoex) {
    returnError($pdoex);
}


<?php

function openDb() {
    $dbcon = new PDO('mysql:host=localhost;dbname=angularbikes;charset=utf8', 'root', '');
    $dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbcon;
}

function returnError(PDOException $pdoex) {
    echo header('HTTP/1.1 500 Internal Server Error');
    $error = array('error' => $pdoex->getMessage());
    echo json_encode($error);
    exit;
}

function selectAsJson(object $db,string $sql): void {
    $query = $db->query($sql);
    $results = $query->fetchAll(PDO::FETCH_ASSOC);
    header('HTTP/1.1 200 OK');
    echo json_encode($results);
  }
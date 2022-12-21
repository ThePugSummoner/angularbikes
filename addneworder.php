<?php

require_once 'inc/functions.php';
require_once 'inc/headers.php';

$input = json_decode(file_get_contents('php://input'));

$userId = filter_var($input->userId, FILTER_SANITIZE_NUMBER_INT);
$date = filter_var($input->date, FILTER_UNSAFE_RAW);
$amount = filter_var($input->amount, FILTER_SANITIZE_NUMBER_FLOAT);
$status = filter_var($input->status, FILTER_SANITIZE_SPECIAL_CHARS);
$exchange = filter_var($input->exchange, FILTER_SANITIZE_SPECIAL_CHARS);

if (!empty($userId) && !empty($amount)) {

    try {

        $dbcon = openDb();

        $query = $dbcon->prepare('INSERT INTO tilaus (astunnus, tilauspvm, summa, tila, palautus) 
        VALUES (:astunnus, :tilauspvm, :summa, :tila, :palautus)');

        $query->bindParam(':astunnus', $userId, PDO::PARAM_STR);
        $query->bindParam(':tilauspvm', $date, PDO::PARAM_STR);
        $query->bindParam(':summa', $amount, PDO::PARAM_STR);
        $query->bindParam(':tila', $status, PDO::PARAM_STR);
        $query->bindParam(':palautus', $exchange, PDO::PARAM_STR);
        $query->execute();

        header('HTTP/1.1 200 OK');
        $data = array('tilausnro' => $dbcon->lastInsertId(), 'astunnus' => $userId, 'tilauspvm' => $date, 'summa' => $amount, 'tila' => $status, 'palautus' => $exchange);
        print json_encode($data);

    } catch (PDOException $pdoex) {
        returnError($pdoex);
    }
} else {
    echo "Hups! Jotain meni pieleen!";
}


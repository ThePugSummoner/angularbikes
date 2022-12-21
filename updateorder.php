<?php

require_once 'inc/headers.php';
require_once 'inc/functions.php';

$input = json_decode(file_get_contents('php://input'));
$status = filter_var($input->status, FILTER_SANITIZE_SPECIAL_CHARS);
$order = filter_var($input->order, FILTER_SANITIZE_NUMBER_INT);

try {
    $db = openDb();

    $query = $db->prepare('UPDATE tilaus SET tila=:tila WHERE tilausnro=:tilausnro');
    $query->bindValue(':tila', $status, PDO::PARAM_STR);
    $query->bindValue(':tilausnro', $order, PDO::PARAM_INT);
    $query->execute();

    header('HTTP/1.1 200 OK');
    $data = array('tilausnro' =>$order, 'tila' => $status);
    print json_encode($data);
} catch (PDOException $pdoex) {
    returnError($pdoex);
}
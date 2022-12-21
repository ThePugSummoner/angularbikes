<?php

require_once 'inc/functions.php';
require_once 'inc/headers.php';

$input = json_decode(file_get_contents('php://input'));

$cat_name = filter_var($input->catname, FILTER_UNSAFE_RAW);

if(!empty($cat_name)) {
    try {

        $dbcon = openDb();

        $query = $dbcon->prepare('INSERT INTO tuoteryhma (trnimi) VALUES (:trnimi)');

        $query->bindParam(':trnimi', $cat_name, PDO::PARAM_STR);
        $query->execute();

        header('HTTP/1.1 200 OK');
        $data = array('trnro' => $dbcon->lastInsertId(), 'trnimi' => $cat_name);
        print json_encode($data);
       

    } catch (PDOException $pdoex) {
        returnError($pdoex);
    }
} else {
    echo "Antamasi tiedot ovat virhellisiä";
}
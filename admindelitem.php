<?php

require_once 'inc/functions.php';
require_once 'inc/headers.php';
//require('dbconnection.php');

$input = json_decode(file_get_contents('php://input'));

$id = filter_var($input->itemNum, FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {

    try {

        $dbcon = openDb();

        $query = $dbcon->prepare('DELETE FROM tuote WHERE tuotenro = (:id)');
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        
        /*$sql = "SELECT tuotenro, nimi, saldo, koko FROM tuote WHERE tuotenro = '$id'";
        $query = $dbcon->query($sql);
        $item = $query->fetchAll(PDO::FETCH_ASSOC);*/

        header('HTTP/1.1 200 OK');
        $data = array('id' => $id);
        print json_encode($data);

    } catch (PDOException $pdoex) {
        returnError($pdoex);
    }

} else {
    echo "Antamasi tiedot ovat virhellisiä";
}
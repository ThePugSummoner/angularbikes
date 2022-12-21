<?php

require_once 'inc/functions.php';
require_once 'inc/headers.php';

$lines = json_decode(file_get_contents('php://input'));

foreach ($lines as $line) {
    foreach ($line as $orderline) {
        $tuotenro = filter_var($orderline->tuotenro, FILTER_SANITIZE_NUMBER_INT);
        $rivinro = filter_var($orderline->rivinro, FILTER_SANITIZE_NUMBER_INT);
        $maara = filter_var($orderline->kpl, FILTER_SANITIZE_NUMBER_INT);
        $tilausnro = filter_var($orderline->tilausnro, FILTER_SANITIZE_NUMBER_INT);

        try {

            $dbcon = openDb();
    
            $query = $dbcon->prepare('INSERT INTO tilausrivi (tilausnro, rivinro, tuotenro, kpl) 
            VALUES (:tilausnro, :rivinro, :tuotenro, :kpl)');
    
            $query->bindParam(':tilausnro', $tilausnro, PDO::PARAM_STR);
            $query->bindParam(':rivinro', $rivinro, PDO::PARAM_STR);
            $query->bindParam(':tuotenro', $tuotenro, PDO::PARAM_STR);
            $query->bindParam(':kpl', $maara, PDO::PARAM_STR);
            $query->execute();
    
            header('HTTP/1.1 200 OK');
            $data = array('tuotenro' => $tuotenro, 'rivinro' => $rivinro, 'kpl' => $maara, 'tilausnro' => $tilausnro);
            print json_encode($data);
    
        } catch (PDOException $pdoex) {
            returnError($pdoex);
        }

    }
}

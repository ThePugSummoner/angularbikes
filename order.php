<?php

require_once 'inc/functions.php';
require_once 'inc/headers.php';

$input = json_decode(file_get_contents('php://input'));
$email = filter_var($input->email, FILTER_UNSAFE_RAW);

try {
    $dbcon = openDb();

    $sql = "SELECT * FROM tilaus WHERE astunnus = (SELECT astunnus FROM asiakas WHERE sposti = '$email')";
    $query = $dbcon->query($sql);
    $results = $query->fetchAll(PDO::FETCH_ASSOC);
    
   //$query = $db->prepare('SELECT * FROM tilaus WHERE astunnus = (SELECT astunnus FROM asiakas WHERE sposti = (:email)');
    //$query->bindValue(':email', $email, PDO::PARAM_STR);
    //$query->execute();
    
    header('HTTP/1.1 200 OK');
    print json_encode($results);
} catch (PDOException $pdoex) {
    returnError($pdoex);
}
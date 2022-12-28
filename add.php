<?php

require_once 'inc/functions.php';
require_once 'inc/headers.php';
//require('dbconnection.php');

$input = json_decode(file_get_contents('php://input'));
$fname = filter_var($input->fname, FILTER_SANITIZE_SPECIAL_CHARS);
$lname = filter_var($input->lname, FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_var($input->email, FILTER_SANITIZE_EMAIL);
$phone = filter_var($input->phone, FILTER_SANITIZE_NUMBER_INT);
$password = filter_var($input->password, FILTER_UNSAFE_RAW);
$hash_pw = password_hash($password, PASSWORD_DEFAULT);
$subscribe = filter_var($input->subscribe, FILTER_SANITIZE_SPECIAL_CHARS);

if (!empty($fname) && !empty($lname) && !empty($email) && !empty($phone)) {

    try {
    /*$db = new PDO('mysql:host=localhost;dbname=todo;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);*/

    $dbcon = openDb();

    $query = $dbcon->prepare('INSERT INTO asiakas(etunimi, sukunimi, sposti, puhnro, salasana, uutiskirje) VALUES (:etunimi, :sukunimi, :sposti, :puhnro, :salasana, :uutiskirje)');
    $query->bindValue(':etunimi', $fname, PDO::PARAM_STR);
    $query->bindValue(':sukunimi', $lname, PDO::PARAM_STR);
    $query->bindValue(':sposti', $email, PDO::PARAM_STR);
    $query->bindValue(':puhnro', $phone, PDO::PARAM_STR);
    $query->bindValue(':salasana', $hash_pw, PDO::PARAM_STR);
    $query->bindValue(':uutiskirje', $subscribe, PDO::PARAM_STR);
    $query->execute();


    header('HTTP/1.1 200 OK');
    $data = array('astunnus' => $dbcon->lastInsertId(), 'etunimi' => $fname, 'sukunimi' => $lname, 'sposti' => $email, 'puhnro' => $phone, 'salasana' => $password, 'uutiskirje' => $subscribe);
    print json_encode($data);

} catch (PDOException $pdoex) {
    returnError($pdoex);
}
} else {
    echo "Antamasi tiedot ovat virhellisiä";
}
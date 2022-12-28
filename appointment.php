<?php

require_once 'inc/functions.php';
require_once 'inc/headers.php';
//require('dbconnection.php');

$input = json_decode(file_get_contents('php://input'));
//$description = $input ->description;
$fname = filter_var($input->fname, FILTER_UNSAFE_RAW);
$lname = filter_var($input->lname, FILTER_UNSAFE_RAW);
$email = filter_var($input->email, FILTER_UNSAFE_RAW);
$pnum = filter_var($input->pnum, FILTER_UNSAFE_RAW);
$service = filter_var($input->service, FILTER_UNSAFE_RAW);
//$hash_pw = password_hash($description5, PASSWORD_DEFAULT);
$bike_model = filter_var($input->bike_model, FILTER_UNSAFE_RAW);
$appt_day = filter_var($input->appt_day, FILTER_UNSAFE_RAW);
$appt_time = filter_var($input->appt_time, FILTER_UNSAFE_RAW);
//$description = strp_tags($description);

if (!empty($email) && !empty($fname) && !empty($lname) && !empty($pnum) && !empty($service) && !empty($bike_model)) {
    try {
    /*$db = new PDO('mysql:host=localhost;dbname=todo;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);*/

    $dbcon = openDb();

    $query = $dbcon->prepare('INSERT INTO ajanvaraus (etunimi, sukunimi, sposti, puhnro, pnimi, merkki, pvm, aika) 
    VALUES (:etunimi, :sukunimi, :sposti, :puhnro, :pnimi, :merkki, :pvm, :aika)');
    $query->bindValue(':etunimi', $fname, PDO::PARAM_STR);
    $query->bindValue(':sukunimi', $lname, PDO::PARAM_STR);
    $query->bindValue(':sposti', $email, PDO::PARAM_STR);
    $query->bindValue(':puhnro', $pnum, PDO::PARAM_STR);
    $query->bindValue(':pnimi', $service, PDO::PARAM_STR);
    $query->bindValue(':merkki', $bike_model, PDO::PARAM_STR);
    $query->bindValue(':pvm', $appt_day, PDO::PARAM_STR);
    $query->bindValue(':aika', $appt_time, PDO::PARAM_STR);
     
    $query->execute();


    header('HTTP/1.1 200 OK');
    $data = array('vartunnus' => $dbcon->lastInsertId(), 'etunimi' => $fname, 'sukunimi' => $lname, 'sposti' => $email, 'puhnro' => $pnum, 'pnimi' => $service, 'merkki' => $bike_model, 'pvm' => $appt_day, 'aika' => $appt_aika,);
    print json_encode($data);

} catch (PDOException $pdoex) {
    returnError($pdoex);
}
} else {
    echo "Antamasi tiedot ovat virhellisiä";
}
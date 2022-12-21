<?php

require_once 'inc/functions.php';
require_once 'inc/headers.php';


$input = json_decode(file_get_contents('php://input'));

$fname = filter_var($input->fname, FILTER_SANITIZE_SPECIAL_CHARS);
$lname = filter_var($input->lname, FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_var($input->email, FILTER_SANITIZE_EMAIL);
$pnum = filter_var($input->pnum, FILTER_SANITIZE_NUMBER_INT);
$service = filter_var($input->service, FILTER_SANITIZE_SPECIAL_CHARS);
$bike_model = filter_var($input->bike_model, FILTER_SANITIZE_SPECIAL_CHARS);
$appt_day = filter_var($input->appt_day, FILTER_UNSAFE_RAW);
$appt_time = filter_var($input->appt_time, FILTER_UNSAFE_RAW);


if (!empty($email) && !empty($fname) && !empty($lname) && !empty($pnum) && !empty($service) && !empty($bike_model)) {
    try {

    $dbcon = openDb();

    $query = $dbcon->prepare('INSERT INTO ajanvaraus (etunimi, sukunimi, sposti, puhnro, pnimi, merkki, pvm, aika) 
    VALUES (:etunimi, :sukunimi, :sposti, :puhnro, :pnimi, :merkki, :pvm, :aika)');
    $query->bindParam(':etunimi', $fname, PDO::PARAM_STR);
    $query->bindParam(':sukunimi', $lname, PDO::PARAM_STR);
    $query->bindParam(':sposti', $email, PDO::PARAM_STR);
    $query->bindParam(':puhnro', $pnum, PDO::PARAM_STR);
    $query->bindParam(':pnimi', $service, PDO::PARAM_STR);
    $query->bindParam(':merkki', $bike_model, PDO::PARAM_STR);
    $query->bindParam(':pvm', $appt_day, PDO::PARAM_STR);
    $query->bindParam(':aika', $appt_time, PDO::PARAM_STR);
     
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
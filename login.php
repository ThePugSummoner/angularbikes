<?php
require_once 'inc/functions.php';
require_once 'inc/headers.php';

$input = json_decode(file_get_contents('php://input'));

$email = filter_var($input->email, FILTER_UNSAFE_RAW);
$pwd = filter_var($input->pwd, FILTER_UNSAFE_RAW);

try {

    $dbcon = openDb();
    
    $sql = "SELECT * FROM asiakas WHERE sposti = '$email'";
    $query = $dbcon->query($sql);
    $user = $query->fetchAll(PDO::FETCH_ASSOC);
    
    
    header('HTTP/1.1 200 OK');

    if (!empty($user)) {
        $hash = $user[0]["salasana"];
        $email = $user[0]["sposti"];

        if (password_verify($pwd, $hash) == true) {
            if ($email == 'admin@admin.com') {
                echo "Admin logged in!";
            } else {
                echo "Data Matched";
            }
           
        } 
        
        else {
            echo "Käyttäjätunnus/salasana on virhellinen";
            
        }
    } else {
        echo "Käyttäjätunnus/salasana on virhellinen";
    }
    
   } catch (PDOException $pdoex) {
    returnError($pdoex);
}

<?php

require_once 'inc/functions.php';
require_once 'inc/headers.php';

$input = json_decode(file_get_contents('php://input'));

$item_name = filter_var($input->itemName, FILTER_SANITIZE_SPECIAL_CHARS);
$description = filter_var($input->description, FILTER_SANITIZE_SPECIAL_CHARS);
$price = filter_var($input->price, FILTER_SANITIZE_NUMBER_FLOAT);
$cat_num = filter_var($input->catnum, FILTER_SANITIZE_NUMBER_INT);
$subcat = filter_var($input->subcat, FILTER_SANITIZE_NUMBER_INT);
$image = filter_var($input->image, FILTER_UNSAFE_RAW);
$balance = filter_var($input->balance, FILTER_SANITIZE_NUMBER_INT);
$size = filter_var($input->size,FILTER_SANITIZE_SPECIAL_CHARS);


if (!empty($item_name) && !empty($price) && !empty($cat_num)) {

    try {

        $dbcon = openDb();

        $query = $dbcon->prepare('INSERT INTO tuote (nimi, kuvaus, hinta, trnro, alakategorianro, kuva, saldo, koko) 
        VALUES (:nimi, :kuvaus, :hinta, :trnro, :alakategorianro, :kuva, :saldo, :koko)');

        $query->bindParam(':nimi', $item_name, PDO::PARAM_STR);
        $query->bindParam(':kuvaus', $description, PDO::PARAM_STR);
        $query->bindParam(':hinta', $price, PDO::PARAM_STR);
        $query->bindParam(':trnro', $cat_num, PDO::PARAM_STR);
        $query->bindParam(':alakategorianro', $subcat, PDO::PARAM_STR);
        $query->bindParam(':kuva', $image, PDO::PARAM_STR);
        $query->bindParam(':saldo', $balance, PDO::PARAM_STR);
        $query->bindParam(':koko', $size, PDO::PARAM_STR);
        $query->execute();

        header('HTTP/1.1 200 OK');
        $data = array('nimi' => $item_name, 'kuvaus' => $description, 'hinta' => $price, 
        'trnro' => $cat_num, 'alakategorianro' => $subcat, 'kuva' => $image, 'saldo' => $balance, 'koko' => $size);
        print json_encode($data);

    } catch (PDOException $pdoex) {
        returnError($pdoex);
    }
} else {
    echo "Antamasi tiedot ovat virhellisiä";
}


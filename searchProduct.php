<?php
require_once './inc/functions.php';
require_once './inc/headers.php';

$uri=parse_url(filter_input(INPUT_SERVER,"PATH_INFO"),PHP_URL_PATH);
$parameters = explode("/",$uri);
$product_name=$parameters[1];

if($product_name!==""){
try{
    
    $db=openDb();
    $sql="SELECT * FROM tuote WHERE nimi like '%$product_name%'";
    $query=$db->query($sql);
    $product=$query->fetchAll(PDO::FETCH_ASSOC);

    
header("HTTP/1.1 200 OK");
echo json_encode($product);

}
catch(PDOException $pdoex){
    returnError($pdoex);
}
}
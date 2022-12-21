<?php
require_once './inc/functions.php';
require_once './inc/headers.php';

$uri=parse_url(filter_input(INPUT_SERVER,"PATH_INFO"),PHP_URL_PATH);
$parameters = explode("/",$uri);
$subCategory=$parameters[2];
$category_id=$parameters[1];

try{
    $db=openDb();
    $sql="SELECT * FROM tuote WHERE alakategoria='$subCategory'";
    $query=$db->query($sql);
    $subCategoryProducts=$query->fetchAll(PDO::FETCH_ASSOC);

    $sql="select DISTINCT alakategoria from tuote inner join tuoteryhma on tuote.trnro=tuoteryhma.trnro where trnimi='$category_id'";
    $query=$db->query($sql);
    $subCategories=$query->fetchAll(PDO::FETCH_ASSOC);




header("HTTP/1.1 200 OK");
echo json_encode(array(
    "products"=>$subCategoryProducts,
    "subcategories"=>$subCategories
));

}
catch(PDOException $pdoex){
    returnError($pdoex);
}
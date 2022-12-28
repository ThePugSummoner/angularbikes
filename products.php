<?php
require_once './inc/functions.php';
require_once './inc/headers.php';

$uri=parse_url(filter_input(INPUT_SERVER,"PATH_INFO"),PHP_URL_PATH);
$parameters = explode("/",$uri);
$category_id=$parameters[1];

try{
    $db=openDb();
    $sql="select tuotenro,nimi,kuvaus,hinta,tuote.trnro,alakategoria,kuva,saldo,koko,trnimi,alennus,uusihinta,alennusprosentti from tuote inner join tuoteryhma on tuote.trnro=tuoteryhma.trnro inner join alatuoteryhma on tuote.alakategorianro=alatuoteryhma.alakategorianro where trnimi='$category_id'";
    $query=$db->query($sql);
    $products=$query->fetchAll(PDO::FETCH_ASSOC);

    $sql="select DISTINCT alakategoria from tuote inner join tuoteryhma on tuote.trnro=tuoteryhma.trnro inner join alatuoteryhma on tuote.alakategorianro=alatuoteryhma.alakategorianro where trnimi='$category_id'";
    $query=$db->query($sql);
    $subCategories=$query->fetchAll(PDO::FETCH_ASSOC);

    $sql="select* from tuoteryhma WHERE trnimi='$category_id'";
    $query=$db->query($sql);
    $Category=$query->fetchAll(PDO::FETCH_ASSOC);

header("HTTP/1.1 200 OK");
echo json_encode(array(
    "products"=>$products,
    "subcategories"  => $subCategories,
    "category" =>$Category
));

}
catch(PDOException $pdoex){
    returnError($pdoex);
}
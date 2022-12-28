<?php
require_once './inc/functions.php';
require_once './inc/headers.php';


if(isset($_GET["category"])){
    $category=$_GET["category"];
}

try{
    $db=openDb();
    if($category==="Tarjous"){
        $sql="SELECT * FROM tuote WHERE alennus=1";
        $query=$db->query($sql);
        $products=$query->fetchAll(PDO::FETCH_ASSOC);
    }else{
        $sql="select tuotenro,nimi,kuvaus,hinta,tuote.trnro,alakategoria,kuva,saldo,koko,trnimi,alennus,uusihinta,alennusprosentti from tuote inner join tuoteryhma on tuote.trnro=tuoteryhma.trnro inner join alatuoteryhma on tuote.alakategorianro=alatuoteryhma.alakategorianro where trnimi='$category'";
        $query=$db->query($sql);
        $products=$query->fetchAll(PDO::FETCH_ASSOC);
    }
header("HTTP/1.1 200 OK");
echo json_encode($products);

}
catch(PDOException $pdoex){
    returnError($pdoex);
}

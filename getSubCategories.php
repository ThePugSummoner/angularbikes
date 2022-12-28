<?php
require_once './inc/functions.php';
require_once './inc/headers.php';

try {
  $db = openDb();
  selectAsJson($db,'SELECT trnro , alakategoria FROM
  tuote INNER JOIN alatuoteryhma on tuote.alakategorianro=alatuoteryhma.alakategorianro
  GROUP by alakategoria
  ORDER by trnro');
}
catch (PDOException $pdoex) {
  returnError($pdoex);
}
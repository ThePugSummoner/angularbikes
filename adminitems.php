<?php
require_once './inc/functions.php';
require_once './inc/headers.php';

try {
  $dbcon = openDb();
  selectAsJson($dbcon,'SELECT * FROM tuote');
}
catch (PDOException $pdoex) {
  returnError($pdoex);
}
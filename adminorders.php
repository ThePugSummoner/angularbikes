<?php
require_once './inc/functions.php';
require_once './inc/headers.php';

try {
  $dbcon = openDb();
  selectAsJson($dbcon,'SELECT * FROM tilaus');
}
catch (PDOException $pdoex) {
  returnError($pdoex);
}
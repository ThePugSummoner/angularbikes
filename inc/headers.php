<?php

header('Access-Control-Allow-Origin:*'); {/* {$_SERVER['HTTP_ORIGIN']} */}
header('Access-Control-Allow-Credentilas:true');
header('Access-Control-Allow-Methods: DELETE, POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Accept, Content-Type');
header('Access-Control-Max-Age: 3600');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    return 0;
}
<?php
// require swagger autoloader
require("../../vendor/autoload.php");
$openapi = \OpenApi\Generator::scan([$_SERVER['DOCUMENT_ROOT'].'/hostelworld/models']);
//set header type
header('Content-Type: application/json');
//return JSON
echo $openapi->toJSON();
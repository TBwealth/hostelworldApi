<?php
// require swagger autoloader
require("../../vendor/autoload.php");


$openapi = \OpenApi\Generator::scan([$_SERVER['DOCUMENT_ROOT'].'/hostelworld/models']);

header('Content-Type: application/json');
echo $openapi->toJSON();
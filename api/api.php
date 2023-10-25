<?php
error_reporting(E_ALL);
ini_set('display_error', 1);


// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');

// required files
include_once '../models/ApiController.php';

// get the request method

$requestMethod = $_SERVER["REQUEST_METHOD"];

// check if request method is GET

if($requestMethod == "GET"){
	// declare params variable
	$term = "";
	$date = "";
// get params from url
	if (array_key_exists("term", $_GET)) $term = $_GET['term'];
	if (array_key_exists("date", $_GET)) {
		$date = $_GET['date'];
        $datearray = explode("-", $date);
		$isDateValid = checkdate($datearray[1], $datearray[2], $datearray[0]);
		// Check if date is valid
		if(!$isDateValid){
	// throw 400 if Date is invalid
	$data = [
		'status' => 400,
		'message' => 'Invalid date ('.$date.'), please input date in this format: YYYY-MM-DD',
	];
	// set response header
	header("HTTP/1.0 400 Bad request");
	// return response
	echo json_encode($data);
			return;
		}
// get todays date and compare with users input
		$todaysDate = date('Y-m-d');
		$datetotime = strtotime($todaysDate);
		$searchtime = strtotime($date); 
		if($datetotime > $searchtime){
				// throw 400 if Date is past
	$data = [
		'status' => 400,
		'message' => 'Past date ('.$date.') not allowed',
	];
	// set response header
	header("HTTP/1.0 400 Bad request");
	// return response
	echo json_encode($data);
			return;
		}
	};

// instatiate api controller
 $apiController = new ApiController($term,$date);
 $eventList = $apiController->readEvent();

 // set reponse data
 $data = [
	'status' => 200,
	'message' => 'Events fetched successfully',
	'data' =>  $eventList
];

// set response header
header("HTTP/1.0 200 Success");
// return response
echo json_encode($data);
}else{
	// throw 405 if method is not GET
	$data = [
		'status' => 405,
		'message' => $requestMethod. 'Method Not Allowed',
	];

	// set response header
	header("HTTP/1.0 405 Method Not Allowed");
	// return response
	echo json_encode($data);
}


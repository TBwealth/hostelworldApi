<?php
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

// required files
require_once(dirname(__FILE__).'/../models/ApiController.php');
class UnitTestCase extends TestCase 
{

    // test get endpoint
    public function testGetRequest()
    {
        try{
   // Create a client with a base URI
   $client = new Client(['base_uri' => 'http://localhost:8012/hostelworld/api/']);
   // Send a get request
   $response = $client->request('GET', 'api.php?date=2023-10-01');
   // Test that endpoint response is of status code 200
   $this->assertEquals(200, $response->getStatusCode());
        }catch(ClientException $e){
              // Test that endpoint response is of status code 400
            $this->assertEquals(400, $e->getResponse()->getBody());
        }
 
    }
    
    // test read event class output
    public function testReadEventFuction(){
        	//prepare sample data to test 
        $sampleData = array (
               array (
                "id" => 1,
                "name" => "Ex exercitation et occaecat excepteur nostrud aute voluptate elit.",
                "city" => "Dupuyer",
                "country" => "Bahamas",
                "startDate" => "2024-04-07",
                "endDate" => "2024-05-11"
               ),
             array (
                "id"=> 2,
                "name"=> "Laboris nostrud magna consectetur fugiat ea est ut ad id aliqua do aliqua labore sunt.",
                "city"=> "Gorham",
                "country"=> "Greece",
                "startDate"=> "2024-04-25",
                "endDate"=> "2024-05-15"
             ));
        // instatiate api controller
        $apiController = new ApiController("Waumandeee","2024-04-25",$sampleData);
        $eventList = $apiController->readEvent();
        // Test that endpoint response is of status code 200
        $this->assertIsArray($eventList);
    }
}
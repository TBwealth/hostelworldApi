<?php
error_reporting(E_ALL);
ini_set('dispay_error',1);

/**
 * @OA\Info(title="Hostel World API", version="1.0")
 */

class ApiController {
    // get path to JSON data
private $path = '../data/data.json';

// declare required vaiable
    public $term;
    public $date;
  
    //initialize the class
    public function __construct($term,$date)
    {
   $this->term = $term;
   $this->date = $date;

    }
  /**
     * @OA\Get(
     *     path="/hostelworld/api/api.php",
     *     summary="Get Hostel World Events with terms and or date",
     *     tags = {"Get"},
     *     @OA\Parameter(
     *          name="term",
    *           in="query",
*               required=false,
*               description="search term for events city or country",
*               @OA\Schema(
 *                  type="string"
*                   )
     * ),
     *   *     @OA\Parameter(
     *          name="date",
    *           in="query",
*               required=false,
*               description="search between date range of events",
*               @OA\Schema(
 *                  type="string"
*                   )
     * ),
     *     @OA\Response(response="200", description="success, a list of events",
     * @OA\Schema(
 *                  type="string"
*                   )),
     *     @OA\Response(response="400", description="bad request"),
     * )
     */
    public function readEvent(){   
        // get json file content     
        $jsonString = file_get_contents($this->path);
        // decode file content to json 
        $jsonData = json_decode($jsonString, true);
        
        // if term and date is passed
        if(!empty($this->term) && !empty($this->date)){
            $filterArray = array_filter($jsonData, function ($event){
                $searchtime = strtotime($this->date); 
                $rangeStart = strtotime($event['startDate']); 
                $rangeEnd = strtotime($event['endDate']);
                return (((strtolower($event['city']) == strtolower($this->term)) || (strtolower($event['country']) == strtolower($this->term))) && 
                ($searchtime <= $rangeEnd && $rangeStart >= $searchtime));
            });
        return $filterArray;
        }

        // if only date is passed
        if(empty($this->term) && !empty($this->date)){
            $newarray = array();
            $searchtime = strtotime($this->date); 
            foreach ($jsonData as $event){
                $rangeStart = strtotime($event['startDate']); 
                $rangeEnd = strtotime($event['endDate']);
                
                if (
                    $searchtime <= $rangeEnd && 
                    $rangeStart >= $searchtime)array_push($newarray,$event);
            }
        return $newarray;
        }

        // if only term is passed
        if(!empty($this->term) && empty($this->date)){
            $filterArray = array_filter($jsonData, function ($event){
                return (strtolower($event['city']) == strtolower($this->term)) || (strtolower($event['country']) == strtolower($this->term));
            });
        return $filterArray;
        }
     
    }
}

?>
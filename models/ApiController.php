<?php
// set php error reporting level
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
   public $jsonData;
    //initialize the class
    public function __construct($term,$date,$jsonData)
    {
   $this->term = $term;
   $this->date = $date;
   $this->jsonData = $jsonData;
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
     *        @OA\Parameter(
     *          name="date",
    *           in="query",
*               required=false,
*               description="search between date range of events",
*               @OA\Schema(
 *                  type="string"
*                   )
     * ),
     *     @OA\Response(response="200", description="success, a list of events",
     *    @OA\MediaType(
 *         mediaType="application/json",
 * @OA\Schema(
  *   description="Action Plans",
  *   title="Action Plan Schema",
  *   required={
  *     "id",
  *     "name",
  *     "city",
  *     "country",
  *     "startDate",
  *     "endDate"
  *   },
  *    @OA\Property(
  *      property="id",
  *      type="string",
  *      format="",
  *      description="Action Plan ID"
  *    ),
    *    @OA\Property(
  *      property="name",
  *      type="string",
  *      format="",
  *      description="Action Plan ID"
  *    ),
    *    @OA\Property(
  *      property="city",
  *      type="string",
  *      format="",
  *      description="Action Plan ID"
  *    ),
    *    @OA\Property(
  *      property="country",
  *      type="string",
  *      format="",
  *      description="Action Plan ID"
  *    ),
    *    @OA\Property(
  *      property="startDate",
  *      type="string",
  *      format="",
  *      description="Action Plan ID"
  *    ),
    *    @OA\Property(
  *      property="endDate",
  *      type="string",
  *      format="",
  *      description="Action Plan ID"
  *    )
  * ),
 *     ),
     *        ),
     *     @OA\Response(response="400", description="bad request"),
     * )
     */
    public function readEvent(){   
       
        // if term and date is passed
        if(!empty($this->term) && !empty($this->date)){
            $filterArray = array_filter($this->jsonData, function ($event){
                $searchtime = strtotime($this->date); 
                $rangeStart = strtotime($event['startDate']); 
                $rangeEnd = strtotime($event['endDate']);
                return (((strtolower($event['city']) == strtolower($this->term)) || (strtolower($event['country']) == strtolower($this->term))) && 
                ($rangeStart <= $searchtime && $rangeEnd >= $searchtime));
            });
        return $filterArray;
        }

        // if only date is passed
        if(empty($this->term) && !empty($this->date)){
           $filterArray = array_filter($this->jsonData, function ($event){
            $searchtime = strtotime($this->date);
         $rangeStart = strtotime($event['startDate']); 
         $rangeEnd = strtotime($event['endDate']);  
            return ($rangeStart <= $searchtime && $rangeEnd >= $searchtime);
        });
    return $filterArray;
        }

        // if only term is passed
        if(!empty($this->term) && empty($this->date)){
            $filterArray = array_filter($this->jsonData, function ($event){
                return (strtolower($event['city']) == strtolower($this->term)) || (strtolower($event['country']) == strtolower($this->term));
            });
        return $filterArray;
        }
     return array();
    }
}

?>
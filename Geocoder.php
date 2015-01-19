<?php
/**
 * Created by PhpStorm.
 * User: Luke
 * Date: 3-23-2014
 * Time: 8:58 PM
 */

class Geocoder {

    protected $services = [
        0 => 'bing'
    ];
    protected $activeService;

    public function getServices (){
        return $this->services;
    }
    public function setActiveService($serviceNumber){
        // Is the service number a numeric value?
        if (!is_numeric($serviceNumber)){
            echo "Please enter a numeric value which corresponds to a service.";
        }
        else {
            // Is the service number within range?
            if($serviceNumber > count($this->services)){
                echo "Service number is not within range.";
                return false;
            }
            else {
                $this->activeService = $this->services[$serviceNumber];
            }
        }
    }

    public function geocodeData ($queryParams){
        $queryString = '?';
        $queryParamsConcat = [];
        foreach ($queryParams as $key => $value){
            $queryParamsConcat[] = $key."=".$value;
        }
        $queryString .= implode("&",$queryParamsConcat);
        switch ($this->activeService){
            case 0:
                $this->queryMapServiceBing($queryString);
                break;

        }
    }
    private function queryMapServiceBing($queryString) {
        $response = file_get_contents("http://dev.virtualearth.net/REST/v1/Locations" . $queryString . "?output=json&key=AljqW1cjjdghI9Qis_Weh0wF0sq-4b-G5YKg0MvSQO9ifZxPL6_n9bEVXTf0QBBz");
        if (!$response) {
            die();
        }
        $responseAsJSON = json_decode($response, true);
        if (!empty($responseAsJSON['resourceSets'][0]['resources'])) {
            $this->queryCount++;
        }
        return $responseAsJSON;
    }
} 
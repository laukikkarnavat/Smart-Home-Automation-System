<?php

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST') {

    if(isset($_POST['username']) and isset($_POST['zipcode'])) {

        $response = file_get_contents('https://api.weatherbit.io/v2.0/forecast/3hourly?postal_code=28262&key=c26005fced314770ab95a3315c71a922');
        $response = json_decode($response, true);
        $specificResponse["Day1"] = $response['data'][0];
        $specificResponse["Day2"] = $response['data'][8];
        $specificResponse["Day3"] = $response['data'][16];
        $specificResponse["Day4"] = $response['data'][24];
        $specificResponse["Day5"] = $response['data'][32];
    }
   // echo json_encode($response['data'][0]['temp']);
}
echo json_encode($specificResponse);
//print  $response;
//echo json_encode($response['message']);

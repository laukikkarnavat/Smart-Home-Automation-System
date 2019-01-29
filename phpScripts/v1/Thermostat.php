<?php

require_once '../includes/DbOperations.php';

$response = array();


if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($_POST['username']) and isset($_POST['floorNo']) and isset($_POST['modestatus']) and isset($_POST['fanstatus']))
    {
        $db = new DbOPerations();
        $status = $db->updateThermostat($_POST['username'],$_POST['floorNo'],$_POST['modestatus'],$_POST['fanstatus']);
        $response['modeMainFloor'] = $status['mainFloorMode'];
        $response['fanMainFloor'] = $status['mainFloorFan'];
        $response['modeUpstairs'] = $status['upstairsMode'];
        $response['fanUpstairs'] =  $status['upstairsFan'];
    }
}
echo json_encode($response);
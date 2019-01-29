<?php

require_once '../includes/DbOperations.php';

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($_POST['username']))
    {
        $db = new DbOperations();
        $status = $db->getSecuritySystemStatus($_POST['username']);
        $response['securityStatus'] = $status['securityType'];

    }

    if(isset($_POST['username']))
    {
        $db = new DbOperations();
        $status = $db->getWindowSensorStatus($_POST['username']);
        $response['windowStatus'] = $status['windowstatus'];

    }

    if(isset($_POST['username']))
    {
        $db = new DbOperations();
        $status = $db->getGarageStatus($_POST['username']);
        $response['garageDoor1'] = $status['door1'];
        $response['garageDoor2'] = $status['door2'];
    }

    if(isset($_POST['username']))
    {
        $db = new DbOperations();
        $status = $db->getElectricApplianceStatus($_POST['username']);
        $response['fanStatus'] = $status['appFan'];
        $response['refrigeratorStatus'] = $status['appRefrigerator'];
    }

    if(isset($_POST['username']))
    {
        $db = new DbOperations();
        $status = $db->getLockStatus($_POST['username']);
        $response['Lock1status'] = $status['FrontDoor'];
        $response['Lock2status'] = $status['BackDoor'];
        $response['Lock3status'] = $status['GarageDoor'];
    }


    if(isset($_POST['username']))
    {
        $db = new DbOperations();
        $status = $db->getLightStatus($_POST['username']);
        $response['mainfloorlight'] = $status['MainFloor'];
        $response['upstairlight'] = $status['Upstairs'];

    }

    if(isset($_POST['username']))
    {
        $db = new DbOperations();
        $status = $db->getMotionDetectorStatus($_POST['username']);
        $response['detectorMainFloor'] = $status['MainFloorMotion'];
        $response['detectorUpstairs'] = $status['UpstairsMotion'];

    }

   if(isset($_POST['username']))
    {
        $db = new DbOperations();
        $status = $db->getThermostatStatus($_POST['username']);
        $response['modeMainFloor'] = $status['mainFloorMode'];
        $response['fanMainFloor'] = $status['mainFloorFan'];
        $response['modeUpstairs'] = $status['upstairsMode'];
        $response['fanUpstairs'] = $status['upstairsFan'];

    }
}

echo json_encode($response);
//echo json_encode($response2);
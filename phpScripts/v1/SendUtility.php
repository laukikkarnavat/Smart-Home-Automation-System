<?php

require_once '../includes/DbOperationsUtilities.php';

$response = array();



if($_SERVER['REQUEST_METHOD']=='POST') {
    if (isset($_POST['username']) and isset
        ($_POST['securityType']) and isset
        ($_POST['garageDoorNo']) and isset($_POST['garageDoorStatus']) and isset
        ($_POST['lightFloor']) and isset($_POST['lightStatus']) and isset
        ($_POST['appType']) and isset($_POST['appStatus']) and isset
        ($_POST['floorNo']) and isset($_POST['modestatus']) and isset($_POST['fanstatus']) and isset
        ($_POST['date'])) {

        $db = new DbOperationsUtilities();
        $db->addApplianceStatus($_POST['username'],
            $_POST['securityType'],
            $_POST['garageDoorNo'],$_POST['garageDoorStatus'],
            $_POST['lightFloor'],$_POST['lightStatus'],
            $_POST['appType'],$_POST['appStatus'],
            $_POST['floorNo'],$_POST['modestatus'],$_POST['fanstatus'],
            $_POST['date']);
    $response ="HELLO WORLD";
    }
    else{
        $response = "No response";
    }

}

/*
if($_SERVER['REQUEST_METHOD']=='POST') {
    if (isset($_POST['username']) and isset($_POST['securityType']))
    {
        $response ="correct response";
    }
    else
        {
        $response ="no response";
    }

}
*/


echo json_encode($response);



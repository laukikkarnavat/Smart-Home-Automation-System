<?php

require_once '../includes/DbOperations.php';

$response = array();


if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($_POST['username']) and isset($_POST['garageDoorNo']) and isset($_POST['garageDoorStatus']))
    {
        $db = new DbOperations();
        $status = $db->updateGarageDoor($_POST['username'],$_POST['garageDoorNo'],$_POST['garageDoorStatus']);
        $response['message1'] = $status['door1'];
        $response['message2'] = $status['door2'];
    }
}
echo json_encode($response);
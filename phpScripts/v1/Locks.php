<?php

require_once '../includes/DbOperations.php';

$response = array();


if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($_POST['username']) and isset($_POST['doorType']) and isset($_POST['doorStatus']))
    {
        $db = new DbOperations();
        $status = $db->updateLocks($_POST['username'],$_POST['doorType'],$_POST['doorStatus']);
        $response['messageLock1'] = $status['FrontDoor'];
        $response['messageLock2'] = $status['BackDoor'];
        $response['messageLock3'] = $status['GarageDoor'];
    }
}
echo json_encode($response);
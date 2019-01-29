<?php

require_once '../includes/DbOperations.php';

$response = array();


if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($_POST['username']) and isset($_POST['lightFloor']) and isset($_POST['lightStatus']))
    {
        $db = new DbOperations();
        $status = $db->updateLight($_POST['username'],$_POST['lightFloor'],$_POST['lightStatus']);
        $response['mainfloorlight'] = $status['MainFloor'];
        $response['upstairlight'] = $status['Upstairs'];
    }
}
echo json_encode($response);
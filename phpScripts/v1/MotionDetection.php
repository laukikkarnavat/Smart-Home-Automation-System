<?php

require_once '../includes/DbOperations.php';

$response = array();


if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($_POST['username']) and isset($_POST['motionFloor']) and isset($_POST['motionStatus']))
    {
        $db = new DbOperations();
        $status = $db->updateMotionDetection($_POST['username'],$_POST['motionFloor'],$_POST['motionStatus']);
        $response['message33'] = $status['MainFloorMotion'];
        $response['message44'] = $status['UpstairsMotion'];
    }
}
echo json_encode($response);
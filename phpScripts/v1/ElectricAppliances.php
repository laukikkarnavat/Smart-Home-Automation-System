<?php

require_once '../includes/DbOperations.php';

$response = array();


if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($_POST['username']) and isset($_POST['appType']) and isset($_POST['appStatus']))
    {
        $db = new DbOperations();
        $status = $db->updateElectricAppliances($_POST['username'],$_POST['appType'],$_POST['appStatus']);
        $response['messageApp1'] = $status['appFan'];
        $response['messageApp2'] = $status['appRefrigerator'];
    }
}
echo json_encode($response);
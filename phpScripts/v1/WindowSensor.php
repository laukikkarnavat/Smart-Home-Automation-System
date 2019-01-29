<?php

require_once '../includes/DbOperations.php';

$response = array();


if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($_POST['username']) and isset($_POST['windowstatus']))
    {
        $db = new DbOperations();
      $status['windowSensor'] = $db->updateWindowSensor($_POST['username'],$_POST['windowstatus']);

        $response['window'] = $status['windowSensor'];

    }
}
echo json_encode($response);

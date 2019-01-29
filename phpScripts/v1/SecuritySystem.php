<?php

require_once '../includes/DbOperations.php';

$response = array();


if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($_POST['username']) and isset($_POST['securityType']))
    {
        $db = new DbOperations();
        $status['securitySystem'] = $db->updateSecuritySystem($_POST['username'],$_POST['securityType']);
        $response['message'] = $status['securitySystem'];

    }
}
echo json_encode($response);
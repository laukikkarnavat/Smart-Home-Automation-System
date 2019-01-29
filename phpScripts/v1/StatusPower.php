<?php

require_once '../includes/DbOperationsPower.php';

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST') {
    if (isset($_POST['username'])) {
        $db = new DbOperationsPower();
        $status = $db->getPowerData($_POST['username']);
        $response = $status;


    }
}


echo json_encode($response);
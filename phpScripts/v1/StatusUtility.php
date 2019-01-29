<?php

require_once '../includes/DbOperationsUtilities.php';

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST') {
    if (isset($_POST['username'])) {
        $db = new DbOperationsUtilities();
        $status = $db->getUtilityData($_POST['username']);
        $response = $status;


    }
}

echo json_encode($response);
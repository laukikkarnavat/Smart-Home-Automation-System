<?php

require_once '../includes/DbOperationsPower.php';

$response = array();



if($_SERVER['REQUEST_METHOD']=='POST') {
    if (isset($_POST['username']) and isset($_POST['powerData']) and isset($_POST['date'])) {

        $db = new DbOperationsPower();
        $db->powerUsed($_POST['username'], $_POST['powerData'], $_POST['date']);
        $response ="HELLO POWER";
    }
    else{
        $response = "No POWER";
    }

}

echo json_encode($response);
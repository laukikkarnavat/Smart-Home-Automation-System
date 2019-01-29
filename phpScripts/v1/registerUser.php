<?php

require_once '../includes/DbOperations.php';

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(
        isset($_POST['username']) and
            isset($_POST['password']) and
                isset($_POST['name']) and
                   isset($_POST['role']))

        {
        //operate the data further

$db = new DbOperations();
 $result =$db->createUser(   $_POST['username'],
                                    $_POST['password'],
                                    $_POST['name'],
                                    $_POST['role']
                                );



        if($result == 1)
{
$response['error'] = false;
       $response['message'] = "User registered successfully";

}
if($result == 2)
{

$response['error'] = "true2";
       $response['message'] = "Some error occurred please try again";
}
if($result == 0)
{

$response['error'] = "true3";
       $response['message'] = "Username already exists please choose a different username";
}
            }
      else
       {
       $response['error'] = true;
       $response['message'] = "Required fields are missing";
       }
}else{
  $response['error'] = true;
       $response['message'] = "Invalid Request";
}

echo json_encode($response);
<?php

class DbOperationsUtilities
{

    private $con;

    function __construct()
    {

        require_once dirname(__FILE__) . '/DbConnectUtilities.php';

        $db = new DbConnectUtilities();

        $this->con = $db->connect();

    }

    public function  addApplianceStatus($username,$securitySystem,$garageDoor1,$garageDoor2, $LightMainFloor, $LightUpstairs, $applianceFan, $applianceRefrigerator, $mainFloorMode, $mainFloorFan, $upstairsMode, $upstairsFan, $date)
    {
        $setValues = $this->con->prepare("INSERT INTO `CustomerHomeAppliances` (`Username`,`securityType`,`door1`,`door2`, `MainFloor`,`Upstairs`, `appFan`,`appRefrigerator`, `mainFloorMode`,`mainFloorFan`,`upstairsMode`,`upstairsFan`, `Date`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $setValues->bind_param("sssssssssssss",$username,$securitySystem,$garageDoor1,$garageDoor2, $LightMainFloor, $LightUpstairs, $applianceFan, $applianceRefrigerator, $mainFloorMode, $mainFloorFan, $upstairsMode, $upstairsFan, $date);
        $setValues->execute();
    }
/*
    public function getUtilityData($username)
    {
        $stmt = array();
        while ($row = mysqli_fetch_array($stmt))
        {

        $stmt[] = $this->con->prepare("SELECT * from CustomerHomeAppliances");
        //   $stmt->bind_param("s", $username);
        $stmt->execute();
    }
        return $stmt->get_result()->fetch_assoc();
    }
*/
    /*public function getUtilityData($username)
    {
        $stmt = array();
        while ($row = mysqli_fetch_array($stmt))
        {

            $stmt[] = $this->con->prepare("SELECT * from CustomerHomeAppliances");
            //   $stmt->bind_param("s", $username);
            $stmt->execute();
        }
        return $stmt->get_result()->fetch_assoc();
    }*/


    public function getUtilityData($username)
    {

        $stmt = $this->con->prepare("SELECT * from CustomerHomeAppliances where username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
       return $stmt->get_result()->fetch_all();   //THIS LINE IS CRITICAL

    }

    }
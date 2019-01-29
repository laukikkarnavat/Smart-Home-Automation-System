<?php

class DbOperationsPower
{

    private $con;

    function __construct()
    {

        require_once dirname(__FILE__) . '/DbConnectPower.php';

        $db = new DbConnectPower();

        $this->con = $db->connect();

    }

    public function powerUsed($username,$power,$date)
    {
        $setValues = $this->con->prepare("INSERT INTO `PowerUtilization` (`Username`,`PowerUsed`,`Date`) VALUES (?,?,?)");
        $setValues->bind_param("sss",$username,$power,$date);
        $setValues->execute();
    }

    public function getPowerData($username)
    {
        $stmt =$this->con->prepare("SELECT * from PowerUtilization where username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_all();
    }
}
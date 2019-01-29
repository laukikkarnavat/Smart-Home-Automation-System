<?php 
 
    class DbOperations
    {

        private $con;

        function __construct()
        {

            require_once dirname(__FILE__) . '/DbConnect.php';

            $db = new DbConnect();

            $this->con = $db->connect();

        }

        public function createUser($username, $pass, $name, $role)
        {
            if ($this->isUserExist($username)) {
                return 0;
            } else {               // $password = md5($pass); this line is for encryption of password
                $stmt = $this->con->prepare("INSERT INTO `User` (`username`, `password`, `name`, `role`) VALUES (?, ?, ?, ?);");
                $stmt->bind_param("ssss", $username, $pass, $name, $role);

                if ($stmt->execute()) {

//For Security System
                    $securitySystem = "DISARMED";
                    $x = $this->con->prepare("INSERT INTO `SecuritySystem` (`username`,`securityType`) VALUES (?,?)");
                    $x->bind_param("ss", $username, $securitySystem);
                    $x->execute();


//for Garage doors
                    $garageDoor1 = "CLOSED";
                    $garageDoor2 = "CLOSED";
                    $garage = $this->con->prepare("INSERT INTO `GarageDoor` (`username`,`door1`,`door2`) VALUES (?,?,?)");
                    $garage->bind_param("sss", $username, $garageDoor1, $garageDoor2);
                    $garage->execute();


//For Motion Detection
                    $motionMainFloor = "ACTIVE";
                    $motionUpstairs = "ACTIVE";
                    $motionDetector = $this->con->prepare("INSERT INTO `MotionDetection` (`username`,`MainFloorMotion`,`UpstairsMotion`) VALUES (?,?,?)");
                    $motionDetector->bind_param("sss", $username, $motionMainFloor, $motionUpstairs);
                    $motionDetector->execute();


//For Window
                    $windowSensor = "OPEN";
                    $window = $this->con->prepare("INSERT INTO `WindowSensor` (`username`,`windowstatus`) VALUES (?,?)");
                    $window->bind_param("ss", $username, $windowSensor);
                    $window->execute();


//For Locks
                    $lockFrontDoor = "LOCKED";
                    $lockBackDoor = "LOCKED";
                    $lockGarageDoor = "LOCKED";
                    $lk = $this->con->prepare("INSERT INTO `Locks` (`username`,`FrontDoor`,`BackDoor`, `GarageDoor`) VALUES (?,?,?,?)");
                    $lk->bind_param("ssss", $username, $lockFrontDoor, $lockBackDoor, $lockGarageDoor);
                    $lk->execute();

//For Lights
                    $LightMainFloor = "OFF";
                    $LightUpstairs = "OFF";
                    $light = $this->con->prepare("INSERT INTO `Light` (`username`,`MainFloor`,`Upstairs`) VALUES (?,?,?)");
                    $light->bind_param("sss", $username, $LightMainFloor, $LightUpstairs);
                    $light->execute();


//For Electric Appliance

                    $applianceFan = "ON";
                    $applianceRefrigerator = "ON";
                    $electricApp = $this->con->prepare("INSERT INTO `ElectricAppliances` (`username`,`appFan`,`appRefrigerator`) VALUES (?,?,?)");
                    $electricApp->bind_param("sss", $username, $applianceFan, $applianceRefrigerator);
                    $electricApp->execute();

//For Thermostat


                    $mainFloorMode = "Mode Off";
                    $mainFloorFan = "Fan Off";
                    $upstairsMode = "Mode Off";
                    $upstairsFan = "Fan Off";
                    $thermostat = $this->con->prepare("INSERT INTO `Thermostat`(`username`,`mainFloorMode`,`mainFloorFan`,`upstairsMode`,`upstairsFan`) VALUES (?,?,?,?,?)");
                    $thermostat->bind_param("sssss", $username, $mainFloorMode, $mainFloorFan, $upstairsMode, $upstairsFan);
                    $thermostat->execute();


                    return 1;
                } else {
                    return 2;
                }

            }
        }

        public function userLogin($username, $pass)
        {

            $stmt = $this->con->prepare("SELECT * from User where username = ? AND password = ?");
            $stmt->bind_param("ss", $username, $pass);
            $stmt->execute();
            $stmt->store_result();
            return $stmt->num_rows > 0;

        }

        public function getUserByUsername($username)
        {
            $stmt = $this->con->prepare("SELECT * FROM User where username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        private function isUserExist($username)
        {
            $stmt = $this->con->prepare("SELECT * FROM User WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();
            return $stmt->num_rows > 0;
        }



    //FOR GARAGE

    public function updateGarageDoor($username, $garageDoorNo, $garageDoorStatus)
    {
        if ($garageDoorNo === "Garage 1") {
            $stmt = $this->con->prepare("UPDATE GarageDoor set door1 = ? where username = ?");

        }
        if ($garageDoorNo === "Garage 2") {
            $stmt = $this->con->prepare("UPDATE GarageDoor set door2 = ? where username = ?");

        }
        $stmt->bind_param("ss", $garageDoorStatus, $username);
        $stmt->execute();
        $stmt->store_result();

        $stmt2 = $this->con->prepare("SELECT * from GarageDoor where username = ?");
        $stmt2->bind_param("s", $username);
        $stmt2->execute();
        return $stmt2->get_result()->fetch_assoc();
    }


    //For Lights

    public function updateLight($username, $lightFloor, $lightStatus)
    {
        if ($lightFloor === "Main Floor") {
            $stmt = $this->con->prepare("UPDATE Light set MainFloor = ? where username = ?");

        }
        if ($lightFloor === "Upstairs") {
            $stmt = $this->con->prepare("UPDATE Light set Upstairs = ? where username = ?");

        }
        $stmt->bind_param("ss", $lightStatus, $username);
        $stmt->execute();
        $stmt->store_result();

        $stmt2 = $this->con->prepare("SELECT * from Light where username = ?");
        $stmt2->bind_param("s", $username);
        $stmt2->execute();
        return $stmt2->get_result()->fetch_assoc();
    }


    // For Motion Detection

    public function updateMotionDetection($username, $motionFloor, $motionStatus)
    {
        if ($motionFloor === "Main Floor") {
            $stmt = $this->con->prepare("UPDATE MotionDetection set MainFloorMotion = ? where username = ?");

        }
        if ($motionFloor === "Upstairs") {
            $stmt = $this->con->prepare("UPDATE MotionDetection set UpstairsMotion = ? where username = ?");

        }
        $stmt->bind_param("ss", $motionStatus, $username);
        $stmt->execute();
        $stmt->store_result();

        $stmt2 = $this->con->prepare("SELECT * from MotionDetection where username = ?");
        $stmt2->bind_param("s", $username);
        $stmt2->execute();
        return $stmt2->get_result()->fetch_assoc();
    }
//For Security System

    public function updateSecuritySystem($username, $securityType)
    {
        $stmt = $this->con->prepare("UPDATE SecuritySystem set securityType = ? where username = ?");
        $stmt->bind_param("ss", $securityType, $username);
        $stmt->execute();
        $stmt->store_result();

        $stmt2 = $this->con->prepare("SELECT * from SecuritySystem where username = ?");
        $stmt2->bind_param("s", $username);
        $stmt2->execute();

        return $stmt2->get_result()->fetch_assoc();
    }

    //For WindowSensor

    public function updateWindowSensor($username, $windowstatus)
    {
        $stmt = $this->con->prepare("UPDATE WindowSensor set windowstatus = ? where username = ?");
        $stmt->bind_param("ss", $windowstatus, $username);
        $stmt->execute();
        $stmt->store_result();

        $stmt2 = $this->con->prepare("SELECT * from WindowSensor where username = ?");
        $stmt2->bind_param("s", $username);
        $stmt2->execute();

        return $stmt2->get_result()->fetch_assoc();
    }

    //For Locks
    public function updateLocks($username, $doorType, $doorStatus)
    {
        if ($doorType === "Front Door") {
            $stmt = $this->con->prepare("UPDATE Locks set FrontDoor = ? where username = ?");

        }
        if ($doorType === "Back Door") {
            $stmt = $this->con->prepare("UPDATE Locks set BackDoor = ? where username = ?");

        }
        if ($doorType === "Garage Door") {
            $stmt = $this->con->prepare("UPDATE Locks set GarageDoor = ? where username = ?");

        }
        $stmt->bind_param("ss", $doorStatus, $username);
        $stmt->execute();
        $stmt->store_result();

        $stmt2 = $this->con->prepare("SELECT * from Locks where username = ?");
        $stmt2->bind_param("s", $username);
        $stmt2->execute();
        return $stmt2->get_result()->fetch_assoc();
    }

    //For Electric Appliance

    public function updateElectricAppliances($username, $appType, $appStatus)
    {

        if ($appType === "FAN") {
            $stmt = $this->con->prepare("UPDATE ElectricAppliances set appFan = ? where username = ?");

        }
        if ($appType === "REFRIGERATOR") {
            $stmt = $this->con->prepare("UPDATE ElectricAppliances set appRefrigerator = ? where username = ?");

        }
        $stmt->bind_param("ss", $appStatus, $username);
        $stmt->execute();
        $stmt->store_result();

        $stmt2 = $this->con->prepare("SELECT * from ElectricAppliances where username = ?");
        $stmt2->bind_param("s", $username);
        $stmt2->execute();
        return $stmt2->get_result()->fetch_assoc();
    }


    //For Thermostat

   public function updateThermostat($username,$floorNo,$modestatus, $fanstatus)
    {
        if ($floorNo == "Main Floor") {
            $stmt = $this->con->prepare("UPDATE Thermostat set mainFloorMode = ?, mainFloorFan =? where username = ?");
            $stmt->bind_param("sss", $modestatus, $fanstatus, $username);
            $stmt->execute();
            $stmt->store_result();
        }

        if ($floorNo == "Upstairs") {
            $stmt = $this->con->prepare("UPDATE Thermostat set upstairsMode = ?, upstairsFan =? where username = ?");
            $stmt->bind_param("sss", $modestatus, $fanstatus, $username);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
            //$stmt->store_result();
        }
    }


       /* ///thermostat
        public function updateThermostat($username,$floorNo,$modestatus, $fanstatus)
    {
        if($floorNo == "Main Floor")
        {
            $stmt = $this->con->prepare("UPDATE Thermostat set mainFloorMode = ?, mainFloorFan =? where username = ?");

        }

        if($floorNo == "Upstairs")
        {
            $stmt = $this->con->prepare("UPDATE Thermostat set upstairsMode = ?, upstairsFan =? where username = ?");
            $stmt->bind_param("sss",$modestatus, $fanstatus, $username);
            $stmt->execute();
            $stmt->store_result();
        }

        $stmt->bind_param("sss",$modestatus, $fanstatus, $username);
        $stmt->execute();
        $stmt->store_result();

        $stmt2 = $this->con->prepare("SELECT * from Thermostat where username = ?");
        $stmt2->bind_param("s", $username);
        $stmt2->execute();
        return $stmt2->get_result()->fetch_assoc();
    }*/


    //THE BELOW IS TO GET STATUS

    public function getSecuritySystemStatus($username)
    {
        $stmt = $this->con->prepare("SELECT * from SecuritySystem where username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }


    public function getWindowSensorStatus($username)
    {
        $stmt = $this->con->prepare("SELECT * from WindowSensor where username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }


    public function getGarageStatus($username)
    {
        $stmt = $this->con->prepare("SELECT * from GarageDoor where username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function getElectricApplianceStatus($username)
    {
        $stmt = $this->con->prepare("SELECT * from ElectricAppliances where username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function getLockStatus($username)
    {
        $stmt = $this->con->prepare("SELECT * from Locks where username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function getLightStatus($username)
    {
        $stmt = $this->con->prepare("SELECT * from Light where username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function getMotionDetectorStatus($username)
    {
        $stmt = $this->con->prepare("SELECT * from MotionDetection where username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function getThermostatStatus($username)
    {
        $stmt = $this->con->prepare("SELECT * from Thermostat where username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    }



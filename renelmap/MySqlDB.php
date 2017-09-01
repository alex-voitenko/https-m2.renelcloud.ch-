<?php
//include_once 'config.php';
//include_once 'LogFile.php';
 
//set_time_limit(180);

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 
/**
 * Description of DBAccess
 
 */
class MySqlDB {
    
    private $dbname;
    private $host;
    private $port;
    private $user;
    private $password;
    private $dbconnection = null;
    
    public function MySqlDB() {
        logToFile(logfile(), 'Executing MySqlDB Constructor(\'' . mysqlDBName() . '\').');
        $this->dbname = mysqlDBName();
        $this->host = mysqlHost();
        $this->port = mysqlDBPort();
        $this->user = mysqlUsr();
        $this->password = mysqlPwd();
        $this->connect();
    }
    
    function __set($propName, $propValue) {
        $this->$propName = $propValue;
    }

    public function get_dbname() {
        return $this->dbname;
    }
    
    public function get_host() {
        return $this->host;
    }

    public function get_user() {
        return $this->user;
    }

    public function connect() {
    logToFile(logfile(), 'Attempt to connect to MySQL DB: ' . $this->dbname);
    $ret = true;
        $this->dbconnection = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        if($this->dbconnection->connect_error){
            logToFile(logfile(), 'Connection to MySQL failed ...');
            die("MySQL Connection failed: " . $this->dbconnection->connect_error);
            $ret = false;
        }
        else {
            logToFile(logfile(), 'SUCCESSFULLY connected to MySQL DB ...');
        }
        return $ret;
    }
    
    public function close() {
        if ($this->dbconnection) {
            mysqli_close($this->dbconnection);
            if(debug()) {
                logToFile(logfile(), 'Connection to MySQL closed ...');
            }
        }
    }
    
    public function dbconnection() {
        return $this->dbconnection;
    }
    
    public function isConnected() {
        return ($this->dbconnection!=null) ? true : false;
    }
}


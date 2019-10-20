<?php 

class DBManager 
{ 
    private static $instance = null;
    private $conn;
    
    private $host = "192.168.64.2";
    private $user = 'app';
    private $pass = 'appdbpasswd';
    private $database = 'flixy';
    
    // The db connection is established in the private constructor.
    private function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->database);
        if ($this->conn->connect_errno) {
            die("Connection to db failed");
        }
    }
    
    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new DBManager();
        }
    
        return self::$instance;
    }
    
    public function getConnection()
    {
        return $this->conn;
    }

    public function query($queryString, $className)
    {
        $res = $this->conn->query($queryString);
        while ($row = $res->fetch_object($className)) {
            
        }
    }
    
    function __destruct() {
        $this->conn->close();
    }
}

?>
<?php
class models_Core_Database{
    public $server = "localhost";
    public $username = "root";
    public $password = "";
    public $dbname = "internship_project";
    public $port = 3307;
    protected $conn = null;

    public function connect(){
        if($this->conn === null){
            $this->conn = mysqli_connect($this->server, $this->username, $this->password, $this->dbname, $this->port);

            if(!$this->conn){
                die("Connection failed" . mysqli_connect_error());
            }
        }
        return $this->conn;
    }

    public function insert($query){
        $result = mysqli_query($this->connect(), $query);
        if(!$result){
            return false;
        }
        return mysqli_insert_id($this->connect());
    }

    public function update($query) {
        return mysqli_query($this->connect(), $query);
    }

    public function delete($query) {
        return mysqli_query($this->connect(), $query);
    }

    public function fetchRow($query){
    $result = mysqli_query($this->connect(), $query);
        if(!$result){
            return false;
        }
        return mysqli_fetch_assoc($result);
    }

    public function fetchAll($query) {
        $result = mysqli_query($this->connect(), $query);
        if(!$result){
            return false;
        }

        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }
}
?>
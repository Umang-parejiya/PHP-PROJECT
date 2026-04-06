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

    public function escape($value){
        return mysqli_real_escape_string($this->connect(), $value);
    }

    public function insert($query){
        $result = mysqli_query($this->connect(), $query);
        if($result){
            return mysqli_insert_id($this->connect());
        }
        return false;
    }

    public function update($query) {
        return mysqli_query($this->connect(), $query);
    }

    public function delete($query) {
        return mysqli_query($this->connect(), $query);
    }

    public function fetchRow($query){
        $result = mysqli_query($this->connect(), $query);
        if($result && mysqli_num_rows($result)){
            return mysqli_fetch_assoc($result);
        }
        return false;
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
        return $rows ?: false;
    }

    public function fetchOne($query)
    {
        $row = $this->fetchRow($query);

        if ($row) {
            return array_values($row)[0]; 
        }

        return false;
    }

    public function fetchPairs($query)
    {
        $result = mysqli_query($this->connect(), $query);

        if (!$result) {
            return false;
        }

        $pairs = [];

        while ($row = mysqli_fetch_row($result)) {
            $pairs[$row[0]] = $row[1];
        }

        return $pairs ?: false;
    }
}
?>
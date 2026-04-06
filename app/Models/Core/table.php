<?php
require_once __DIR__ . "/database.php";
class models_Core_Table{
    protected $db = null;
    public $tableName = '';
    public $primaryKey = '';
    public $data = [];

    public function __construct()
    {
        $this->db = new models_Core_Database();
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        return null;
    }
    public function load($value, $column = null)
    {
        $column = $column ?? $this->primaryKey;
        $value = $this->db->escape($value);

        $query = "select * from {$this->tableName} where $column = '$value' limit 1";
        $row = $this->db->fetchRow($query);

        if ($row) {
            $this->data = $row;
            return $this;
        }
        return false;
    }
    public function fetchRow($query)
    {
        $result = $this->db->fetchRow($query);
        if ($result) {
            $this->data = $result;
            return $this;
        }
        return false;
    }
    public function fetchAll()
    {
        $query = "select * from {$this->tableName}";
        // $rows = []; 
        $rows = $this->db->fetchAll($query);
        if ($rows) {
            foreach ($rows as $key => $value) {
                $obj = new static();
                $obj->data = $value;
                $rows[$key] = $obj;
                // $rows[] = $obj;
            }
            return $rows;
        }
        return false;
    }
    public function insert()
    {
        $column = implode(",", array_keys($this->data));
        $values = array_map(function ($v) {
            return "'" . $this->db->escape($v) . "'";
        }, array_values($this->data));

        $values = implode(",", $values);

        $query = "insert into {$this->tableName} ($column) values ($values)";
        $id = $this->db->insert($query);

        if ($id) {
            $this->data[$this->primaryKey] = $id;
            return $this;
        }

        return false;
    }

    public function update()
    {
        if (!isset($this->data[$this->primaryKey])) {
            return false;
        }

        $id = $this->data[$this->primaryKey];
        $data = $this->data;

        unset($data[$this->primaryKey]);

        $set = [];
        foreach ($data as $key => $value) {
            $value = $this->db->escape($value);
            $set[] = "$key='$value'";
        }

        $set = implode(",", $set);
        $query = "update {$this->tableName} set $set where {$this->primaryKey} = '$id'";
        
        if ($this->db->update($query)) {
            return $this;
        }
        return false;
    }
    public function delete()
    {
        if (!isset($this->data[$this->primaryKey])) {
            return false;
        }

        $id = $this->data[$this->primaryKey];
        $query = "delete from {$this->tableName} where {$this->primaryKey} = $id";
        return $this->db->delete($query);
    }

    public function save()
    {
        if (empty($this->data[$this->primaryKey])) {
            $this->data['created_date'] = date("Y-m-d H:i:s");
            return $this->insert();
        } else {
            $this->data['updated_date'] = date("Y-m-d H:i:s");
            return $this->update();
        }
    }

    public function getAll()
    {
        return $this->fetchAll();
    }
}
?>
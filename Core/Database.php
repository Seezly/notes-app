<?php

/*
 *** Database class for handling database connections and queries
*/

namespace Core;

class Database
{
    public $db;
    public $host;
    public $username;
    public $password;
    public $dbname;
    public $dsn;
    public $conn;
    public $statement;

    public function __construct($host, $username, $password, $dbname, $db = 'mysql')
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->db = $db;
        $this->dsn = "{$this->db}:host={$this->host};dbname={$this->dbname}";

        try {
            $connection = new \PDO($this->dsn, $this->username, $this->password);
            $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $this->conn = $connection;
        } catch (\Throwable $th) {
            throw $th;
            die();
        }
    }

    public function query($sql, $params = [])
    {
        try {
            $pdo = $this->conn;

            $this->statement = $pdo->prepare($sql);
            $this->statement->execute($params);

            return $this;
        } catch (\Throwable $th) {
            throw $th;
            die();
        }
    }

    /* 
        ** Fetching data methods
    */

    public function getAll($fetchStyle = \PDO::FETCH_ASSOC)
    {
        return $this->statement->fetchAll($fetchStyle);
    }

    public function getOne($fetchStyle = \PDO::FETCH_ASSOC)
    {
        return $this->statement->fetch($fetchStyle);
    }

    public function getRowCount()
    {
        return $this->statement->rowCount();
    }

    public function getOneOrFail()
    {
        $result = $this->getOne();

        if (!$result) {
            abort();
        }

        return $result;
    }

    /* 
        ** Inserting, updating, deleting data methods
    */

    public function insert($sql, $params = [])
    {
        return $this->query($sql, $params);
    }

    public function update($sql, $params = [])
    {
        return $this->query($sql, $params);
    }

    public function delete($sql, $params = [])
    {
        return $this->query($sql, $params);
    }
}

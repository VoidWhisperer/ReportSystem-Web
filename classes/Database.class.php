<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/31/2016
 * Time: 3:36 PM
 */
class Database
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $pdo;

    private $currentBindParams = array();

    /**
     * @var PDOStatement
     */
    private $currentQuery = null;

    /**
     * Database constructor.
     * @param $host
     * @param $username
     * @param $password
     * @param $database
     */
    public function __construct($host, $username, $password, $database)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        $pdo = new PDO("mysql:host=".$this->host,$this->username,$this->password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $this->checkDatabase();
        $this->pdo = $pdo;
    }

    /**
     * Check/Create the database if it doesn't exist, then use it
     */
    private function checkDatabase() {
        $this->pdo->query("CREATE DATABASE IF NOT EXISTS $this->database");
        $this->pdo->query("USE $this->database");
    }

    public function query($query) {
        $this->currentBindParams = array();
        $this->currentQuery = $this->pdo->prepare($query);
    }

    public function bind($name,$value) {
        if(!is_null($this->currentQuery)) {
            $this->currentQuery->bindValue($name,$value);
            return true;
        }else{
            return false;
        }
    }

    public function exec() {
        if(!is_null($this->currentQuery)) {
            $this->currentQuery->execute();
            return true;
        }
        return false;
    }

}
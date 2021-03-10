<?php

class ActiveRecord
{
    //всё, что нужно для подключения
    protected $dbConfig = [];

    public function setDbConfig($host, $user, $pass, $db, $table)
    {
        $this->dbConfig["host"] = $host;
        $this->dbConfig["user"] = $user;
        $this->dbConfig["pass"] = $pass;
        $this->dbConfig["db"] = $db;
        $this->dbConfig["table"] = $table;
    }

    //метод подключения к БД
    private function initConnDb()
    {
        $mysqli = new mysqli($this->dbConfig["host"], $this->dbConfig["user"], $this->dbConfig["pass"]);
        $mysqli->select_db($this->dbConfig["db"]);
        $mysqli->set_charset("utf8");
        if ($mysqli->connect_errno) {
            die("Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
        }
        return $mysqli;
    }

    //CREATE
    function createDB()
    {
        $db = $this->dbConfig["db"];
        $query = "CREATE DATABASE IF NOT EXISTS $db;";
        $this->initConnDb()->query($query);
    }

    function createTable($keys)
    {
        $table = $this->dbConfig["table"];
        $query = "CREATE TABLE IF NOT EXISTS $table (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, ";
            foreach ($keys as $value) {
                $query .= "$value VARCHAR(255) default NULL, ";
            }
            $query = substr($query, 0, -2);
        $query .= ");";
        $this->initConnDb()->query($query);
    }

    //INSERT
    function insert($keys, $values)
    {
        $table = $this->dbConfig["table"];
        $query = "INSERT INTO $table (";
            foreach ($keys as $value) {
                $query .= "$value, ";
            }
            $query = substr($query, 0, -2);
            $query .= ") VALUES (";
            foreach ($values as $value) {
                $query .= "$value, ";
            }
            $query = substr($query, 0, -2);
        $query .= ");";
        $this->initConnDb()->query($query);
    }

    //SELECT
    function readAll()
    {
        $table = $this->dbConfig["table"];
        $query = "SELECT * FROM $table;";
        $this->initConnDb()->query($query);
    }

    function read($fields)
    {
        $table = $this->dbConfig["table"];
        $query = "SELECT ";
        foreach ($fields as $value) {
            $query .= "$value, ";
        }
        $query = substr($query, 0, -2);
        $query .= " FROM $table";
        $this->initConnDb()->query($query);
    }

    //UPDATE
    function update($key, $value, $where_key, $where_value)
    {
        $table = $this->dbConfig["table"];
        $query = "UPDATE $table SET $key =$value WHERE $where_key=$where_value;";
        $this->initConnDb()->query($query);
    }

    //DELETE
    function delete($key, $value)
    {
        $table = $this->dbConfig["table"];
        $query = "DELETE FROM $table WHERE $key=$value;";
        $this->initConnDb()->query($query);
    }

}
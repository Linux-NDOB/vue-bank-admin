<?php

class Database {
    protected static $instance;
    protected $connection;

    protected function __construct() {}

    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new self();
            self::$instance->initConnection();
        }
        return self::$instance->getConnection();
    }

    protected function initConnection() {
        $db_info = array("db_host" => "localhost","db_user" => "root","db_pass" => "","db_name" => "gestor");

        $this->connection = new mysqli($db_info['db_host'], $db_info['db_user'], $db_info['db_pass'], $db_info['db_name']);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }

        $this->setCharsetEncoding();
    }

    protected function setCharsetEncoding() {
        $this->connection->set_charset("utf8");
    }

    public function getConnection() {
        return $this->connection;
    }
}

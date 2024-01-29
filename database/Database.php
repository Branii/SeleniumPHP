<?php 
require_once("Config.php");
class Database {

    private $con;

    public function openConnection() : PDO | PDOException | string {
        try {
            $config = new Config();
            $this->con = new PDO($config->getHost(), $config->getUser(), $config->getPass());
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->con;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function closeConnection() : null {
        return $this->con = null;
    }

}
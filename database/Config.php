<?php

class Config {

    private $user = "root";
    private $pass = "root";
    private $host = "mysql:host=127.0.0.1;dbname=lottery";
  

    public function getUser() {
    	return $this->user;
    }

    public function getPass() {
    	return $this->pass;
    }

    public function getHost() {
    	return $this->host;
    }
}
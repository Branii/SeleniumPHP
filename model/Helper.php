<?php 

class Helper extends Database {

    public function query($sql,$params = []) {
        $req = parent::openConnection()->prepare($sql);
        $req->execute($params);
        return $req;
    }

    public function insert($sql,$params = []) {
        $req = $this->query($sql,$params);
        return parent::openConnection()->lastInsertId();
    }

    public function selectOne($sql,$params = []) {
        $req = $this->query($sql,$params);
        return $req->fetch(PDO::FETCH_OBJ);
    }

    public function selectAll($sql,$params = []) {
        $req = $this->query($sql,$params);
        return $req->fetchAll(PDO::FETCH_OBJ);
    }

    public function delete($sql,$params = []) {
        $req = $this->query($sql,$params);
        return $req->rowCount();
    }

}
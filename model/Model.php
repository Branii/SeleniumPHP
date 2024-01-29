<?php 
class Model extends Database {

    public function insertData(String $tableName, Array $param) : string {

        try {
            $sql = "INSERT INTO $tableName (draw_date,draw_time,draw_number,draw_count,date_created,client,get_time) VALUES (?,?,?,?,?,?,?)";
            $stmt = parent::openConnection()->prepare($sql);
            $stmt->execute(array_values($param));   
            return "Data inserted successfully => " . $param[':draw_time'] . " => " . $param[':draw_number'] ."\n\n";
        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }
}
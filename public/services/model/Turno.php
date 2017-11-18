<?php

class Turno {
    private $db;
    public $id;
    public $descricao;
    public $status;
    
    function __construct($db) {
        $this->db = $db;
    }

    function getTurnos()
    {
        $sql = "SELECT * FROM Turno";
        $query = $this->db->query($sql);
        $turnos = $query->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($turnos);
    }
}

?>
<?php

class Estado {
    private $db;
    public $id;
    public $codigoUf;
    public $nome;
    public $uf;
    public $regiao;
    
    function __construct($db) {
        $this->db = $db;
    }

    function getEstados() {
        $sql = "SELECT * FROM Estado";
        $query = $this->db->query($sql);
        $estados = $query->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($estados);
    }
}

?>
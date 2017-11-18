<?php

class EtapaCatequese {
    private $db;
    public $id;
    public $descricao;
    public $status;
    
    function __construct($db) {
        $this->db = $db;
    }

    function getEtapasCatequese()
    {
        $sql = "SELECT * FROM EtapaCatequese";
        $query = $this->db->query($sql);
        $etapasCatequese = $query->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($etapasCatequese);
    }
}

?>
<?php

class Escola {
    private $db;
    public $id;
    public $descricao;
    public $status;
    
    function __construct($db) {
        $this->db = $db;
    }

    function getEscola()
    {
        $sql = "SELECT * FROM Escola";
        $query = $this->db->query($sql);
        $escolas = $query->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($escolas);
    }
}

?>
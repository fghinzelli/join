<?php

class SituacaoInscricao {
    private $db;
    public $id;
    public $descricao;
    public $status;
    
    function __construct($db) {
        $this->db = $db;
    }

    function getSituacoesInscricao()
    {
        $sql = "SELECT * FROM SituacaoInscricao";
        $query = $this->db->query($sql);
        $situcacoes = $query->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($situcacoes);
    }
}

?>
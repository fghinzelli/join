<?php

class Municipio {
    private $db;
    public $id;
    public $codigoUf;
    public $nome;
    public $uf;
    public $regiao;
    
    function __construct($db) {
        $this->db = $db;
    }

    function getMunicipio($uf)
    {
      $sql = "SELECT * FROM Municipio WHERE uf=:uf";
      $query = $this->db->prepare($sql);
      $query->bindParam("uf", $uf);
      $query->execute();
      $municipios = $query->fetchAll(PDO::FETCH_OBJ);
      echo json_encode($municipios);
    }
}

?>
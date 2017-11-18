<?php



class Catequista {
    private $db;
    public $id;
    public $pessoaId;
    public $comunidadeId;
    public $dataInicio;
    public $observacoes;
    public $status;
    public $dataUltimaAlteracao;
    public $usuarioUltimaAlteracaoId;
    function __construct($db) {
        $this->db = $db;
    }

    function loadData($id, $pessoaId, $comunidadeId, $dataInicio, $observacoes, 
                      $status, $dataUltimaAlteracao, $usuarioUltimaAlteracaoId) {
        $this->id = $id;
		$this->pessoaId = $pessoaId;
        $this->comunidadeId = $comunidadeId;
        $this->dataInicio = converterDataToISO($dataInicio);
        $this->observacoes = $observacoes;
        $this->status = $status;
        $this->dataUltimaAlteracao = $dataUltimaAlteracao;
        $this->usuarioUltimaAlteracaoId = $usuarioUltimaAlteracaoId;
    } 

    function getCatequistas() {
        $sql = "SELECT C.* FROM Catequista C INNER JOIN Pessoa P ON C.pessoaId = P.id ORDER BY P.nome;";
        $query = $this->db->query($sql);
        $catequistas = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($catequistas as $catequista) {
            $catequista->dataInicio = converterDataFromISO($catequista->dataInicio);
            $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
            $queryp = $this->db->prepare($sqlp);
            $queryp->bindParam("id",$catequista->pessoaId);
            $queryp->execute();
            $catequista->pessoa =  $queryp->fetchObject();
            // COMUNIDADE
            $sqlc = "SELECT * FROM Comunidade WHERE id=:id";
            $queryc = $this->db->prepare($sqlc);
            $queryc->bindParam("id",$catequista->comunidadeId);
            $queryc->execute();
            $catequista->comunidade =  $queryc->fetchObject();
        }
        echo json_encode($catequistas);
    }
    
    function getCatequista($id)
    {
      $sql = "SELECT * FROM Catequista WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam("id", $id);
      $query->execute();
      $catequista = $query->fetchObject();
      $catequista->dataInicio = converterDataFromISO($catequista->dataInicio);

      // PESSOA
      $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
      $queryp = $this->db->prepare($sqlp);
      $queryp->bindParam("id",$catequista->pessoaId);
      $queryp->execute();
      $catequista->pessoa =  $queryp->fetchObject();

      // COMUNIDADE
      $sqlc = "SELECT * FROM Comunidade WHERE id=:id";
      $queryc = $this->db->prepare($sqlc);
      $queryc->bindParam("id",$catequista->comunidadeId);
      $queryc->execute();
      $catequista->comunidade =  $queryc->fetchObject();
      
      echo json_encode($catequista);
    }

    function addCatequista() {
        $sql = "INSERT INTO Catequista (`pessoaId`, `comunidadeId`, `dataInicio`, `observacoes`, 
                                    `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) 
                VALUES (:pessoaId, :comunidadeId, :dataInicio, :observacoes, :status, NOW(), :usuarioUltimaAlteracaoId)";
        
        $query = $this->db->prepare($sql);
        $query->bindParam(":pessoaId",$this->pessoaId);
        $query->bindParam(":comunidadeId",$this->comunidadeId);
        $query->bindParam(":dataInicio",$this->dataInicio);
        $query->bindParam(":observacoes",$this->observacoes);
        $query->bindParam(":status",$this->status);
        $query->bindParam(":usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
        $query->execute();
        $this->id = $this->db->lastInsertId();
        echo json_encode($this);
    }
    
    function saveCatequista()
    {
        $sql = "UPDATE Catequista SET pessoaId=:pessoaId, comunidadeId=:comunidadeId, dataInicio=:dataInicio, observacoes=:observacoes, 
                                  status=:status, dataUltimaAlteracao=NOW(), usuarioUltimaAlteracaoId=:usuarioUltimaAlteracaoId 
                WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->bindParam(":pessoaId",$this->pessoaId);
      $query->bindParam(":comunidadeId",$this->comunidadeId);
      $query->bindParam(":dataInicio",$this->dataInicio);
      $query->bindParam(":observacoes", $this->observacoes);
      $query->bindParam(":status",$this->status);
      $query->bindParam(":usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
      $query->execute();
      echo json_encode($this);
    }
    
    function deleteCatequista()
    {
      $sql = "DELETE FROM Catequista WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->execute();
      echo json_encode("{'message': 'Catequista apagado'}");
    }
}
?>
<?php

class Diocese {
    private $db;
    public $id;
    public $nome;
    public $cnpj;
    public $email;
    public $telefone;
    public $logradouro;
    public $numero;
    public $complemento;
    public $bairro;
    public $municipioId;
    public $cep;
    public $status;
    public $dataUltimaAlteracao;
    public $usuarioUltimaAlteracaoId;
    
    function __construct($db) {
        $this->db = $db;
    }

    function loadData($id, $nome, $cnpj, $email, $telefone, $logradouro, 
                      $numero, $complemento, $bairro, $municipioId,
                      $cep, $status, $dataUltimaAlteracao, $usuarioUltimaAlteracaoId) {
        $this->id = $id;
		$this->nome = $nome;
        $this->cnpj = $cnpj;
        $this->email = $email;
        $this->telefone = $telefone;
		$this->logradouro = $logradouro;
		$this->numero = $numero;
		$this->complemento = $complemento;
		$this->bairro = $bairro;
        $this->municipioId = $municipioId;
        $this->cep = $cep;
        $this->status = $status;
        $this->dataUltimaAlteracao = $dataUltimaAlteracao;
        $this->usuarioUltimaAlteracaoId = $usuarioUltimaAlteracaoId;
    } 

    function getDioceses() {
        $sql = "SELECT * FROM Diocese";
        $query = $this->db->query($sql);
        $dioceses = $query->fetchAll(PDO::FETCH_OBJ);
        echo "{\"dioceses\":" . json_encode($dioceses) . "}";
    }
    
    function getDiocese($id)
    {
      $sql = "SELECT * FROM Diocese WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam("id", $id);
      $query->execute();
      $diocese = $query->fetchObject();
    
      //municipio
      $sql = "SELECT * FROM Municipio WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam("id",$diocese->municipioId);
      $query->execute();
      $diocese->municipio =  $query->fetchObject();
    
      echo json_encode($diocese);
    }

    function addDiocese() {
        $sql = "INSERT INTO Diocese (`nome`, `cnpj`, `email`, `telefone`, `logradouro`, `numero`, `complemento`, 
                                    `complemento`, `bairro`, `municipioId`, `cep`, 
                                    `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) 
                VALUES (:nome, :cnpj, :email, :telefone, :logradouro, :numero, :complemento, :bairro, :municipioId,
                        :cep, :status, :dataUltimaAlteracao, :usuarioUltimaAlteracaoId)";
        $query = $this->db->prepare($sql);
        $query->bindParam(":nome",$this->nome);
        $query->bindParam(":cnpj",$this->cnpj);
        $query->bindParam(":email",$this->email);
        $query->bindParam(":telefone",$this->telefone);
        $query->bindParam(":logradouro",$this->logradouro);
        $query->bindParam(":numero", $this->numero);
        $query->bindParam(":complemento", $this->complemento);
        $query->bindParam(":bairro", $this->bairro);
        $query->bindParam(":municipioId", $this->municipioId);
        $query->bindParam(":cep", $this->cep);
        $query->bindParam("status",$this->status);
        $query->bindParam("dataUltimaAlteracao", $this->dataUltimaAlteracao);
        $query->bindParam("usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
        $query->execute();
        $this->id = $this->db->lastInsertId();
        echo json_encode($this);
    }
    
    function saveDiocese()
    {
        $sql = "UPDATE Diocese SET nome=:nome, cnpj=:cnpj, email=:email, telefone=:telefone, 
                                  logradouro=:logradouro, numero=:numero, complemento=:complemento, bairro=:bairro, 
                                  municipioId=:municipioId, cep=:cep, status=:status, 
                                  dataUltimaAlteracao=:dataUltimaAlteracao, usuarioUltimaAlteracaoId=:usuarioUltimaAlteracaoId 
                WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->bindParam(":cnpj",$this->cnpj);
      $query->bindParam(":email",$this->email);
      $query->bindParam(":telefone",$this->telefone);
      $query->bindParam(":logradouro",$this->logradouro);
      $query->bindParam(":numero", $this->numero);
      $query->bindParam(":complemento", $this->complemento);
      $query->bindParam(":bairro", $this->bairro);
      $query->bindParam(":municipioId", $this->municipioId);
      $query->bindParam(":cep", $this->cep);
      $query->bindParam("status",$this->status);
      $query->bindParam("dataUltimaAlteracao", $this->dataUltimaAlteracao);
      $query->bindParam("usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
      $query->execute();
      echo json_encode($this);
    }
    
    function deleteDiocese()
    {
      $sql = "DELETE FROM Diocese WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->execute();
      echo json_encode("{'message': 'Diocese apagada'}");
    }
}
?>
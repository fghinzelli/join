<?php

class Paroquia {
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
    public $dioceseId;
    public $status;
    public $dataUltimaAlteracao;
    public $usuarioUltimaAlteracaoId;
    
    function __construct($db) {
        $this->db = $db;
    }

    function loadData($id, $nome, $cnpj, $email, $telefone, $logradouro, 
                      $numero, $complemento, $bairro, $municipioId,
                      $cep, $dioceseId, $status, $dataUltimaAlteracao, $usuarioUltimaAlteracaoId) {
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
        $this->dioceseId = $dioceseId;
        $this->status = $status;
        $this->dataUltimaAlteracao = $dataUltimaAlteracao;
        $this->usuarioUltimaAlteracaoId = $usuarioUltimaAlteracaoId;
    } 

    function getParoquias() {
        $sql = "SELECT * FROM Paroquia";
        $query = $this->db->query($sql);
        $paroquias = $query->fetchAll(PDO::FETCH_OBJ);
        echo "{\"paroquias\":" . json_encode($paroquias) . "}";
    }
    
    function getParoquia($id)
    {
      $sql = "SELECT * FROM Paroquia WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam("id", $id);
      $query->execute();
      $paroquia = $query->fetchObject();
    
      //municipio
      $sql = "SELECT * FROM Municipio WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam("id",$paroquia->municipioId);
      $query->execute();
      $paroquia->municipio =  $query->fetchObject();

      //diocese
      $sql = "SELECT * FROM Diocese WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam("id",$paroquia->dioceseId);
      $query->execute();
      $paroquia->diocese =  $query->fetchObject();
    
      echo json_encode($paroquia);
    }

    function addParoquia() {
        $sql = "INSERT INTO Paroquia (`nome`, `cnpj`, `email`, `telefone`, `logradouro`, `numero`, `complemento`, 
                                    `complemento`, `bairro`, `municipioId`, `cep`, `dioceseId`,
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
        $query->bindParam(":dioceseId", $this->dioceseId);
        $query->bindParam(":status",$this->status);
        $query->bindParam(":dataUltimaAlteracao", $this->dataUltimaAlteracao);
        $query->bindParam(":usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
        $query->execute();
        $this->id = $this->db->lastInsertId();
        echo json_encode($this);
    }
    
    function saveParoquia()
    {
        $sql = "UPDATE Paroquia SET nome=:nome, cnpj=:cnpj, email=:email, telefone=:telefone, 
                                  logradouro=:logradouro, numero=:numero, complemento=:complemento, bairro=:bairro, 
                                  municipioId=:municipioId, cep=:cep, dioceseId=:dioceseId, status=:status, 
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
      $query->bindParam(":dioceseId", $this->dioceseId);
      $query->bindParam("status",$this->status);
      $query->bindParam("dataUltimaAlteracao", $this->dataUltimaAlteracao);
      $query->bindParam("usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
      $query->execute();
      echo json_encode($this);
    }
    
    function deleteParoquia()
    {
      $sql = "DELETE FROM Paroquia WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->execute();
      echo json_encode("{'message': 'Paroquia apagada'}");
    }
}
?>
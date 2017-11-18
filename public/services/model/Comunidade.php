<?php

class Comunidade {
    private $db;
    public $id;
    public $nome;
    public $padroeiro;
    public $paroquiaId;
    public $dataFundacao;
    public $responsavelCatequese;
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

    function loadData($id, $nome, $padroeiro, $paroquiaId, $dataFundacao, 
                      $responsavelCatequese, $email, $telefone, $logradouro, 
                      $numero, $complemento, $bairro, $municipioId,
                      $cep, $status, $dataUltimaAlteracao, $usuarioUltimaAlteracaoId) {
        $this->id = $id;
		$this->nome = $nome;
        $this->padroeiro = $padroeiro;
        $this->paroquiaId = $paroquiaId;
        $this->dataFundacao = $dataFundacao;
        $this->responsavelCatequese = $responsavelCatequese;
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

    function getComunidades() {
        $sql = "SELECT * FROM Comunidade ORDER BY nome";
        $query = $this->db->query($sql);
        $comunidades = $query->fetchAll(PDO::FETCH_OBJ);
        foreach($comunidades as $comunidade) {
            //paroquia
            $sqlp = "SELECT * FROM Paroquia WHERE id=:id";
            $queryp = $this->db->prepare($sqlp);
            $queryp->bindParam("id",$comunidade->paroquiaId);
            $queryp->execute();
            $comunidade->paroquia =  $queryp->fetchObject();
            //municipio
            $sqlm = "SELECT * FROM Municipio WHERE id=:id";
            $querym = $this->db->prepare($sqlm);
            $querym->bindParam("id",$comunidade->municipioId);
            $querym->execute();
            $comunidade->municipio =  $querym->fetchObject();
        }
        
        echo json_encode($comunidades);
    }
    
    function getComunidade($id)
    {
      $sql = "SELECT * FROM Comunidade WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam("id", $id);
      $query->execute();
      $comunidade = $query->fetchObject();
    
      //paroquia
      $sql = "SELECT * FROM Paroquia WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam("id",$comunidade->paroquiaId);
      $query->execute();
      $comunidade->paroquia =  $query->fetchObject();

      //municipio
      $sql = "SELECT * FROM Municipio WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam("id",$comunidade->municipioId);
      $query->execute();
      $comunidade->municipio =  $query->fetchObject();

      
    
      echo json_encode($comunidade);
    }

    function addComunidade() {
        $sql = "INSERT INTO Comunidade (`nome`, `padroeiro`, `paroquiaId`, `dataFundacao`, `responsavelCatequese`, `email`, `telefone`, `logradouro`, `numero`, `complemento`, 
                                    `complemento`, `bairro`, `municipioId`, `cep`, 
                                    `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) 
                VALUES (:nome, :padroeiro, :paroquiaId, :dataFundacao, :responsavelCatequese, :email, :telefone, :logradouro, :numero, :complemento, :bairro, :municipioId,
                        :cep, :status, :dataUltimaAlteracao, :usuarioUltimaAlteracaoId)";
        $query = $this->db->prepare($sql);
        $query->bindParam(":nome",$this->nome);
        $query->bindParam(":padroeiro",$this->padroeiro);
        $query->bindParam(":paroquiaId",$this->paroquiaIdcnpj);
        $query->bindParam(":dataFundacao",$this->dataFundacao);
        $query->bindParam(":responsavelCatequesecnpj",$this->responsavelCatequese);
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
    
    function saveComunidade()
    {
        $sql = "UPDATE Comunidade SET nome=:nome, padroeiro=:padroeiro, paroquiaId=:paroquiaId, dataFundacao=:dataFundacao, responsavelCatequese=:responsavelCatequese, email=:email, telefone=:telefone, 
                                  logradouro=:logradouro, numero=:numero, complemento=:complemento, bairro=:bairro, 
                                  municipioId=:municipioId, cep=:cep, status=:status, 
                                  dataUltimaAlteracao=:dataUltimaAlteracao, usuarioUltimaAlteracaoId=:usuarioUltimaAlteracaoId 
                WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->bindParam(":padroeiro",$this->padroeiro);
      $query->bindParam(":paroquiaId",$this->paroquiaIdcnpj);
      $query->bindParam(":dataFundacao",$this->dataFundacao);
      $query->bindParam(":responsavelCatequesecnpj",$this->responsavelCatequese);
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
    
    function deleteComunidade()
    {
      $sql = "DELETE FROM Comunidade WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->execute();
      echo json_encode("{'message': 'Comunidade apagada'}");
    }
}
?>
<?php


class Pessoa {
    private $db;
    public $id;
    public $nome;
    public $sexo;
    public $nomePai;
    public $nomeMae;
    public $dataNascimento;
    public $telefone1;
    public $telefone2;
    public $cpf;
    public $rg;
    public $rgEmissor;
    public $rgUF;
    public $passaporte;
    public $nacionalidade;
    public $email;
    public $logradouro;
    public $numero;
    public $complemento;
    public $bairro;
    public $municipioId;
    public $cep;
    public $numeroDizimo;
    public $comunidadeId;
    public $observacoes;
    public $batizado;
    public $localBatismo;
    public $primeiraEucaristia;
    public $localPrimeiraEucaristia;
    public $status;
    public $dataUltimaAlteracao;
    public $usuarioUltimaAlteracaoId;
    
    function __construct($db) {
        $this->db = $db;
    }

    function loadData($id, $nome, $sexo, $nomePai, $nomeMae, $dataNascimento, $telefone1, $telefone2,
                      $cpf, $rg, $rgEmissor, $rgUF, $passaporte, $nacionalidade, $email, $logradouro, 
                      $numero, $complemento, $bairro, $municipioId, $cep,
                      $numeroDizimo, $comunidadeId, $observacoes, $batizado, $localBatismo, $primeiraEucaristia,
                      $localPrimeiraEucaristia, $status, $dataUltimaAlteracao, $usuarioUltimaAlteracaoId) {
        $this->id = $id;
		$this->nome = $nome;
        $this->sexo = $sexo;
        $this->nomePai = $nomePai;
        $this->nomeMae = $nomeMae;
		$this->dataNascimento = converterDataToISO($dataNascimento);
		$this->telefone1 = $telefone1;
		$this->telefone2 = $telefone2;
		$this->cpf = $cpf;
        $this->rg = $rg;
        $this->rgEmissor = $rgEmissor;
        $this->rgUF = $rgUF;
        $this->passaporte = $passaporte;
        $this->nacionalidade = $nacionalidade;
		$this->email = $email;
		$this->logradouro = $logradouro;
		$this->numero = $numero;
		$this->complemento = $complemento;
		$this->bairro = $bairro;
        $this->municipioId = $municipioId;
        $this->cep = $cep;
        $this->numeroDizimo = $numeroDizimo;
        $this->comunidadeId = $comunidadeId;
        $this->comunidade = 
        $this->observacoes = $observacoes;
        $this->batizado = $batizado;
        $this->localBatismo = $localBatismo;
        $this->primeiraEucaristia = $primeiraEucaristia;
        $this->localPrimeiraEucaristia = $localPrimeiraEucaristia;
        $this->status = $status;
        $this->dataUltimaAlteracao = $dataUltimaAlteracao;
        $this->usuarioUltimaAlteracaoId = $usuarioUltimaAlteracaoId;
    } 

    function getPessoas() {
        $sql = "SELECT * FROM Pessoa ORDER BY nome;";
        $query = $this->db->query($sql);
        $pessoas = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($pessoas as $pessoa) {
            // Busca de dados relacionados
            // COMUNIDADE
            $sqlc = "SELECT * FROM Comunidade WHERE id=:id";
            $queryc = $this->db->prepare($sqlc);
            $queryc->bindParam("id",$pessoa->comunidadeId);
            $queryc->execute();
            $pessoa->comunidade =  $queryc->fetchObject();
            // MUNICIPIO
            $sqlm = "SELECT * FROM Municipio WHERE id=:id";
            $querym = $this->db->prepare($sqlm);
            $querym->bindParam("id",$pessoa->municipioId);
            $querym->execute();
            $pessoa->municipio =  $querym->fetchObject();
        }
        echo json_encode($pessoas);
    }
    
    function getPessoa($id)
    {
      $sql = "SELECT * FROM Pessoa WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam("id", $id);
      $query->execute();
      $pessoa = $query->fetchObject();

      // COMUNIDADE
      $sqlc = "SELECT * FROM Comunidade WHERE id=:id";
      $queryc = $this->db->prepare($sqlc);
      $queryc->bindParam("id",$pessoa->comunidadeId);
      $queryc->execute();
      $pessoa->comunidade =  $queryc->fetchObject();
    
      //MUNICIPIO
      $sqlm = "SELECT * FROM Municipio WHERE id=:id";
      $querym = $this->db->prepare($sqlm);
      $querym->bindParam("id",$pessoa->municipioId);
      $querym->execute();
      $pessoa->municipio =  $querym->fetchObject();


      
      echo json_encode($pessoa);
    }

    function addPessoa() {
        $sql = "INSERT INTO Pessoa (`nome`, `sexo`, `nomePai`, `nomeMae`, `dataNascimento`, `telefone1`, `telefone2`, 
                                    `cpf`, `rg`, `rgEmissor`, `rgUF`, `passaporte`, `nacionalidade`, `email`, `logradouro`, 
                                    `numero`, `complemento`, `bairro`, `municipioId`, `cep`, 
                                    `numeroDizimo`, `comunidadeId`, `observacoes`, `batizado`, `localBatismo`, 
                                    `primeiraEucaristia`, `localPrimeiraEucaristia`, 
                                    `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) 
                VALUES (:nome, :sexo, :nomePai, :nomeMae, :dataNascimento, :telefone1, :telefone2, 
                        :cpf, :rg, :rgEmissor, :rgUF, :passaporte, :nacionalidade, :email, :logradouro, :numero, 
                        :complemento, :bairro, :municipioId, :cep, 
                        :numeroDizimo, :comunidadeId, :observacoes, :batizado, :localBatismo,
                        :primeiraEucaristia, :localPrimeiraEucaristia, 
                        :status, NOW(), :usuarioUltimaAlteracaoId)";
        $query = $this->db->prepare($sql);
        $query->bindParam(":nome",$this->nome);
        $query->bindParam(":sexo",$this->sexo);
        $query->bindParam(":nomePai",$this->nomePai);
        $query->bindParam(":nomeMae",$this->nomeMae);
        $query->bindParam(":dataNascimento",$this->dataNascimento);
        $query->bindParam(":telefone1",$this->telefone1);
        $query->bindParam(":telefone2",$this->telefone2);
        $query->bindParam(":cpf",$this->cpf);
        $query->bindParam(":rg",$this->rg);
        $query->bindParam(":rgEmissor",$this->rgEmissor);
        $query->bindParam(":rgUF",$this->rgUF);
        $query->bindParam(":passaporte",$this->passaporte);
        $query->bindParam(":nacionalidade",$this->nacionalidade);
        $query->bindParam(":email",$this->email);
        $query->bindParam(":logradouro",$this->logradouro);
        $query->bindParam(":numero", $this->numero);
        $query->bindParam(":complemento", $this->complemento);
        $query->bindParam(":bairro", $this->bairro);
        $query->bindParam(":municipioId", $this->municipioId);
        $query->bindParam(":cep", $this->cep);
        $query->bindParam(":numeroDizimo", $this->numeroDizimo);
        $query->bindParam(":comunidadeId", $this->comunidadeId);
        $query->bindParam(":observacoes", $this->observacoes);
        $query->bindParam(":batizado", $this->batizado);
        $query->bindParam(":localBatismo", $this->localBatismo);
        $query->bindParam(":primeiraEucaristia", $this->primeiraEucaristia);
        $query->bindParam(":localPrimeiraEucaristia", $this->localPrimeiraEucaristia);
        $query->bindParam(":status",$this->status);
        //$query->bindParam(":dataUltimaAlteracao", $this->dataUltimaAlteracao);
        $query->bindParam(":usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
        $query->execute();
        $this->id = $this->db->lastInsertId();
        echo json_encode($this);
    }
    
    function savePessoa()
    {
        $sql = "UPDATE Pessoa SET nome=:nome, sexo=:sexo, nomePai=:nomePai, nomeMae=:nomeMae, 
                                  dataNascimento=:dataNascimento, telefone1=:telefone1, telefone2=:telefone2, 
                                  cpf=:cpf, rg=:rg, rgEmissor=:rgEmissor, rgUF=:rgUF, passaporte=:passaporte, nacionalidade=:nacionalidade,
                                  email=:email, logradouro=:logradouro, numero=:numero, 
                                  complemento=:complemento, bairro=:bairro, municipioId=:municipioId, cep=:cep,
                                  numeroDizimo=:numeroDizimo, comunidadeId=:comunidadeId, observacoes=:observacoes, 
                                  batizado=:batizado, localBatismo=:localBatismo, primeiraEucaristia=:primeiraEucaristia, 
                                  localPrimeiraEucaristia=:localPrimeiraEucaristia, status=:status, 
                                  dataUltimaAlteracao=NOW(), usuarioUltimaAlteracaoId=:usuarioUltimaAlteracaoId 
                WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->bindParam(":nome",$this->nome);
      $query->bindParam(":sexo",$this->sexo);
      $query->bindParam(":nomePai",$this->nomePai);
      $query->bindParam(":nomeMae",$this->nomeMae);
      $query->bindParam(":dataNascimento",$this->dataNascimento);
      $query->bindParam(":telefone1",$this->telefone1);
      $query->bindParam(":telefone2",$this->telefone2);
      $query->bindParam(":cpf",$this->cpf);
      $query->bindParam(":rg",$this->rg);
      $query->bindParam(":rgEmissor",$this->rgEmissor);
      $query->bindParam(":rgUF",$this->rgUF);
      $query->bindParam(":passaporte",$this->passaporte);
      $query->bindParam(":nacionalidade",$this->nacionalidade);
      $query->bindParam(":email",$this->email);
      $query->bindParam(":logradouro",$this->logradouro);
      $query->bindParam(":numero", $this->numero);
      $query->bindParam(":complemento", $this->complemento);
      $query->bindParam(":bairro", $this->bairro);
      $query->bindParam(":municipioId", $this->municipioId);
      $query->bindParam(":cep", $this->cep);
      $query->bindParam(":numeroDizimo", $this->numeroDizimo);
      $query->bindParam(":comunidadeId", $this->comunidadeId);
      $query->bindParam(":observacoes", $this->observacoes);
      $query->bindParam(":batizado", $this->batizado);
      $query->bindParam(":localBatismo", $this->localBatismo);
      $query->bindParam(":primeiraEucaristia", $this->primeiraEucaristia);
      $query->bindParam(":localPrimeiraEucaristia", $this->localPrimeiraEucaristia);
      $query->bindParam(":status",$this->status);
      //$query->bindParam(":dataUltimaAlteracao", $this->dataUltimaAlteracao);
      $query->bindParam(":usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
      $query->execute();
      echo json_encode($this);
    }
    
    function deletePessoa()
    {
      $sql = "DELETE FROM Pessoa WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->execute();
      echo json_encode("{'message': 'Pessoa apagada'}");
    }
}
?>
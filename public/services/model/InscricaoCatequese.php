<?php


class InscricaoCatequese {
    private $db;
    public $id;
    public $pessoaId;
    public $etapaCatequeseId;
    public $escolaId;
    public $etapaEscolaId;
    public $turmaId;
    public $observacoes;
    public $situacaoInscricaoId;
    public $turnoId;
    public $situacaoDizimoId;
    public $comunidadeId;
    public $dataInscricao;
    public $status;
    public $dataUltimaAlteracao;
    public $usuarioUltimaAlteracaoId;
    function __construct($db) {
        $this->db = $db;
    }


    function loadData($id, $pessoaId, $etapaCatequeseId, $escolaId, $etapaEscolaId, $turmaId,
                      $observacoes, $situacaoInscricaoId, $turnoId, $situacaoDizimoId,
                      $comunidadeId, $dataInscricao,
                      $status, $dataUltimaAlteracao, $usuarioUltimaAlteracaoId) {
        $this->id = $id;
        $this->pessoaId = $pessoaId;
        $this->etapaCatequeseId = $etapaCatequeseId;
        $this->escolaId = $escolaId;
        $this->etapaEscolaId = $etapaEscolaId;
        $this->turmaId = $turmaId;
        $this->observacoes = $observacoes;
        $this->situacaoInscricaoId = $situacaoInscricaoId;
        $this->turnoId = $turnoId;
        $this->situacaoDizimoId = $situacaoDizimoId;
        $this->comunidadeId = $comunidadeId;
        $this->dataInscricao = $dataInscricao;
        $this->status = $status;
        $this->dataUltimaAlteracao = $dataUltimaAlteracao;
        $this->usuarioUltimaAlteracaoId = $usuarioUltimaAlteracaoId;
    } 

    function getInscricoesCatequese() {
        $sql = "SELECT I.* FROM InscricaoCatequese I INNER JOIN Pessoa P ON I.pessoaId = P.id ORDER BY P.nome;";
        $query = $this->db->query($sql);
        $inscricoes = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($inscricoes as $inscricao) {
            // Busca de dados relacionados
            // PESSOA
            $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
            $queryp = $this->db->prepare($sqlp);
            $queryp->bindParam("id",$inscricao->pessoaId);
            $queryp->execute();
            $inscricao->pessoa =  $queryp->fetchObject();
            // COMUNIDADE
            $sqlc = "SELECT * FROM Comunidade WHERE id=:id";
            $queryc = $this->db->prepare($sqlc);
            $queryc->bindParam("id",$inscricao->comunidadeId);
            $queryc->execute();
            $inscricao->comunidade =  $queryc->fetchObject();
            // ETAPA CATEQUESE
            $sqle = "SELECT * FROM EtapaCatequese WHERE id=:id";
            $querye = $this->db->prepare($sqle);
            $querye->bindParam("id",$inscricao->etapaCatequeseId);
            $querye->execute();
            $inscricao->etapaCatequese =  $querye->fetchObject();
        }
        echo json_encode($inscricoes);
    }
    

    function getInscricaoCatequese($id)
    {
      $sql = "SELECT I.* FROM InscricaoCatequese I INNER JOIN Pessoa P ON I.pessoaId = P.id WHERE I.id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam("id", $id);
      $query->execute();
      $inscricao = $query->fetchObject();

      // PESSOA
      $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
      $queryp = $this->db->prepare($sqlp);
      $queryp->bindParam("id",$inscricao->pessoaId);
      $queryp->execute();
      $inscricao->pessoa =  $queryp->fetchObject();

      // COMUNIDADE
      $sqlc = "SELECT * FROM Comunidade WHERE id=:id";
      $queryc = $this->db->prepare($sqlc);
      $queryc->bindParam("id",$inscricao->comunidadeId);
      $queryc->execute();
      $inscricao->comunidade =  $queryc->fetchObject();
      
      // ETAPA CATEQUESE
      $sqle = "SELECT * FROM EtapaCatequese WHERE id=:id";
      $querye = $this->db->prepare($sqle);
      $querye->bindParam("id",$inscricao->etapaCatequeseId);
      $querye->execute();
      $inscricao->etapaCatequese =  $querye->fetchObject();

      echo json_encode($inscricao);
    }


    function addInscricaoCatequese() {
        $sql = "INSERT INTO InscricaoCatequese (`pessoaId`, `etapaCatequeseId`, `escolaId`, `etapaEscolaId`, `turmaId`, 
                                                `observacoes`, `situacaoInscricaoId`, `turnoId`, `situacaoDizimoId`,
                                                `comunidadeId`, `dataInscricao`,
                                                `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) 
                VALUES (:pessoaId, :etapaCatequeseId, :escolaId, :etapaEscolaId, :turmaId, 
                        :observacoes, :situacaoInscricaoId, :turnoId, :situacaoDizimoId, 
                        :comunidadeId, :dataInscricao,
                        :status, NOW(), :usuarioUltimaAlteracaoId)";
        
        $query = $this->db->prepare($sql);
        $query->bindParam(":pessoaId",$this->pessoaId);
        $query->bindParam(":etapaCatequeseId",$this->etapaCatequeseId);
        $query->bindParam(":escolaId",$this->escolaId);
        $query->bindParam(":etapaEscolaId",$this->etapaEscolaId);
        $query->bindParam(":turmaId",$this->turmaId);
        $query->bindParam(":observacoes",$this->observacoes);
        $query->bindParam(":situacaoInscricaoId",$this->situacaoInscricaoId);
        $query->bindParam(":turnoId",$this->turnoId);
        $query->bindParam(":situacaoDizimoId",$this->situacaoDizimoId);
        $query->bindParam(":comunidadeId",$this->comunidadeId);
        $query->bindParam(":dataInscricao",$this->dataInscricao);
        $query->bindParam(":status",$this->status);
        $query->bindParam(":usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
        $query->execute();
        $this->id = $this->db->lastInsertId();
        echo json_encode($this);
    }

    function saveInscricaoCatequese()
    {
        $sql = "UPDATE InscricaoCatequese SET pessoaId=:pessoaId, etapaCatequeseId=:etapaCatequeseId, escolaId=:escolaId, etapaEscolaId=:etapaEscolaId, turmaId=:turmaId, 
                                              observacoes=:observacoes, situacaoInscricaoId=:situacaoInscricaoId, turnoId=:turnoId, situacaoDizimoId=:situacaoDizimoId, 
                                              comunidadeId=:comunidadeId, dataInscricao=:dataInscricao,
                                              status=:status, dataUltimaAlteracao=NOW(), usuarioUltimaAlteracaoId=:usuarioUltimaAlteracaoId 
                WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->bindParam(":pessoaId",$this->pessoaId);
      $query->bindParam(":etapaCatequeseId",$this->etapaCatequeseId);
      $query->bindParam(":escolaId",$this->escolaId);
      $query->bindParam(":etapaEscolaId",$this->etapaEscolaId);
      $query->bindParam(":turmaId",$this->turmaId);
      $query->bindParam(":observacoes", $this->observacoes);
      $query->bindParam(":situacaoInscricaoId",$this->situacaoInscricaoId);
      $query->bindParam(":turnoId",$this->turnoId);
      $query->bindParam(":situacaoDizimoId",$this->situacaoDizimoId);
      $query->bindParam(":comunidadeId",$this->comunidadeId);
      $query->bindParam(":dataInscricao",$this->dataInscricao);
      $query->bindParam(":status",$this->status);
      $query->bindParam(":usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
      $query->execute();
      echo json_encode($this);
    }
    
    function deleteInscricaoCatequese()
    {
      $sql = "DELETE FROM InscricaoCatequese WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->execute();
      echo json_encode("{'message': 'Inscricao apagada'}");
    }
}
?>
<?php
    class Usuario {
        private $db;
        private $username;
        
        function __construct($db) {
            $this->db = $db;
        }

        function checkUser($username, $senha) {
            // Se o usuario existir, retorna sua senha (hash)
            $dbPasswordHash = $this->getUserHash($username)['senha'];
            if($dbPasswordHash === false) return false;
            // Testa se a senha é valida
            $validPassword = $this->isValidPassword($senha, $dbPasswordHash);
            if($validPassword === false) return false;
            // Retorna um array com os dados
            $token = bin2hex(openssl_random_pseudo_bytes(8)); // Gera um token aleatorio
            $arrayRetorno['username'] = $username;
            $arrayRetorno['token'] = $token;
            // Atualiza o token no registro do usuario
            $this->updateUserToken($username, $token);
            echo json_encode($arrayRetorno);
        }

        function userExists($username) {
            // Testa se ja existe o username 
            $sql = "SELECT username
                    FROM Usuario
                    WHERE username = :username";
            $query = $this->db->prepare($sql);
            $query->bindParam(':username', $username);
            $query->execute();
            return $query->rowCount() > 0;
        }

        function isValidToken($token) {
            // Verifica se o token é valido
            $sql = "SELECT username 
                    FROM Usuario 
                    WHERE token = :token"; //AND TIMESTAMPDIFF(MINUTE, tokenExpiracao, CURRENT_TIMESTAMP) < 30";
            $query = $this->db->prepare($sql);
            $query->bindParam(':token', $token, PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() > 0) {
                $this->updateExpirateToken($token);
                return true;
            } else {
                return false;
            }
        }

        function getByToken($token) {
            $sql = "SELECT username 
                    FROM Usuario 
                    WHERE token = :token AND TIMESTAMPDIFF(MINUTE, tokenExpiracao, CURRENT_TIMESTAMP) < 30";
            $query = $this->db->prepare($sql);
            $query->bindParam(':token', $token);
            $query->execute();
            $this->username = $query->fetch(PDO::FETCH_ASSOC)['username'];
        }

        private function getUserHash($username) {
            // Verifica se a combinacao usuario senha existe
            $sql = "SELECT senha FROM Usuario WHERE username = :username";
            $query = $this->db->prepare($sql);
            $query->bindParam(':username', $username);
            $query->execute();
            if($query->rowCount() === 0) return false;
            return $query->fetch(PDO::FETCH_ASSOC);
        }

        function updateUserToken($username, $token) {
            $tokenExpiration = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $sql = "UPDATE Usuario SET token = :token, tokenExpiracao = :tokenExpiracao WHERE username = :username";
			$query = $this->db->prepare($sql);
			$query->bindParam(":username", $username);
			$query->bindParam(":token", $token);
			$query->bindParam(":tokenExpiracao", $tokenExpiration);
			$query->execute();
        }

        function updateExpirateToken($token) {
            $tokenExpiration = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $sql = "UPDATE Usuario SET token = :token, tokenExpiracao = :tokenExpiracao WHERE token = :token";
			$query = $this->db->prepare($sql);
			$query->bindParam("token", $token);
			$query->bindParam("tokenExpiracao", $tokenExpiration);
			$query->execute();
        }
        
        function getHash($senha) {
            // gera um hash da senha do usuario
            return password_hash($password, PASSWORD_DEFAULT);
        }

        private function isValidPassword($senha, $dbPasswordHash) {
            // Verifica se a senha informada é valida
            return password_verify($senha, $dbPasswordHash);
        }

        function addUser($username, $senha, $pessoaId, $status, $usuarioAlteracao) {
            // Adiciona um novo registro de usuario se o username ainda não existir
            if ($this->userExists($username)) return false;
            $hashedPassword = $this->getHash($senha);
            return $this->insertUser($username, $hashedPassword, $pessoaId, $status, $usuarioAlteracao);
        }

        private function insertUser($username, $hashedPassword, $pessoaId, $status, $usuarioAlteracao) {
            // Insere um novo usuario no db
            try {
                $sql = "INSERT INTO Usuario (username, senha, pessoaId, status, usuarioAlteracao)
                        VALUES (:username, :senha, :pessoaId, :status, :usuarioAlteracao)";
                $query = $this->db->prepare($sql);
                $query->bindParam(':username', $username);
                $query->bindParam(':senha', $senha);
                $query->bindParam(':pessoaId', $pessoaId);
                $query->bindParam(':status', $status);
                $query->bindParam(':usuarioAlteracao', $usuarioAlteracao);
                $query->execute();
                return true;
            } catch(PDOException $e) {
                return $e;
            }
        }

    }
?>
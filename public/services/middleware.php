<?php

require 'model/User.php';
require 'model/db.php';


class TokenAuth extends \Slim\Middleware {

    public function __construct() {
        //Define as urls que não terão autenticacao, ou seja urls publicas     
        $this->whiteList = array('\/usuario\/login', '\/usuario\/logout',);
    }

    /**
     * Deny Access
     *
     */
    public function deny_access() {
        $res = $this->app->response();
        $res->status(401);
    }

    /**
     * Verifica no DB se o token é válido
     * 
     * @param string $token
     * @return bool
     */
    public function authenticate($token) {
        // Verifica no model User
        $usuario = new Usuario(db::getInstance());
        return $usuario->isValidToken($token);
    }

    /**
     * Esta funcao irá veirificar se a url solicitada está na whitelist e
     * retorna se a $url é publica ou não
     * 
     * @param string $url
     * @return bool
     */
    public function isPublicUrl($url) {
        $patterns_flattened = implode('|', $this->whiteList);
        $matches = null;
        preg_match('/' . $patterns_flattened . '/', $url, $matches);
        return (count($matches) > 0);
    }

    /**
     * Call
     *
     */
    public function call() {
        // Recebe o token do header da requisicao
        $tokenAuth = $this->app->request->headers->get('Authorization');
        // Verifica se a url é publica ou não
        if ($this->isPublicUrl($this->app->request->getPathInfo())) {
            //se publica, então a é feita a proxima chamada do middleware e a execuçao continua
            $this->next->call();
        } else {
            //Se é uma url protegida, verifica-se o token
            if ($this->authenticate($tokenAuth)) {
                //Pega o usuario e disponibiliza-o para o controller
                $usrObj = new Usuario(db::getInstance());
                $usrObj->getByToken($tokenAuth);
                $this->app->auth_user = $usrObj;
                //Atualiza o tempo de expiracao do token
                $usrObj->updateToken($tokenAuth);
                //Continua a execucao
                $this->next->call();
            } else {
                $this->deny_access();
            }
        }
    }

}
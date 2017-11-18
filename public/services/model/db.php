<?php
    require 'db_config.php';

    class db {
        private static $instance = NULL;
        private function __construct() {}
        private function __clone() {}
        public static function getInstance() {
            if(!self::$instance) {
                self::$instance = new PDO('mysql:host='.DATABASE_HOST.';dbname='.DATABASE_NAME,
                                           DATABASE_USER,
                                           DATABASE_PWD,
                                           array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
                                        );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$instance;
        }

    }
    /*
    function getConn() {
        return new PDO('mysql:host='.DATABASE_HOST.';dbname='.DATABASE_NAME,
                        DATABASE_USER,
                        DATABASE_PWD,
                        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
        );
    }
    */
?>
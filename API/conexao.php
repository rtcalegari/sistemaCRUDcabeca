<?php
    class Conexao{

        private $pdo;
        public function __construct(){
            $this->pdo = new PDO("mysql:host=localhost;dbname=bancoCRUD;","root","",array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ));
        }

        public function getPDO(){
            if ($this->pdo!=null)
                return $this->pdo;
            else
                return null; 
        }
    }
?>

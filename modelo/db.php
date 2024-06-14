<!-- 2° CONEXIÓN AGREGADA, USANDO PDO PARA FUNCIONES DE MODELO-VISTA-CONTROLADOR -->

<?php

    class db{
        private $host = "localhost";
        private $dbname = "mi_colegio";
        private $user = "root";
        private $password = "ipchile";

        public function  Conexion(){
            try {
                $PDO= new PDO("mysql:host=".$this->host.";dbname=".$this->dbname,$this->user, $this->password);
                return $PDO;

            } catch(PDOException $e) {
                return $e->getMessage();
            }    
        }
    }

?>
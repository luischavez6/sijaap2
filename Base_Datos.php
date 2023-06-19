<?php
class Base_Datos{
    public $host;
    public $username;
    public $passwd;
    public $dbname;
    
    public function __construct() {
        $this->host="localhost";
        $this->username="root";
        $this->passwd="";
        $this->dbname="computrainsystem_sijjap";
    }
    
    public function conectar(){
        $conn=new mysqli($this->host,$this->username,$this->passwd,$this->dbname);
        //$acentos = $conn->query("SET NAMES 'utf8'");
        return $conn;
    }
    
    public function desconectar(){
        $this->conectar()->close();
        
    }
}
?>
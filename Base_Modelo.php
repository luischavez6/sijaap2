<?php 
class Base_Modelo extends Base_Datos{
    private $vareg;
    private $unreg;
    /*private $fecha;
    private $nombre;
    private $correo;
    private $username;
    private $tipo;
    private $clave;
    private $foto;
    private $fingreso;
    */
    
    public function Autocommit($val){
        $coneccion= $this->conectar();
        $coneccion->autocommit($val);
    }

    public function Commit(){
        $coneccion=$this->conectar();
        $coneccion->commit();
    }
    
    public function RollBack(){
        $coneccion=$this->conectar();
        $coneccion->rollback();
    }

    public function getLogin($login,$pass){
        //$this->conectar()->query("SET NAMES 'utf8';");
       $sql="select * from usuarios where correo='$login' and clave='$pass'";
        $numreg=$this->num_filas($sql);
        $this->desconectar();
        if ($numreg==1){
            return true;
        }
        return false;
    }
    
    public function getUsrLogin($login,$pass){
        //$this->conectar()->query("SET NAMES 'utf8';");
        $sql="select * from usuarios where correo='$login' and clave='$pass'";
        $datos=$this->leerTabla($sql);
        $this->desconectar();
        return $datos;
    }
    
    public function num_filas($sql){
        $mysqli=$this->conectar();
        $consulta=$mysqli->query($sql);
        if ($mysqli->error) {
            try{
                throw new Exception("MySQL error $mysqli->error <br> Consulta:<br> $sql", $mysqli->errno);    
            } catch (Exception $e) {
                echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
                       // echo nl2br($e->getTraceAsString());
                exit();
            }
        }
        //$result = $consulta;
        /* determine number of rows result set */
        $this->desconectar();
        return $consulta->num_rows;
        
    }
        
    public function leerTabla($sql){
        $this->regs=array();
        $mysqli=$this->conectar();
        //$this->conectar()->query("SET NAMES 'utf8';");
        $consulta=$mysqli->query($sql);
        if ($mysqli->error) {
            try{
                throw new Exception("MySQL error $mysqli->error <br> Consulta:<br> $sql", $mysqli->errno);    
            } catch (Exception $e) {
                echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
                       // echo nl2br($e->getTraceAsString());
                exit();
            }
        }
       
        while($filas=$consulta->fetch_assoc()){
            $this->regs[]=$filas;
        }
         $this->desconectar();
        return $this->regs;
    }
    
    public function leeRegistro($campos,$where,$tabla){
        $this->reg=array();
        $sql="select $campos from $tabla where $where";
        //$this->conectar()->query("SET NAMES 'utf8';");
        $mysqli=$this->conectar();
        $consulta=$mysqli->query($sql);
        if ($mysqli->error) {
            try{
                throw new Exception("MySQL error $mysqli->error <br> Consulta:<br> $sql", $mysqli->errno);    
            } catch (Exception $e) {
                echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
                       // echo nl2br($e->getTraceAsString());
                exit();
            }
        }
        $filas=$consulta->fetch_assoc();
        $this->reg[]=$filas;
         $this->desconectar();
        return $this->reg;
    }
    public function actualizaRegistro($sql){
        $mysqli=$this->conectar();
        $mysqli->autocommit(false);
        $actualizar=$mysqli->query($sql);
        if ($mysqli->error) {
            try{
                throw new Exception("MySQL error $mysqli->error <br> Consulta:<br> $sql", $mysqli->errno);    
            } catch (Exception $e) {
                echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
                       // echo nl2br($e->getTraceAsString());
                exit();
            }
        }else{
            $mysqli->commit();
        }       
        $mysqli->autocommit(true);
        $this->desconectar();
        return $actualizar;
   
}

public function actualizaSecuencia($sql,$num,$lpad){
        $mysqli=$this->conectar();
        $mysqli->autocommit(false);
        $mysqli->query("SET @a=$num");
        $actualizar=$mysqli->query($sql);
        $pad=$mysqli->query($lpad);
        if ($mysqli->error) {
            try{
                throw new Exception("MySQL error $mysqli->error <br> Consulta:<br> $sql", $mysqli->errno);    
            } catch (Exception $e) {
                echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
                       // echo nl2br($e->getTraceAsString());
                exit();
            }
        }else{
            $mysqli->commit();
        }       
        $mysqli->autocommit(true);
        $this->desconectar();
        return $actualizar;
   
}

public function eliminaRegistro($sql){
    $mysqli=$this->conectar();
    $eliminado=$mysqli->query($sql);
    if ($mysqli->error) {
        try{
            throw new Exception("MySQL error $mysqli->error <br> Consulta:<br> $sql", $mysqli->errno);    
        } catch (Exception $e) {
            echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
                   // echo nl2br($e->getTraceAsString());
            exit();
        }
    }
    $this->desconectar();
    return $eliminado;
}

 }
?>
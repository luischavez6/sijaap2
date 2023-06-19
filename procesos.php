<?php
require_once 'Base_Datos.php';
require_once 'Base_Modelo.php';//Contiene funcion que conecta a la base de datos

$cn=new Base_Modelo; 
 $id= substr($_POST['mod_id'],0,12);
 $anio=$_POST['mod_anio'];
  $mes=$_POST['mod_mes'];
$sumames=$mes+1;
if($mes==0){
    $anio=$_POST['mod_anio']-1;
    $mes=12;
}else{
   
}
if($sumames>=12){
    $anio=$_POST['mod_anio']+1;
    $sumames=1;
}else{
   
}
 $lecac=$_POST['mod_lecac'];
 $excedente=0;
    $consumo=0;
    $vexc=0;
    $vinc=0;
    $sql="SELECT valor FROM parametros where id=2";
    $vs=$cn->leerTabla($sql);
    $vsueldo=$vs[0]['valor'];

    $sql="SELECT valor FROM parametros where id=5";
    $vc=$cn->leerTabla($sql);
    $vconsumo=$vc[0]['valor'];

    $sql="SELECT valor FROM parametros where id=6";
    $vve=$cn->leerTabla($sql);
    $vexcedente=$vve[0]['valor'];

    $sql="SELECT valor FROM parametros where id=7";
    $m3m=$cn->leerTabla($sql);
    $vm3m=$m3m[0]['valor'];

  $where=" id='$id' and anio='$anio' and mes='$mes'";
$campos="*";
$tabla=" recaudaciones";
$lecturas=$cn->leeRegistro($campos, $where, $tabla);
  $lecan=$lecturas[0]['lecan'];
  $lecturaac=$lecturas[0]['lecac'];
 if(($lecac-$lecturaac-$vm3m)>0){ 
     $excedente=$lecac-$lecan-$vm3m; 
}else{
    $excedente=0;
}
 $consumo=$lecac-$lecan;
$vcon=$vconsumo*$vsueldo;
$vexc=$excedente*($vexcedente*$vsueldo);
$vinc=$vcon+$vexc;

    if($lecan>$_POST['mod_lecac']){?><script>
       alert("La lectura actual no puede ser menor a la anterior")</script><?php
                     }else{
                            if($lecturaac==0.00){
              $sqlr="update  recaudaciones set lecan=$lecac,lecac=$lecac where id='$id' and anio='$anio' and mes='$mes'";
              $sqlr1="update  recaudaciones set lecan=$lecac where id='$id' and anio='$anio' and mes='$sumames'";
         
              //$sqll="update  recaudaciones set lecac=$lecac where id='$id' and anio='$anio' and mes='$mes'";
                    }else{
             if($lecturas[0]['lecac']>0){
                 $sqlr="update  recaudaciones set lecac=$lecac,"
            . "m3excedente=$excedente,consumo=$consumo,"
            . "vexcedente=$vexc,total=$vinc where id='$id' and anio='$anio' and mes='$mes'";
             $sqlr1="update  recaudaciones set lecan=$lecac where id='$id' and anio='$anio' and mes='$sumames'";
           
            }else{
        //     $sqll="update  recaudaciones set lecac=$lecac where id='$id' and anio='$anio' and mes='$mes'";
            $sqlr="update  recaudaciones set lecac=$lecac,lecan=$lecturaac,"
            . "m3excedente=$excedente,consumo=$consumo,"
            . "vexcedente=$vexc,total=$vinc where id='$id' and anio='$anio' and mes='$mes'";
             $sqlr1="update  recaudaciones set lecan=$lecac where id='$id' and anio='$anio' and mes='$sumames'";
             } }
        $query_updaterec = $cn->actualizaRegistro($sqlr);
        $query_updaterec1 = $cn->actualizaRegistro($sqlr1);
       // $query_updatelec = $cn->actualizaRegistro($sqll);
        if ($query_updaterec){
            $messages[] = 'Ingreso de Lectura  Correctamente.';
     
        } else{
     $errors []= 'Lo siento algo ha salido mal intenta nuevamente.';
      }
     
     
     if (isset($errors)){		
     ?>
        <div class='alert alert-danger' role='alert'>
        <?php
        foreach ($errors as $error) {
        ?>
                        <script>
                            mensaje('<?php echo $error ?>','no','error',3000);
                        </script>
        <?php	
                    }
        ?> 
        </div>
     <?php
     }
     if (isset($messages)){
     ?>
       
        <?php
        foreach ($messages as $message) {
                    ?>
    <script>
     alert("La lectura se ingreso Correctamente");  
     self.location= 'index.html'                          
             </script>
                    <?php
                    }
                    ?>
                </div>
     <?php
     }  
    }
 
       ?>

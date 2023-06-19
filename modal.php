<?php
require_once 'Base_Datos.php';
require_once 'Base_Modelo.php';//Contiene funcion que conecta a la base de datos

if ( isset( $_GET['id']) ){

  
    $rest = substr($id= $_GET['id'], 1, -1);  
 } else {
 
   
     }
      $id;
     $anioo=date('Y');
    $mess=date('m')-1;  
    $meses = array(1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');


     $cn=new Base_Modelo; 
   $campos="id,nombre,lecan,lecac,anio,mes,nmedidor";
 $tabla="recaudaciones";
  $where="id=$id and cobrado='N' and anio=$anioo and mes=$mess";
 $lectura=$cn->leeRegistro($campos,$where,$tabla);
 if($lectura[0]['lecac']>0){?>
<script>alert("Ya ingreso una lectura para este medidor con este valor <?php echo $lectura[0]['lecac']?>");
$('#mod_lecac').val('<?php echo  $lectura[0]['lecac'] ?>')
</script>
 <?php }else{

 }
?>
	<div class="modal fullscreen-modal fade" id="modalectura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 style="font-size: 20px;font-weight: bold;color: #0275BA" class="modal-title fa fa-lectura left" id="modal_lectura"> Agregar Lectura De <?php echo $meses[date($mess)]?> </h3>
                </div>
                <div class="modal-body">
                    <div id="result_lectura2"></div>
                    <form class="form-horizontal form-label-left input_mask" id="lecturaedit" name="lecturaedit">
                    <div class="col-md-12 col-md-9">
                        <label for="modl_codigo">Codigo:</label>
                        <input readonly value="<?php echo $rest;  ?>" style="text-transform:uppercase" maxlength="50" name="mod_id" id="mod_codigo" type="text" class="form-control" placeholder="Codigo">
                    </div>
                    <input name="modl_id" id="modl_id" class="form-control">
                    <div class="col-md-12 col-md-9">
                        <label for="modl_nombre">Contribuyente:</label>
                        <input readonly value="<?php echo $lectura[0]['nombre'];?>" style="text-transform:uppercase" maxlength="50" name="mod_nombre" id="mod_nombre" type="text" class="form-control" placeholder="Contribuyente">
                    </div>
                    <div id='lect'>
                        <div class="col-md-12 col-md-2">
                            <label for="modl_anio">Año:</label>
                            <input  readonly value="<?php echo $lectura[0]['anio'];?>" name="mod_anio" id="mod_anio" type="text" class="form-control" placeholder="Anio">
                        </div>
                        <div class="col-md-12 col-md-2">
                            <label for="modl_mes">Mes:</label>
                            <input readonly  value="<?php echo $lectura[0]['mes'];?>" name="mod_mes" id="mod_mes" type="text" class="form-control" placeholder="Mes">
                        </div>
                        <div class="col-md-12 col-md-2">
                            <label for="modl_lecac">Lectura Anterior:</label>
                            <input readonly value="<?php echo $lectura[0]['lecan'];?>" name="mod_lecan" id="mod_lecan" required type="text" class="form-control" placeholder="Lectura">
                        </div>
                        <div class="col-md-12 col-md-2">
                            <label for="modl_lecac">Ingrese la Lectura De <?php  echo $meses[date($mess)] ?>:</label>
                            <input   value="" name="mod_lecac" id="mod_lecac" required type="text" class="form-control" placeholder="Lectura">
                        </div>
                    </div>
                    <div class="form-group"></div>
                    <div class="modal-footer">
                        <input id="savedata" type="submit" class="btn btn-success" value="Guardar">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>                             
        </div>
    </div>
       <div class="x_content">
                            <div class="table-responsive">
                                <!-- ajax -->
                                    <div id="resultados"></div><!-- Carga los datos ajax -->
                                    <div class='outer_div'></div><!-- Carga los datos ajax -->
                                <!-- /ajax -->
                            </div>
</div>
        
    </body>

    <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0
            </div>
            <strong>Copyright &copy; 2019-2020 <a href="https://computrainsystem.com">Computrain System</a>.</strong> Todos los derechos reservados.
        </footer>
<script>
    $( "#lecturaedit" ).submit(function( event ) {
    
    var lec = $(this).serialize();
         
          
   
    $.ajax({
        type: "POST",
        url: "procesos.php",
        data: lec,
        beforeSend: function(objeto){
            $("#resultadospro").html("Mensaje: Cargando...");
        },
        success: function(datos){
            $("#resultadospro").html(datos);
          
        }
    });
    event.preventDefault();
    
   
})
</script>
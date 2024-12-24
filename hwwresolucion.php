<?php
header("Content-Type: text/html;charset=utf-8");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//variables recibidas desde la plantilla
include('v_session.php');

$perfilid=$_SESSION['user_role'];

	
$tipoRes = isset($_POST['select_tipo']) ? $_POST['select_tipo'] : '';
$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
$estado = isset($_POST['select_estado']) ? $_POST['select_estado'] : '';
switch ($estado) {
    case '0':
        $marca0 = 'selected';
        $marca = '';
        $marca1 = '';
        $marca2 = '';
        $estadox = 0;
        break;
    case '1':
        $marca1 = 'selected';
        $marca = '';
        $marca0 = '';
        $marca2 = '';
        $estadox = 1;
        break;
    case '2':
        $marca2 = 'selected';
        $marca = '';
        $marca0 = '';
        $marca1 = '';
        $estadox = 2;
        break;
    default:
        $marca = 'selected';
        $marca0 = '';
        $marca1 = '';
        $marca2 = '';
        $estadox = '';
        break;
}
include_once('head.php');
include_once('conexion.php');
include_once('filtrado2.php');


//Obtener tipo resolucion
$sql_tipo = "select TipoResolucionId,TipoResolucionDsc from TIPORESOLUCION order by 2;";
$stmt_tipo = $pdo->prepare($sql_tipo);
$stmt_tipo->execute();
$Tipo_res = $stmt_tipo->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="container-fluid">
        <section class="row justify-content-center">
            <section col-12 col-sm-4 col-md-2 id="contenedor0">
                <div class="col-md-4" style="margin-bottom: 10px;">
                    <div class="card p-3 mb-5 bg-white rounded" style="width: 100rem;">
                        <div class="card-header">
                            <img class='' src='img/logoFFyb_2024.png' height='50' />
                            <div class="card-body">
                                <div class="col-md-8">
                                    <h4>Administrar </h4>
                                    <div id="menu"><?php include_once('menu.php'); ?></div>
                                    <form class="form-inline" method="POST" action="">
                                        <div class="form-group">
                                            <label>Descripcion</label>
                                            <input type="text" value="<?php echo $descripcion; ?>" id="descripcion" name="descripcion" class="form-control">
                                        </div>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <div class="form-group">
                                            <label for="estado">Estado</label>
                                            <select name="select_estado" id="select_estado" class="form-control">
                                                <option value="" <?php echo $marca;?> >Todos</option>
                                                <option value="0" <?php echo $marca0;?>>Pendiente</option>
                                                <option value="1" <?php echo $marca1;?>>Confirmado</option>
                                                <option value="2" <?php echo $marca2;?>>Test</option>
                                            </select>
                                        </div>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <div class="form-group">
                                            <label for="TipoRes">Tipo Resolucion</label>
                                            <select name="select_tipo" id="select_tipo" class="form-control">
                                                <option value="">Ninguno</option>
                                                <?php foreach ($Tipo_res as $TipoR) { 
                                                    if ($TipoR['TipoResolucionId'] == $tipoRes){
                                                        echo "<option value='".$TipoR['TipoResolucionId']."' selected>".$TipoR['TipoResolucionDsc']."</option>";
                                                    }else{
                                                        echo "<option value='".$TipoR['TipoResolucionId']."'>".$TipoR['TipoResolucionDsc']."</option>";
                                                    }
                                                }?>
                                            </select>
                                        </div>

                                        <button id="filtrarRes" class="btn btn-primary mt-3">Filtrar</button>
                                    </form>
                                    <!-- Tabla para mostrar los certificados -->
                                </div>
                            </div>
                        </div>
                        <div id="mensajes"></div>
                        
                        <div class="table-responsive">
                            <table class="table mt-3 table-striped">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Año</th>
                                        <th>Origen</th>
                                        <th>Nº.</th>
                                        <th>Fecha</th>
                                        <th>Descripción</th>
                                        <th>Expediente</th>
                                        <th>Fecha Exp.</th>
                                        <th>tipo Res</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody id="resultados_certificados">
                               
                                
                                
                                <?php foreach ($resu as $res) { ?>
                                        <tr>
                                            <td><?php echo $res['ResolucionId']; ?></td>
                                            <td><?php echo $res['ResolucionAnio']; ?></td>  
                                            <td><?php echo $res['OrigenResolucionId']; ?></td>
                                            <td><?php echo $res['ResolucionNumero']; ?></td>
                                            <td><?php echo $res['ResolucionFecha']; ?></td>
                                            <td><?php echo $res['ResolucionDescripcion']; ?></td>
                                            <td><?php echo $res['ResolucionExpediente']; ?></td>
                                            <td><?php echo $res['ResolucionExpedienteFecha']; ?></td>
                                            <td><?php echo $res['TipoResolucionDsc']; ?></td>
                                            <td><?php echo $res['ESTADOS']; ?></td>
                                                
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div><?php
                            for ($i = 1; $i <= $totalPages; $i++) {
                                echo "<a href='?page=$i'>" . ($i == $page ? "<strong>$i</strong>" : $i) . "</a> ";
                            }?>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </section>
    </section>

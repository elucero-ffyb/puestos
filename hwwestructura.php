<?php
header("Content-Type: text/html;charset=utf-8");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//variables recibidas desde la plantilla
include('v_session.php');

$perfilid=$_SESSION['user_role'];
//echo $perfilid."---</br>";

// Capturar los valores enviados desde el formulario
$catedra = isset($_POST['select_cate']) ? $_POST['select_cate'] : '';
$cargox = isset($_POST['select_cargo']) ? $_POST['select_cargo'] : '';
$denominacion = isset($_POST['select_deno']) ? $_POST['select_deno'] : '';
$legajo = isset($_POST['legajo']) ? $_POST['legajo'] : '';
$situacion = isset($_POST['select_situ']) ? $_POST['select_situ'] : '';
$estado = isset($_POST['select_esta']) ? $_POST['select_esta'] : '';
$vigencia = isset($_POST['Vigencia']) ? $_POST['Vigencia'] : '';
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$caracter = isset($_POST['caracter']) ? $_POST['caracter'] : '';
$origen = isset($_POST['origen']) ? $_POST['origen'] : '';
$plantel = isset($_POST['plantel']) ? $_POST['plantel'] : '';



require('conexion.php');

// Obtener las catedras disponibles
$sql_cate = "SELECT CatedraId,CatedraDescripcion from CATEDRA order by 2;";
$stmt_cate = $pdo->prepare($sql_cate);
$stmt_cate->execute();
$cate = $stmt_cate->fetchAll(PDO::FETCH_ASSOC);

// Obtener las denominacion
$sql_deno = "SELECT DenId,DenDsc from DENOMINACION order by 2;";
$stmt_deno = $pdo->prepare($sql_deno);
$stmt_deno->execute();
$deno = $stmt_deno->fetchAll(PDO::FETCH_ASSOC);


// Obtener los cargos disponibles
$sql_cargo = "SELECT * from CARGO order by 2,3;";
$stmt_cargo = $pdo->prepare($sql_cargo);
$stmt_cargo->execute();
$cargo = $stmt_cargo->fetchAll(PDO::FETCH_ASSOC);

// Obtener la situaciones
$sql_situ = "SELECT * from SITUACION order by 2;";
$stmt_situ = $pdo->prepare($sql_situ);
$stmt_situ->execute();
$situ = $stmt_situ->fetchAll(PDO::FETCH_ASSOC);

// Obtener la estados
$sql_esta = "SELECT EstadoId,EstadoDsc from estado order by 2;";
$stmt_esta = $pdo->prepare($sql_esta);
$stmt_esta->execute();
$esta = $stmt_esta->fetchAll(PDO::FETCH_ASSOC);


// Obtener la caracter 
$sql_cara = "SELECT CaracterId,CaracterDsc from CARACTER order by 2;";
$stmt_cara = $pdo->prepare($sql_cara);
$stmt_cara->execute();
$cara = $stmt_cara->fetchAll(PDO::FETCH_ASSOC);


// Obtener la origen
$sql_ori = "SELECT OrigenResolucionId,OrigenResolucionDsc from ORIGENRESOLUCION order by 2;";
$stmt_ori = $pdo->prepare($sql_ori);
$stmt_ori->execute();
$orig = $stmt_ori->fetchAll(PDO::FETCH_ASSOC);


include_once('filtrado.php');
//var_dump($resu);
include_once('head.php');
?>

<body>

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
                                            <!-- Filtro por Año -->
                                            <label>Catedra</label>
                                            <select name="select_cate" id="select_cate" class="form-control" width='10px'>
                                                <option value="">Ninguno</option>
                                                <?php foreach ($cate as $cat) { 
                                                    if ($cat['CatedraId'] == $catedra){
                                                        echo "<option value='".$cat['CatedraId']."' selected>".$cat['CatedraDescripcion']."</option>";
                                                    }else{
                                                        echo "<option value='".$cat['CatedraId']."'>".$cat['CatedraDescripcion']."</option>";
                                                    }
                                                } ?>
                                            </select>
                                        </div>
                                        &nbsp;&nbsp;&nbsp;&nbsp;            
                                        <div class="form-group">
                                            <label>Cargo</label>
                                            <select  name="select_cargo" id="select_cargo" class="form-control">
                                                <option value="">Ninguno</option>
                                                <?php foreach ($cargo as $carg) { 
                                                    if ($carg['CargoId'] == $cargox){
                                                        echo "<option value='".$carg['CargoId']."' selected>".$carg['CargoDsc']."-".$carg['DedicacionId']."</option>";
                                                    }else{
                                                        echo "<option value='".$carg['CargoId']."'>".$carg['CargoDsc']."-".$carg['DedicacionId']."</option>";
                                                    }
                                                } ?>
                                            </select>
                                        </div>
                                        &nbsp;&nbsp;&nbsp;&nbsp;

                                        <div class="form-group">
                                            <label>Denominacion</label>
                                            <select  name="select_deno" id="select_deno" class="form-control">
                                                <option value="">Ninguno</option>
                                                <?php foreach ($deno as $den) {
                                                    if ($den['DenId'] == $denominacion){
                                                        echo "<option value='".$den['DenId']."' selected>".$den['DenDsc']."</option>";
                                                    }else{
                                                        echo "<option value='".$den['DenId']."'>".$den['DenDsc']."</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <div class="form-group">
                                            <label>legajo</label>
                                            <input type="text" value="<?php echo $legajo; ?>"  name="legajo" id="legajo" class="form-control">
                                        </div>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <div class="form-group">
                                            <label>Situacion</label>
                                            <select name="select_situ" id="select_situ" class="form-control">
                                                <option value="">Ninguno</option>
                                                <?php foreach ($situ as $sit) { 
                                                    if ($sit['SituacionId'] == $situacion){
                                                        echo "<option value='".$sit['SituacionId']."' selected>".$sit['SituacionDsc']."</option>";
                                                    }else{
                                                        echo "<option value='".$sit['SituacionId']."'>".$sit['SituacionDsc']."</option>";
                                                    }
                                                } ?>
                                            </select>
                                        </div>
                                        &nbsp;&nbsp;&nbsp;&nbsp;            
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <select name="select_esta" id="select_esta" class="form-control">
                                                <option value="">Ninguno</option>
                                                <?php foreach ($esta as $est) { 
                                                    if ($est['EstadoId'] == $estado){
                                                        echo "<option value='".$est['EstadoId']."' selected>".$est['EstadoDsc']."</option>";
                                                    }else{
                                                        echo "<option value='".$est['EstadoId']."'>".$est['EstadoDsc']."</option>";
                                                    }
                                                }?>
                                                
                                            </select>
                                        </div>
                                        &nbsp;&nbsp;&nbsp;&nbsp;            
                                        <div class="form-group">
                                            <label for="Vigencia">vigencia</label>
                                            <select name="Vigencia" id="Vigencia" class="form-control">
                                                <option value="">Todos</option>
                                                <option value="1">No Aplica</option>
                                                <option value="2">En Espera</option>
                                                <option value="3">Activa</option>
                                                <option value="4">Vencida</option>
                                            </select>
                                        </div>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <div class="form-group">
                                            <label>Nombre</label>
                                            <input type="text" value="<?php echo $nombre; ?>" id="nombre" name="nombre" class="form-control">
                                        </div>
                                        &nbsp;&nbsp;&nbsp;&nbsp;        
                                        <div class="form-group">
                                            <label for="caracter">Caracter</label>
                                            <select name="caracter" id="caracter" class="form-control">
                                                <option value="">Ninguno</option>
                                                <?php foreach ($cara as $car) { 
                                                    if ($car['CaracterId'] == $caracter){
                                                        echo "<option value='".$car['CaracterId']."' selected>".$car['CaracterDsc']."</option>";
                                                    }else{
                                                        echo "<option value='".$car['CaracterId']."'>".$car['CaracterDsc']."</option>";
                                                    }
                                                }?>
                                            </select>
                                        </div>
                                        &nbsp;&nbsp;&nbsp;&nbsp;            
                                        <div class="form-group">
                                            <label for="origen">Origen</label>
                                            <select name="origen" id="origen" class="form-control">
                                                <option value="">Ninguno</option>
                                                <?php foreach ($orig as $ori) { 
                                                    if ($ori['OrigenResolucionId'] == $origen){
                                                        echo "<option value='".$ori['OrigenResolucionId']."' selected>".$ori['OrigenResolucionDsc']."</option>";
                                                    }else{
                                                        echo "<option value='".$ori['OrigenResolucionId']."'>".$ori['OrigenResolucionDsc']."</option>";
                                                    }
                                                }?>
                                            </select>
                                        </div>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <div class="form-group">
                                            <label>Plantel</label>
                                            <input type="text" value="<?php echo $plantel; ?>" id="plantel" name="plantel" class="form-control">
                                        </div>

                                        <button id="filtrar" class="btn btn-primary mt-3">Filtrar</button>
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
                                        <th>Cátedra</th>
                                        <th>Test</th>
                                        <th>Cargo</th>
                                        <th>Den.</th>
                                        <th>Dedicación</th>
                                        <th>Id.Est.</th>
                                        <th>Descripción</th>
                                        <th>Legajo</th>
                                        <th>Nombre</th>
                                        <th>Situación</th>
                                        <th>Estado</th>
                                        <th>Caracter</th>
                                        <th>Origen</th>
                                        <th>Resolución</th>
                                        <th>Fecha</th>
                                        <th>Desde</th>
                                        <th>Hasta</th>
                                        <th>Vigencia</th>
                                        <th>Partida</th>
                                    </tr>
                                </thead>
                                <tbody id="resultados_certificados">
                                    <?php foreach ($resu as $res) { ?>
                                        <tr>
                                            <td><?php echo $res['CatedraDescripcion']; ?></td>
                                            <td><?php echo $res['EstructuraTest']; ?></td>  
                                            <td><?php echo $res['CargoId']; ?></td>
                                            <td><?php echo $res['CargoDsc']; ?></td>
                                            <td><?php echo $res['DedicacionDsc']; ?></td>
                                            <td><?php echo $res['EstructuraId']; ?></td>
                                            <td><?php echo $res['EstructuraDsc']; ?></td>
                                            <td><?php echo $res['LegajoId']; ?></td>
                                            <td><?php echo $res['LegajoNombre']; ?></td>
                                            <td><?php echo $res['SituacionDsc']; ?></td>
                                            <td><?php echo $res['EstadoDsc']; ?></td>
                                            <td><?php echo $res['CaracterDsc']; ?></td>
                                            <td><?php echo $res['OrigenResolucionDsc']; ?></td>
                                            <td><?php echo $res['ResolucionNumero']; ?></td>
                                            <td><?php echo $res['ResolucionFecha']; ?></td>
                                            <td><?php echo $res['EstructuraVigenciaDesde']; ?></td>
                                            <td><?php echo $res['EstructuraVigenciaHasta']; ?></td>
                                            <td><?php echo $res['Vigencia']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-link abrir-modal-plantel" data-toggle="modal"  data-target="#modalPlantel" 
                                                    data-estructura-id="<?php echo $res['EstructuraId']; ?>" 
                                                    data-plantel="<?php echo $res['PlantelDsc']; ?>">
                                                    <?php echo $res['PlantelDsc'] ?: $res['PlantelDsc']; ?>
                                                </button>
                                            </td>    
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </section>
        </section>
    </section>

    <!-- Modal para mostrar la vista del certificado -->
    <div class="modal fade" id="certificadoModal" tabindex="-1" role='dialog' aria-labelledby="certificadoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="certificadoModalLabel"> </h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>&times;</button>
                </div>
                <div class="modal-body" id="modal-body-content">
                    <!-- Aquí se cargará el contenido del certificado -->
                </div>
                <div class="modal-footer">
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar.</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar Plantel -->
    <div class="modal fade" id="modalPlantel" tabindex="-1" role="dialog" aria-labelledby="modalPlantelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPlantelLabel">Editar Plantel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formPlantel">
                        <input type="hidden" id="estructuraId" name="estructuraId">
                        <div class="form-group">
                            <label for="plantelInput">Descripción del Plantel</label>
                            <input type="text" class="form-control" id="plantelInput" name="plantel" placeholder="Ingrese descripción del plantel">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="guardarPlantel">Guardar</button>
                </div>
            </div>
        </div>
    </div>


    <script>
    $(document).ready(function () {
        // Abrir modal y cargar datos en los campos
        $('.abrir-modal-plantel').click(function () {
            //alert('aaaa');
            const estructuraId = $(this).data('estructura-id');
            const plantel = $(this).data('plantel');

            // Llenar el modal con los datos
            $('#estructuraId').val(estructuraId);
            $('#plantelInput').val(plantel);
        });

        // Guardar datos al hacer clic en "Guardar"
        $('#guardarPlantel').click(function () {
            const estructuraId = $('#estructuraId').val();
            const plantel = $('#plantelInput').val();

            $.ajax({
                url: 'guardar_plantel.php',
                method: 'POST',
                data: {
                    estructuraId: estructuraId,
                    plantel: plantel
                },
                success: function (response) {
                    // Recargar la tabla o actualizar solo la fila correspondiente
                    alert('Datos guardados correctamente');
                    $('#modalPlantel').modal('hide');
                    location.reload(); // O actualiza la tabla dinámicamente
                    //alert(response.message);
                },
                error: function () {
                    alert('Ocurrió un error al guardar los datos');
                }
            });
        });
    });
</script>

    <script type="text/javascript" src="js/tether.min.js"></script>

</body>

</html>
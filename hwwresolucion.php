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
$estado = isset($_POST['select_estado']) ? $_POST['select_estado'] : 0;
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
                            <table class="table mt-3 table-striped" id="tablaCertificados">
                                <thead>
                                        
                                    <tr>
                                        <th  onclick="ordenarTabla(0)">id</th>
                                        <th  onclick="ordenarTabla(1)">Año</th>
                                        <th  onclick="ordenarTabla(2)">Origen</th>
                                        <th  onclick="ordenarTabla(3)">Nº.</th>
                                        <th  onclick="ordenarTabla(4)">Fecha</th>
                                        <th  onclick="ordenarTabla(5)">Descripción</th>
                                        <th  onclick="ordenarTabla(6)">Expediente</th>
                                        <th  onclick="ordenarTabla(7)">Fecha Exp.</th>
                                        <th  onclick="ordenarTabla(8)">tipo Res</th>
                                        <th  onclick="ordenarTabla(9)">Estado</th>
                                        <th><i class="far fa-file-excel" id="exportarExcel" title="exportar a excel"></th>
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
                                            <td colspan=2><?php echo $res['ESTADOS']; ?></td>
                                                
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

<script>
    document.getElementById('exportarExcel').addEventListener('click', function() {
    // Obtener la tabla
    var table = document.querySelector('table');
    
    // Convertir la tabla a una hoja de trabajo de Excel
    var wb = XLSX.utils.table_to_book(table, {sheet: "Datos"});

    // Exportar el archivo Excel
    XLSX.writeFile(wb, 'salida_datos_resoluciones.xlsx');
});

</script>   
<script>
        // Función para ordenar la tabla
        let ordenAscendente = true; // Estado de orden, ascendente o descendente

        function ordenarTabla(columnaIndex) {
            let tabla = document.getElementById("tablaCertificados");
            let filas = Array.from(tabla.getElementsByTagName("tr")).slice(1); // Obtener todas las filas, excepto el encabezado

            // Ordenar las filas
            filas.sort((a, b) => {
                let celdaA = a.cells[columnaIndex].innerText.trim();
                let celdaB = b.cells[columnaIndex].innerText.trim();

                // Si la columna es de tipo fecha (aa/mm/aaaa)
                if (celdaA.match(/\d{2}\/\d{2}\/\d{4}/) && celdaB.match(/\d{2}\/\d{2}\/\d{4}/)) {
                    // Convertir las fechas de formato aa/mm/aaaa a un formato comparable
                    let fechaA = celdaA.split('/').reverse().join('-'); // Cambia a yyyy-mm-dd
                    let fechaB = celdaB.split('/').reverse().join('-'); // Cambia a yyyy-mm-dd
                    celdaA = new Date(fechaA);
                    celdaB = new Date(fechaB);
                } else if (!isNaN(celdaA) && !isNaN(celdaB)) { // Si la columna es un número
                    celdaA = parseFloat(celdaA);
                    celdaB = parseFloat(celdaB);
                }

                // Ordenar dependiendo del estado de ordenAscendente
                if (ordenAscendente) {
                    return celdaA > celdaB ? 1 : (celdaA < celdaB ? -1 : 0);
                } else {
                    return celdaA < celdaB ? 1 : (celdaA > celdaB ? -1 : 0);
                }
            });

            // Volver a agregar las filas ordenadas a la tabla
            filas.forEach(fila => tabla.appendChild(fila));

            // Alternar el orden
            ordenAscendente = !ordenAscendente;
        }

        
    </script>
</body>

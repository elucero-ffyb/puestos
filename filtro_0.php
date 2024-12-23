<?php


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

// Obtener la situaciones
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
                                    <form class="form-inline" onsubmit='return(false);'>
                                        <div class="form-group">
                                            <!-- Filtro por Año -->
                                            <label>Catedra</label>
                                            <select id="select_cate" class="form-control" width='10px'>
                                                <option value="">Ninguno</option>
                                                <?php foreach ($cate as $cat) { ?>
                                                    <option value="<?php echo $cat['CatedraId']; ?>"><?php echo $cat['CatedraDescripcion']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Cargo</label>
                                            <select id="select_cargo" class="form-control">
                                                <option value="">Ninguno</option>
                                                <?php foreach ($cargo as $carg) { ?>
                                                    <option value="<?php echo $carg['CargoId']; ?>"><?php echo $carg['CargoDsc']."-".$carg['DedicacionId']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Denominacion</label>
                                            <select id="select_deno" class="form-control">
                                                <option value="">Ninguno</option>
                                                <?php foreach ($deno as $den) { ?>
                                                    <option value="<?php echo $den['DenId']; ?>"><?php echo $den['DenDsc']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>legajo</label>
                                            <input type="text" value="" id="legajo" class="form-control">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Situacion</label>
                                            <select id="select_situ" class="form-control">
                                                <option value="">Ninguno</option>
                                                <?php foreach ($situ as $sit) { ?>
                                                    <option value="<?php echo $sit['SituacionId']; ?>"><?php echo $sit['SituacionDsc']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label>Estado</label>
                                            <select id="select_esta" class="form-control">
                                                <option value="">Ninguno</option>
                                                <?php foreach ($esta as $est) { ?>
                                                    <option value="<?php echo $est['EstadoId']; ?>"><?php echo $est['EstadoDsc']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

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
                                        <div class="form-group">
                                            <label>Nombre</label>
                                            <input type="text" value="" id="nombre" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="caracter">Caracter</label>
                                            <select name="caracter" id="caracter" class="form-control">
                                                <option value="">Ninguno</option>
                                                <?php foreach ($cara as $car) { ?>
                                                    <option value="<?php echo $car['CaracterId']; ?>"><?php echo $car['CaracterDsc']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="origen">Origen</label>
                                            <select name="origen" id="origen" class="form-control">
                                                <option value="">Ninguno</option>
                                                <?php foreach ($orig as $ori) { ?>
                                                    <option value="<?php echo $ori['OrigenResolucionId']; ?>"><?php echo $ori['OrigenResolucionDsc']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Plantel</label>
                                            <input type="text" value="" id="plantel" class="form-control">
                                        </div>

                                        <button id="filtrar" class="btn btn-primary mt-3">Filtrar</button>
                                    </form>
                                    <!-- Tabla para mostrar los certificados -->
                                </div>
                            </div>
                        </div>
                        <div id="mensajes"></div>
                        <table class="table mt-3">
                            <thead>
                                <tr>
                                    <th>Catedra</th>
                                    <th>Test</th>
                                    <th>Cargo</th>
                                    <th>Den.</th>
                                    <th>Dedicacion</th>
                                    <th>Id.Est.</th>
                                    <th>Descripcion</th>
                                    <th>Legajo</th>
                                    <th>Nombre</th>
                                    <th>Situacion</th>
                                    <th>Estado</th>
                                    <th>Caracter</th>
                                    <th>Origen</th>
                                    <th>Resolucion</th>
                                    <th>Fecha</th>
                                    <th>Desde</th>
                                    <th>hasta</th>
                                    <th>Vigencia</th>
                                    <th>plantel</th>
                                </tr>
                            </thead>
                            <tbody id="resultados_certificados">
                                <!-- Aquí se cargan los resultados de la búsqueda -->
                            </tbody>
                        </table>
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

    <script>
        // Función para cargar los periodos según el año seleccionado
        document.getElementById('select_ano').addEventListener('change', function() {
            var ano = this.value;
            var select_periodo = document.getElementById('select_periodo');
            select_periodo.innerHTML = '<option value="">Cargando periodos...</option>';

            fetch('get_periodos.php?ano=' + ano)
                .then(response => response.json())
                .then(data => {
                    select_periodo.innerHTML = '<option value="">Seleccione un periodo</option>';
                    data.forEach(function(periodo) {
                        var option = document.createElement('option');
                        option.value = periodo.id_ddjj_head;
                        option.textContent = periodo.periodo;
                        select_periodo.appendChild(option);
                    });
                });
        });

        // Cargar las fechas según el año y periodo seleccionado
        document.getElementById('select_periodo').addEventListener('change', function() {
            var id_ddjj_head = this.value;
            var select_fecha = document.getElementById('select_fecha');
            select_fecha.innerHTML = '<option value="">Cargando fechas...</option>';

            fetch('get_fechas.php?id_ddjj_head=' + id_ddjj_head)
                .then(response => response.json())
                .then(data => {
                    select_fecha.innerHTML = '<option value="">Seleccione una fecha</option>';
                    data.forEach(function(fecha) {
                        var option = document.createElement('option');
                        option.value = fecha.fecha;
                        option.textContent = fecha.fecha;
                        select_fecha.appendChild(option);
                    });
                });
        });

        // Función para filtrar y mostrar los certificados pendientes
        document.getElementById('filtrar').addEventListener('click', function() {
            var ano = document.getElementById('select_ano').value;
            var periodo = document.getElementById('select_periodo').value;
            var fecha = document.getElementById('select_fecha').value;
            var tipo_certificado = document.getElementById('select_tipo_certificado').value;
            var estado = document.getElementById('estado').value;

            $("#mensajes").text('');

            fetch(`listar_certificados_filtrados.php?ano=${ano}&periodo=${periodo}&fecha=${fecha}&tipo_certificado=${tipo_certificado}&estado=${estado}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('resultados_certificados').innerHTML = html;
                });
        });

        // Función para cargar el modal con el contenido del certificado
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('action-button')) {
                event.preventDefault();

                var button = event.target;
                var action = button.getAttribute('data-action');
                var href = button.getAttribute('href');


                // Dependiendo de la acción, se obtiene la confirmación del usuario
                var confirmMessage = '';
                if (action === 'Ver') {
                    confirmMessage = '¿Desea ver el certificado?';
                } else if (action === 'Aceptar') {
                    confirmMessage = '¿Está seguro de que desea aceptar este certificado?';
                } else if (action === 'Rechazar') {
                    confirmMessage = '¿Está seguro de que desea rechazar este certificado?';
                } else if (action === 'Eliminar') {
                    confirmMessage = '¿Está seguro de que desea eliminar este certificado?';
                }

                if (confirm(confirmMessage)) {
                    // Si la acción es "Ver", se carga el certificado en el modal
                    if (action === 'Ver') {
                        var url = new URL(href, window.location.origin);
                        var params = new URLSearchParams(url.search);
                        var id_certificado = params.get("id_certificado"); // se utiliza el método GET para captar el valor del parámetro nombre

                        $.ajax({
                            type: "GET",
                            dataType: 'json',
                            url: 'ver_certificado_ajax.php',
                            data: {
                                id_certificado: id_certificado
                            },
                            success: function(response) {
                                if (response.respuesta == true) {
                                    $("#modal-body-content").html(response.MyData);
                                    $('#certificadoModal').modal('show');
                                } else {
                                    $("#modal-body-content").html(response.mensaje);
                                    $('#certificadoModal').modal('show');
                                }
                            },
                            error: function() {
                                alert('Error general en el sistema');
                            }
                        });
                    }else if(action === 'Eliminar'){
                        //alert('aaaaaa');
                        var url = new URL(href, window.location.origin);
                        var params = new URLSearchParams(url.search);
                        var id_certificado = params.get("id_certificado"); // se utiliza el método GET para captar el valor del parámetro nombre
                        $.ajax({
                            type: "GET",
                            dataType: 'json',
                            url: 'eliminar_certificado.php',
                            data: {
                                id_certificado: id_certificado
                            },
                            success: function(response) {
                                if (response.mensajeOk == true) {
                                    //quiero invocar a filtrar nuevamente
                                    $('#mensajes').text('se elimino con exito! seleccione filtrar nuevamente');
                                    document.getElementById('filtrar').click();
                                } else {
                                    //$("#modal-body-content").html(response.mensaje);
                                    //$('#certificadoModal').modal('show');
                                    $('#mensajes').text('hubo un error al querer eliminar el certificado');
                                }
                            },
                            error: function() {
                                alert('Error general en el sistema');
                            }
                        });
                    } else {
                        // Si es otra acción (Aceptar/Rechazar)
                        //window.location.href = href;
                        //verificar que valor tiene estado 2 aceptar 3 rechazar
                        var url = new URL(href, window.location.origin);
                        var params = new URLSearchParams(url.search);
                        var id_certificado = params.get("id_certificado"); // se utiliza el método GET para captar el valor del parámetro nombre
                        var estado = params.get("estado");
                        //alert(estado);
                        $.ajax({
                            type: "GET",
                            dataType: 'json',
                            url: 'cambiar_estado.php',
                            data: {
                                id_certificado: id_certificado,estado: estado
                            },
                            success: function(response) {
                                if (response.mensajeOk == true) {
                                    //quiero invocar a filtrar nuevamente
                                    $('#mensajes').text('se cambio de estado con exito! seleccione filtrar nuevamente');
                                    document.getElementById('filtrar').click();
                                } else {
                                    //$("#modal-body-content").html(response.mensaje);
                                    //$('#certificadoModal').modal('show');
                                    $('#mensajes').text('hubo un error al querer cambiar de estado el certificado');
                                    document.getElementById('filtrar').click();
                                }
                            },
                            error: function() {
                                //alert('Error general en el sistema');
                                document.getElementById('filtrar').click();
                            }
                        });

                    }
                }
            }
        });
    </script>
    <script type="text/javascript" src="js/tether.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>

</body>

</html>
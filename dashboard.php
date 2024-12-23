<?php
header("Content-Type: text/html;charset=utf-8");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//echo $_SESSION['user_role'];

include('v_session.php');
include('head.php');
include('conexion.php');

//echo $_SESSION['user_role']."<br>";
$perfilid=$_SESSION['user_role'];
//echo $perfilid."---</br>";
?>
<body>

<section class="container-fluid">
    <section class="row justify-content-center">
        <section col-12 col-sm-4 col-md-2 id="contenedor0">
            <div class="col-md-4" style="margin-bottom: 10px;">
                <div class="card p-3 mb-5 bg-white rounded" style="width: 65rem;">
                    <div class="card-header">
                        <img class='' src='img/logoFFyb_2024.png' height='50' />
                        <div class="card-body">
                            <div class="col-md-8">
                                <h4>Sistema puestos de trabajo</h4>
                                <div id="menu"><?php include('menu.php'); ?></div>
                                <!-- Tabla para mostrar los resultados -->
                                <div class="jumbotron" id="resultado" height="100%">a
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="mensajes"></div>
                 
                </div>
            </div>
            <div class="container" height="100%">
                b

            </div>
        </section>
    </section>
</section>
    
</body>
</html>

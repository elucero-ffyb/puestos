<?php
header("Content-Type: text/html;charset=utf-8");
//session_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); // Sin hash aún, para usar password_verify
    echo $password."<br>";
    require('conexion.php');

    // Consulta para obtener el usuario
    //$sql = "SELECT UsuarioId , UsuarioNombre, UsuarioPassword, PerfilId FROM USUARIO WHERE trim(UsuarioId) = :username";

    $sql="SELECT UsuarioId , UsuarioNombre, UsuarioPassword, PerfilId
          FROM usuario
          WHERE ltrim(UsuarioId) =:username";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':username' => $username]);
    //$user = $stmt->fetch(PDO::FETCH_OBJ);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

  
    if (!empty($user)) {
        // Verificar la contraseña ingresada contra el hash almacenado
        //var_dump($user);
        //echo "<br>";
            // Contraseña correcta: inicializar sesión
            $_SESSION['user_id'] = $user['UsuarioId'];
            $_SESSION['user_name'] = $user['UsuarioNombre'];
            $_SESSION['user_role'] = $user['PerfilId'];
            // Redirigir al dashboard
            header('Location: dashboard.php');
       
    } else {
        $error = "Usuario no encontrado.";
    }
}

include_once('head.php');

?>


<br>

<section class="container-fluid">
    <section class="row justify-content-center">
        <section col-12 col-sm-4 col-md-2 id="contenedor0">
            <div class="col-md-4" style="margin-bottom: 10px;">
                <div class="card p-3 mb-5 bg-white rounded" style="width: 20rem;">
                    <div class="card-header">
                        <img class='' src='img/logoFFyb_2024.png' width='100%' height='50' />
                        <span class='titu'>Ingrese sus datos</span>
                    </div>
                    <div class="card-body">

                        <div class="input-group" id="mensaje"></div>

                        <form action="" name="f1" method="POST" class="form-container">
                            <label for="username">Usuario</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>
                            <label for="password">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <br />
                            <div class="input-group">
                                <button type="submit" class="btn btn-primary btn-block" id="Iniciar">Ingresar</button>
                            </div>
                        </form>

                        <div class="input-group" id="mensaje2"></div>

                    </div>
                </div>
            </div>
            </div>
        </section>
    </section>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
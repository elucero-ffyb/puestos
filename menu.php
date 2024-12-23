<?php 
//recorrer segun perfil el menu que corresponda


$query = "SELECT p.PerfilDescripcion, p2.OpcionHabilitadaId, p2.PerfilOpcionDescripcion, p2.PerfilOpcionURL 
          FROM perfil p 
          INNER JOIN perfilopcion p2 
          ON p.PerfilId = p2.PerfilId
          WHERE LTRIM(p.PerfilId) = :perfilid";

$stmt0 = $pdo->prepare($query);
$stmt0->execute([':perfilid' => $perfilid]);
$menuItems = $stmt0->fetchAll(PDO::FETCH_ASSOC);

$error = $menuItems ? "Menú encontrado." : "Usuario no tiene opciones de menú asignadas.";



?>
  <style type="text/css">

    .nav-link.active {
      font-weight: bold;
      color: #007bff;
      /*background-color: #e9ecef;*/
    }
    .dropdown-menu { 
      font-size: 0.7rem;
      position: absolute !important; /* Forzamos el menú fuera del flujo normal */
      will-change: transform;
      top: 100% !important; /* Asegura que se posicione debajo del botón */
      left: 0 !important;
      z-index: 1050;
    }


.card{
  overflow: visible !important;
}
    .dropdown-menu {
        position: absolute !important; /* Forzamos el menú fuera del flujo normal */
        will-change: transform;
        top: 100% !important; /* Asegura que se posicione debajo del botón */
        left: 0 !important;
        z-index: 1050;
    }
    .dropdown-menu a {
        color: #000 !important;
    }
    .dropdown-menu a:hover {
        background-color: #f8f9fa !important;
    }
    .dropdown-menu a:focus {
        background-color: #f8f9fa !important;
    }
    .dropdown-menu a:active {
        background-color: #f8f9fa !important;
    }
    .dropdown-menu a:visited {
        background-color: #f8f9fa !important;
    }
    .dropdown-menu a:link {
        background-color: #f8f9fa !important;
}
    
  </style>

 
      <nav class="navbar navbar-inverse bg-inverse navbar-toggleable-md sticky-top" id="menu-nav">
        <div class="collapse navbar-collapse" id="navbarToggler001">
          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Menu
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <?php foreach ($menuItems as $item) { 
                $url = $item['PerfilOpcionURL'];
                $fileinfo = pathinfo($url);
                $filename = $fileinfo['filename'];

              ?>
                  <a class="dropdown-item" href="<?php echo $filename; ?>.php"><?php echo $item['PerfilOpcionDescripcion']; ?></a>
              <?php } ?>  
            </div>
              <li class="nav-item">
                
              </li>
          </div>

          <ul class="navbar-nav mr-auto text-left">
            <li class="nav-item">
              <a class="nav-item nav-link " href="#" id="">&nbsp;&nbsp;</a>
            </li>
          </ul>
          
          <ul class="navbar-nav mr-auto text-left">
            <li class="nav-item">
              <a class="nav-item nav-link " href="#" id="Admin">&nbsp;&nbsp;</a>
            </li>
          </ul>  
        
          <div class="nav-item my-2 my-lg-0">
            <a class="text-white" href="edit_profile.php" id="Bienvenido" title="editar perfil"><i class="fa fa-user"></i> Usuario: <?= $_SESSION['user_name'];?></a>
            <?=$seleccion?> 
            
            <a href="logout.php" class="btn btn-danger">Cerrar sesión</a> 
          </div>
        </div>
      </nav>
    <script>
$(document).ready(function () {
    $('#dropdownMenuButton').on('show.bs.dropdown', function () {
        const menu = $(this).next('.dropdown-menu');
        menu.css({
            position: 'absolute',
            top: $(this).outerHeight() + 'px',
            left: '0',
            width: 'auto',
        });
    });
});
    </script>

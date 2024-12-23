<?php
// Consulta para obtener las opciones de menú según el perfil
$query = "SELECT p.PerfilDescripcion, p2.OpcionHabilitadaId, p2.PerfilOpcionDescripcion, p2.PerfilOpcionURL 
          FROM perfil p 
          INNER JOIN perfilopcion p2 
          ON p.PerfilId = p2.PerfilId
          WHERE LTRIM(p.PerfilId) = :perfilid";

$stmt0 = $pdo->prepare($query);
$stmt0->execute([':perfilid' => $perfilid]);
$menuItems = $stmt0->fetchAll(PDO::FETCH_ASSOC);

$error = $menuItems ? "Menú encontrado." : "Usuario no tiene opciones de menú asignadas.";

//var_dump($menuItems);
?>
<nav class="navbar navbar-inverse bg-inverse navbar-toggleable-md sticky-top" id="menu-nav">
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Menu
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <?php foreach ($menuItems as $item) { ?>
                <a class="dropdown-item" href="<?php echo $item['PerfilOpcionURL']; ?>"><?php echo $item['PerfilOpcionDescripcion']; ?></a>
            <?php } ?>          

        </div>
    </div>  
</nav>
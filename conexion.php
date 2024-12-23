<?php
$DB_HOST = '157.92.148.95';
$DB_DATABASE = 'ffyb_puestos_esteban';
$DB_USERNAME = 'sa';
$DB_PASSWORD = 'new50off1060';      

$DNS="sqlsrv:Server=tcp:{$DB_HOST},1433;Database={$DB_DATABASE}";

try {
    $pdo = new PDO($DNS, $DB_USERNAME, $DB_PASSWORD);
    // Establece el modo de error PDO a excepción
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conexión establecida correctamente<br />";
   /*
    $stmt = $pdo->query("select * from usuario");
    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        //print_r($row);
        var_dump($row);
    }   
    */


} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

?>
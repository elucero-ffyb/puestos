<?php
// Configuración de conexión a la base de datos
$host = "localhost";
$dbname = "puestos";
$user = "postgres";
$password = "caseros@1853";

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para obtener las contraseñas sin encriptar
    $query = "SELECT \"UsuarioId\", \"UsuarioPassword\" FROM public.usuario WHERE \"UsuarioPassword\" IS NOT NULL";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Procesar cada usuario
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $usuarioId = $row['UsuarioId'];
        $passwordPlano = $row['UsuarioPassword'];

        // Encriptar la contraseña
        $passwordHash = password_hash($passwordPlano, PASSWORD_DEFAULT);
        //$passwordHash = password_hash($passwordPlano, PASSWORD_BCRYPT);

        // Actualizar la contraseña en la base de datos
        $updateQuery = "UPDATE public.usuario SET \"UsuarioPassword\" = :passwordHash WHERE \"UsuarioId\" = :usuarioId";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute([
            ':passwordHash' => $passwordHash,
            ':usuarioId' => $usuarioId
        ]);

        echo "Contraseña encriptada para el usuario: $usuarioId\n";
    }

    echo "Todas las contraseñas han sido encriptadas correctamente.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

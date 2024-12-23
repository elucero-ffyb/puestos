<?php

require('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del POST
    $estructuraId = $_POST['estructuraId'];
    $plantel = $_POST['plantel'];

    // Verificar si ya existe un registro en la tabla "plantel" con ese EstructuraId
    $sqlCheck = "SELECT COUNT(*) AS total FROM plantel WHERE EstructuraId = :estructuraId";
    $stmtCheck = $pdo->prepare($sqlCheck);

    try {
        $stmtCheck->execute([':estructuraId' => $estructuraId]);
        $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($result['total'] > 0) {
            // Si existe, hacer un UPDATE
            $sqlUpdate = "UPDATE plantel SET PlantelDsc = :plantel WHERE EstructuraId = :estructuraId";
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->execute([
                ':plantel' => $plantel,
                ':estructuraId' => $estructuraId
            ]);
            echo json_encode(['success' => true, 'action' => 'update', 'message' => 'Registro actualizado correctamente.']);
        } else {
            // Si no existe, hacer un INSERT
            $sqlInsert = "INSERT INTO plantel (EstructuraId, PlantelDsc) VALUES (:estructuraId, :plantel)";
            $stmtInsert = $pdo->prepare($sqlInsert);
            $stmtInsert->execute([
                ':estructuraId' => $estructuraId,
                ':plantel' => $plantel
            ]);
            echo json_encode(['success' => true, 'action' => 'insert', 'message' => 'Registro insertado correctamente.']);
        }
    } catch (Exception $e) {
        // En caso de error, devolver el mensaje
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>
<?php
require 'conexion.php';

try {
    // Asegúrate de que `$pdo` esté inicializado
    if (!$pdo) {
        throw new Exception("La conexión a la base de datos no está inicializada.");
    }

    //var_dump($estado);

    // Construir la cláusula WHERE dinámicamente
    $whereClauses = [];
    /*
    if (!empty($estado)) {
        $whereClauses[] = "r.ResolucionEstado = :estado";
    }*/

    if (isset($estadox)) { // Acepta 0 como un valor válido
       //$whereClauses[] = "ResolucionEstado = :estado";
       if ($estadox == 0) {
          $whereClauses[] = "CAST(r.ResolucionEstado AS INT) < 1";
       }elseif ($estadox >0) {
           $whereClauses[] = "CAST(r.ResolucionEstado AS INT) = :estado";
         }
    }
    
    if (!empty($descripcion)) {
        $whereClauses[] = "r.ResolucionDescripcion LIKE :descripcion";
    }
    if (!empty($tipoRes)) {
        $whereClauses[] = "R.TipoResolucionId = :tipores";
    }

    // Combinar las cláusulas WHERE
    $whereSQL = !empty($whereClauses) ? 'WHERE ' . implode(' AND ', $whereClauses) : '';
    //$whereSQL = !empty($whereClauses) ? 'WHERE ' . implode(' AND ', $whereClauses) : '';

    //var_dump($whereSQL);
    
    // Parámetros de paginación
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página actual
    $pageSize = 100; // Número de registros por página
    $offset = ($page - 1) * $pageSize + 1; // Primera fila de la página actual
    $limit = $page * $pageSize; // Última fila de la página actual

    // Construir la consulta SQL final con ROW_NUMBER()
    $query = "
    WITH CTE_Resoluciones AS (
        SELECT 
            ROW_NUMBER() OVER (ORDER BY ResolucionId) AS RowNum,
            ResolucionId,
            ResolucionAnio,
            r.OrigenResolucionId,
            ResolucionNumero,
            CONVERT(VARCHAR, r.ResolucionFecha, 103) AS ResolucionFecha,
            ResolucionDescripcion,
            ResolucionExpediente,
            CONVERT(VARCHAR, r.ResolucionExpedienteFecha, 103) AS ResolucionExpedienteFecha,
            T.TipoResolucionDsc,
            CASE 
                WHEN ResolucionEstado=0 THEN 'PENDIENTE' 
                WHEN ResolucionEstado=1 THEN 'CONFIRMADO' 
                WHEN ResolucionEstado=2 THEN 'TEST' 
            END AS ESTADOS
        FROM RESOLUCION r
        LEFT JOIN ORIGENRESOLUCION o ON r.OrigenResolucionId = o.OrigenResolucionId
        LEFT JOIN TIPORESOLUCION t ON R.TipoResolucionId = T.TipoResolucionId
        $whereSQL
    )
    SELECT *
    FROM CTE_Resoluciones
    WHERE RowNum BETWEEN :offset AND :limit
    ORDER BY RowNum;
    ";

    //echo "<pre>SQL Query: $query</pre>";

    // Preparar la consulta
    $stmt_resu = $pdo->prepare($query);

    // Vincular los parámetros
    /*
    if (!empty($estadox)) {
        //$stmt_resu->bindValue(':estado', $estado);
        echo "<pre>Estado: $estadox</pre>"; // Mostrar el valor para depurar
        $stmt_resu->bindValue(':estado', $estadox, PDO::PARAM_INT);
    }*/

    if ($estadox == 0) {
        
    }elseif ($estadox >0) {
        $stmt_resu->bindValue(':estado', $estadox, PDO::PARAM_INT);
    }

    if (!empty($descripcion)) {
        $stmt_resu->bindValue(':descripcion', "%$descripcion%");
    }
    if (!empty($tipoRes)) {
        $stmt_resu->bindValue(':tipores', $tipoRes);
    }

    // Vincular los parámetros de paginación
    $stmt_resu->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt_resu->bindValue(':limit', $limit, PDO::PARAM_INT);

    // Ejecutar la consulta
    $stmt_resu->execute();
    $resu = $stmt_resu->fetchAll(PDO::FETCH_ASSOC);

    // Calcular el número total de registros
    $totalQuery = "
        SELECT COUNT(*) AS Total
        FROM RESOLUCION r
        LEFT JOIN ORIGENRESOLUCION o ON r.OrigenResolucionId = o.OrigenResolucionId
        LEFT JOIN TIPORESOLUCION t ON R.TipoResolucionId = T.TipoResolucionId
        $whereSQL;
    ";

    $totalStmt = $pdo->prepare($totalQuery);

    // Vincular los mismos parámetros de filtrado para contar los registros
    if (!empty($estado)) {
        $totalStmt->bindValue(':estado', $estado);
    }
    if (!empty($descripcion)) {
        $totalStmt->bindValue(':descripcion', "%$descripcion%");
    }
    if (!empty($tipoRes)) {
        $totalStmt->bindValue(':tipores', $tipoRes);
    }

    $totalStmt->execute();
    $totalRecords = $totalStmt->fetch(PDO::FETCH_ASSOC)['Total'];

    // Calcular el número total de páginas
    $totalPages = ceil($totalRecords / $pageSize);
    

} catch (Exception $e) {
    // Mostrar el mensaje de error
    echo "Error: " . $e->getMessage();
}
?>

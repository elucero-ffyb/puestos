<?php

// Construir la cláusula WHERE dinámicamente
$whereClauses = [];

if (!empty($estado)) {
    $whereClauses[] = "r.ResolucionEstado = :estado";
}

if (!empty($descripcion)) {
    $whereClauses[] = "r.ResolucionDescripcion LIKE :descripcion";
}

if (!empty($tipoRes)) {
    $whereClauses[] = "R.TipoResolucionId = :tipores";
}




// Combinar las cláusulas WHERE
$whereSQL = '';

if (!empty($whereClauses)) {
    $whereSQL = 'WHERE ' . implode(' AND ', $whereClauses);
    $top=' ';
}else{
    $top='top 10 ';
}

// Construir la consulta SQL final
$query = " SELECT $top ResolucionId,ResolucionAnio,r.OrigenResolucionId,ResolucionNumero,
    CONVERT(VARCHAR, r.ResolucionFecha, 103) AS ResolucionFecha,
    ResolucionDescripcion,ResolucionExpediente,
    CONVERT(VARCHAR, r.ResolucionExpedienteFecha, 103) AS ResolucionExpedienteFecha,
    T.TipoResolucionDsc,
    CASE WHEN RESOLUCIONESTADO=0 THEN 'PENDIENTE' WHEN RESOLUCIONESTADO=1 THEN 'CONFIRMADO' WHEN ResolucionEstado=3 THEN 'TEST' END AS ESTADO
    FROM RESOLUCION r
    left join ORIGENRESOLUCION o ON r.OrigenResolucionId= o.OrigenResolucionId
    left join TIPORESOLUCION t ON R.TipoResolucionId = T.TipoResolucionId
    $whereSQL
    ORDER BY 1;";

//var_dump($estado);
//var_dump($descripcion);
//var_dump($tipoRes);

//print_r($query);
//print_r("*****".$whereSQL."****");
// Preparar la consulta
$stmt_resu = $pdo->prepare($query);

// Vincular los parámetros

if (!empty($estado)) {
    $stmt_resu->bindValue(':estado', $estado);
}
if (!empty($descripcion)) {
    $stmt_resu->bindValue(':descripcion', "%$descripcion%");
}

if (!empty($tipoRes)) {
    $stmt_resu->bindValue(':tipores', $tipoRes);
}


// Ejecutar la consulta
$stmt_resu->execute();
$resu = $stmt_resu->fetchAll(PDO::FETCH_ASSOC);
//var_dump($resu);
?>
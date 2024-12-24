<?php
/*
// Capturar los valores enviados desde el formulario
$catedra = isset($_POST['select_cate']) ? $_POST['select_cate'] : '';
$cargox = isset($_POST['select_cargo']) ? $_POST['select_cargo'] : '';
$denominacion = isset($_POST['select_deno']) ? $_POST['select_deno'] : '';
$legajo = isset($_POST['legajo']) ? $_POST['legajo'] : '';
$situacion = isset($_POST['select_situ']) ? $_POST['select_situ'] : '';
$estado = isset($_POST['select_esta']) ? $_POST['select_esta'] : '';
$vigencia = isset($_POST['Vigencia']) ? $_POST['Vigencia'] : '';
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$caracter = isset($_POST['caracter']) ? $_POST['caracter'] : '';
$origen = isset($_POST['origen']) ? $_POST['origen'] : '';
$plantel = isset($_POST['plantel']) ? $_POST['plantel'] : '';
*/
// Construir la cláusula WHERE dinámicamente
$whereClauses = [];

if (!empty($catedra)) {
    $whereClauses[] = "e.EstructuraCatedraId = :catedra";
}
if (!empty($cargox)) {
    $whereClauses[] = "e.CargoId = :cargox";
}
if (!empty($denominacion)) {
    $whereClauses[] = "c.DenId = :denominacion";
}
if (!empty($legajo)) {
    $whereClauses[] = "e.LegajoId = :legajo";
}
if (!empty($situacion)) {
    $whereClauses[] = "e.SituacionId = :situacion";
}
if (!empty($estado)) {
    $whereClauses[] = "e.EstadoId = :estado";
}
if (!empty($vigencia)) {
    if ($vigencia == "1") { // No aplica
        $whereClauses[] = "GETDATE() < e.EstructuraVigenciaDesde";
    } elseif ($vigencia == "2") { // En espera
        $whereClauses[] = "GETDATE() BETWEEN e.EstructuraVigenciaDesde AND e.EstructuraVigenciaHasta";
    } elseif ($vigencia == "3") { // Activa
        $whereClauses[] = "GETDATE() > e.EstructuraVigenciaHasta";
    } elseif ($vigencia == "4") { // Vencida
        $whereClauses[] = "GETDATE() > e.EstructuraVigenciaHasta";
    }
}
if (!empty($nombre)) {
    $whereClauses[] = "l.LegajoNombre LIKE :nombre";
}
if (!empty($caracter)) {
    $whereClauses[] = "e.CaracterId = :caracter";
}
if (!empty($origen)) {
    $whereClauses[] = "r.OrigenResolucionId = :origen";
}
if (!empty($plantel)) {
    $whereClauses[] = "p.PlantelDsc LIKE :plantel";
}

// Combinar las cláusulas WHERE
$whereSQL = '';
if (!empty($whereClauses)) {
    $whereSQL = 'WHERE ' . implode(' AND ', $whereClauses);
}

// Construir la consulta SQL final
$query = "
    SELECT top 10	
        c2.CatedraDescripcion,
        e.EstructuraTest, 
        e.CargoId,
        c.CargoDsc,
        d2.DenDsc, 
        d.DedicacionDsc, 
        e.EstructuraId,
        e.EstructuraDsc, 
        e.LegajoId, 
        l.LegajoNombre, 
        l.LegajoCUIT, 
        s.SituacionDsc, 
        e2.EstadoDsc, 
        c3.CaracterDsc,
        o.OrigenResolucionDsc, 
        r.ResolucionNumero, 
        CONVERT(VARCHAR, r.ResolucionFecha, 103) AS ResolucionFecha, 
        CONVERT(VARCHAR, e.EstructuraVigenciaDesde, 103) AS EstructuraVigenciaDesde,
        CONVERT(VARCHAR, e.EstructuraVigenciaHasta, 103) AS EstructuraVigenciaHasta,
        CASE 
            WHEN GETDATE() BETWEEN e.EstructuraVigenciaDesde AND e.EstructuraVigenciaHasta THEN 'Vigente'
            ELSE 'No vigente'
        END AS Vigencia,
        p.PlantelDsc 
    FROM 
        estructura e
        JOIN cargo c ON e.CargoId = c.CargoId
        JOIN dedicacion d ON c.DedicacionId = d.DedicacionId
        JOIN denominacion d2 ON c.DenId = d2.DenId
        JOIN catedra c2 ON e.EstructuraCatedraId = c2.CatedraId
        JOIN legajo l ON e.LegajoId = l.LegajoID
        left JOIN situacion s ON e.SituacionId = s.SituacionId
        JOIN estado e2 ON e.EstadoId = e2.EstadoId
        JOIN caracter c3 ON e.CaracterId = c3.CaracterId
        JOIN resolucion r ON e.EstructuraResolucionId = r.ResolucionId
        JOIN origenresolucion o ON LTRIM(r.OrigenResolucionId) = LTRIM(o.OrigenResolucionId)
        LEFT JOIN plantel p ON e.EstructuraId = p.EstructuraId
    $whereSQL
    ORDER BY c2.CatedraDescripcion;
";
//print_r("*****".$whereSQL."****");
// Preparar la consulta
$stmt_resu = $pdo->prepare($query);

// Vincular los parámetros
if (!empty($catedra)) {
    $stmt_resu->bindValue(':catedra', $catedra);
}
if (!empty($cargox)) {
    $stmt_resu->bindValue(':cargox', $cargox);
}
if (!empty($denominacion)) {
    $stmt_resu->bindValue(':denominacion', $denominacion);
}
if (!empty($legajo)) {
    $stmt_resu->bindValue(':legajo', $legajo);
}
if (!empty($situacion)) {
    $stmt_resu->bindValue(':situacion', $situacion);
}
if (!empty($estado)) {
    $stmt_resu->bindValue(':estado', $estado);
}
if (!empty($nombre)) {
    $stmt_resu->bindValue(':nombre', "%$nombre%");
}
if (!empty($caracter)) {
    $stmt_resu->bindValue(':caracter', $caracter);
}
if (!empty($origen)) {
    $stmt_resu->bindValue(':origen', $origen);
}
if (!empty($plantel)) {
    $stmt_resu->bindValue(':plantel', "%$plantel%");
}

// Ejecutar la consulta
$stmt_resu->execute();
$resu = $stmt_resu->fetchAll(PDO::FETCH_ASSOC);
?>
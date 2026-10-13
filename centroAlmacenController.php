<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../Config/conexion.php';

try {       // Extraer de la base de datos.
    $stmtEmpesa = $conexion->query("SELECT * FROM gc_empresas");
    $empresa = $stmtEmpesa->fetchAll(PDO::FETCH_ASSOC);

    $stmtEstadoP = $conexion->query("SELECT * FROM estado_producto");
    $estado_producto = $stmtEstadoP->fetchAll(PDO::FETCH_ASSOC);

    $stmtTipoP = $conexion->query("SELECT * FROM tipo_producto");
    $tipo_producto = $stmtTipoP->fetchAll(PDO::FETCH_ASSOC);

    $stmtAreas = $conexion->query("SELECT * FROM areas");
    $areas_trabajador = $stmtAreas->fetchAll(PDO::FETCH_ASSOC);

    $stmtSede = $conexion->query("SELECT * FROM sede");
    $sede_trabajador = $stmtSede->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $empresa = [];
    $estado_producto = [];
    $tipo_producto = [];
    $areas_trabajador = [];
    $sede_trabajador = [];
}

try {
    // Contar cuentas activas 
    $stmtHardware = $conexion->query("SELECT COUNT(*) FROM producto WHERE tipo_producto_fk = '1' AND id_estado_fk = '2'");
    $totalHardware = $stmtHardware->fetchColumn();

    $stmtAcces = $conexion->query("SELECT COUNT(*) FROM producto WHERE tipo_producto_fk = '2'");
    $totalAcces = $stmtAcces->fetchColumn();

    $stmtRedes = $conexion->query("SELECT COUNT(*) FROM producto WHERE tipo_producto_fk = '3'");
    $totalRedes = $stmtRedes->fetchColumn();

    $stmtCPU = $conexion->query("SELECT COUNT(*) FROM producto WHERE id_estado_fk = '1' AND tipo_producto_fk = '4'");  //cambiar lo de nombre
    $totalCPU = $stmtCPU->fetchColumn();

    $stmtLaptops = $conexion->query("SELECT COUNT(*) FROM producto WHERE id_estado_fk = '1' AND tipo_producto_fk = '5'");  //cambiar lo de nombre
    $totalLaptops = $stmtLaptops->fetchColumn();

    $stmtMonitor = $conexion->query("SELECT COUNT(*) FROM producto WHERE id_estado_fk = '1' AND tipo_producto_fk = '6'");
    $totalMonitor = $stmtMonitor->fetchColumn();
    
    $stmtImpresora = $conexion->query("SELECT COUNT(*) FROM producto WHERE id_estado_fk = '1' AND tipo_producto_fk = '7'");
    $totalImpresora = $stmtImpresora->fetchColumn();

    $stmtMouse = $conexion->query("SELECT COUNT(*) FROM producto WHERE id_estado_fk = '1' AND tipo_producto_fk = '8'");
    $totalMouse = $stmtMouse->fetchColumn();


} catch (Exception $e) {
    $totalHardware = 0;
    $totalAcces = 0;
    $totalRedes = 0;
    $totalCPU = 0;
    $totalLaptops = 0;
    $totalMonitor = 0;
    $totalImpresora = 0;
    $totalMouse = 0;

}


?>
conexión 
<?php
$host = "localhost";
$dbname = "xternaco_sistemas";
$usuario_db = "root";
$password = "";

try {
    // Si tu XAMPP usa el puerto 3307, puedes agregar ';port=3307' después del $dbname
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $usuario_db, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("<div style='color:red; font-family:sans-serif; padding:20px;'><strong>Error de conexión a la Base de Datos:</strong> " . htmlspecialchars($e->getMessage()) . "</div>");
}
?>




centro almacén controller:
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../Config/conexion.php';

try {
    // Listas para desplegables de modales
    $stmtEmpresa = $conexion->query("SELECT * FROM gc_empresas ORDER BY razon_social_emp ASC");
    $empresa = $stmtEmpresa->fetchAll();

    $stmtEstadoP = $conexion->query("SELECT * FROM estado_producto ORDER BY id ASC");
    $estado_producto = $stmtEstadoP->fetchAll();

    $stmtTipoP = $conexion->query("SELECT * FROM tipo_producto ORDER BY id ASC");
    $tipo_producto = $stmtTipoP->fetchAll();

    $stmtAreas = $conexion->query("SELECT * FROM areas ORDER BY nombre_area ASC");
    $areas_trabajador = $stmtAreas->fetchAll();

    $stmtSede = $conexion->query("SELECT * FROM sede ORDER BY nombre ASC");
    $sede_trabajador = $stmtSede->fetchAll();

} catch (PDOException $e) {
    $empresa = [];
    $estado_producto = [];
    $tipo_producto = [];
    $areas_trabajador = [];
    $sede_trabajador = [];
}

try {
    // Conteos para tarjetas e indicadores
    $stmtHardware = $conexion->query("SELECT COUNT(*) FROM producto WHERE tipo_producto_fk = '1' AND id_estado_fk = '2'");
    $totalHardware = $stmtHardware->fetchColumn();

    $stmtAcces = $conexion->query("SELECT COUNT(*) FROM producto WHERE tipo_producto_fk = '2'");
    $totalAcces = $stmtAcces->fetchColumn();

    $stmtRedes = $conexion->query("SELECT COUNT(*) FROM producto WHERE tipo_producto_fk = '3'");
    $totalRedes = $stmtRedes->fetchColumn();

    $stmtCPU = $conexion->query("SELECT COUNT(*) FROM producto WHERE id_estado_fk = '1' AND tipo_producto_fk = '4'");
    $totalCPU = $stmtCPU->fetchColumn();

    $stmtLaptops = $conexion->query("SELECT COUNT(*) FROM producto WHERE id_estado_fk = '1' AND tipo_producto_fk = '5'");
    $totalLaptops = $stmtLaptops->fetchColumn();

    $stmtMonitor = $conexion->query("SELECT COUNT(*) FROM producto WHERE id_estado_fk = '1' AND tipo_producto_fk = '6'");
    $totalMonitor = $stmtMonitor->fetchColumn();
    
    $stmtImpresora = $conexion->query("SELECT COUNT(*) FROM producto WHERE id_estado_fk = '1' AND tipo_producto_fk = '7'");
    $totalImpresora = $stmtImpresora->fetchColumn();

    $stmtMouse = $conexion->query("SELECT COUNT(*) FROM producto WHERE id_estado_fk = '1' AND tipo_producto_fk = '8'");
    $totalMouse = $stmtMouse->fetchColumn();

} catch (PDOException $e) {
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





centro almacén 
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../Controllers/centroAlmacenController.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Almacén - Grupo T-Soluciona</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container-fluid">
        <div class="row min-vh-100">
            <!-- Menú Lateral -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-white border-end p-4 sidebar">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-success bg-opacity-10 p-2 rounded-3 text-success me-2">
                        <i class="bi bi-box-seam fs-5"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Grupo T-Soluciona</h6>
                        <small class="text-muted">Almacén de Sistemas</small>
                    </div>
                </div>

                <ul class="nav flex-column gap-1">
                    <li class="nav-item"><a href="centroAlmacen.php" class="nav-link text-success fw-semibold bg-success bg-opacity-10 px-3 py-2 rounded-3"><i class="bi bi-grid me-2"></i> Centro</a></li>
                    <li class="nav-item"><a href="inventarioAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-boxes me-2"></i> Inventario</a></li>
                    <li class="nav-item"><a href="movimientosAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-arrow-left-right me-2"></i> Movimientos</a></li>
                    <li class="nav-item"><a href="personalAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-buildings me-2"></i> Empresas y Personal</a></li><br>
                    <li class="nav-item"><a href="../../index.php" class="btn btn-success px-5 rounded-pill shadow-sm btn-sm"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a></li>
                </ul>
            </nav>

            <!-- Contenido Principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5 py-4">
                <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded-4 shadow-sm mb-4 border border-light-subtle">
                    <div>
                        <h1 class="h4 fw-bold text-dark mb-1">Panel de Control / Resumen General</h1>
                        <p class="text-muted small mb-0">Vista general del almacén de sistemas.</p>
                    </div>
                    <span class="text-muted small"><i class="bi bi-person-circle me-1"></i><?php echo htmlspecialchars($_SESSION['user'] ?? 'Administrador'); ?></span>
                </div>

                <!-- Tarjetas Indicadoras -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-3 border-start border-success border-4 h-100">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted text-uppercase small fw-bold mb-1">Hardware Principal</h6>
                                    <h3 class="fw-bold text-dark mb-0"><?php echo $totalHardware; ?></h3>
                                </div>
                                <div class="fs-1 text-success opacity-50"><i class="bi bi-cpu"></i></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-3 border-start border-primary border-4 h-100">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted text-uppercase small fw-bold mb-1">Accesorios</h6>
                                    <h3 class="fw-bold text-dark mb-0"><?php echo $totalAcces; ?></h3>
                                </div>
                                <div class="fs-1 text-primary opacity-50"><i class="bi bi-keyboard"></i></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-3 border-start border-warning border-4 h-100">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted text-uppercase small fw-bold mb-1">Redes</h6>
                                    <h3 class="fw-bold text-dark mb-0"><?php echo $totalRedes; ?></h3>
                                </div>
                                <div class="fs-1 text-warning opacity-50"><i class="bi bi-diagram-3"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Disponibilidad y Accesos Rápidos -->
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                            <h5 class="fw-bold text-dark mb-3">Disponibilidad de Backups / Repuestos</h5>
                            <p class="text-muted small mb-3">Equipos listos para entrega inmediata ante incidencias.</p>
                            
                            <div class="list-group list-group-flush gap-2">
                                <div class="list-group-item border rounded-3 p-3 d-flex justify-content-between align-items-center bg-light">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-laptop fs-5 text-dark me-3"></i>
                                        <span class="fw-semibold text-dark">Laptops de Respaldo</span>
                                    </div>
                                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill"><?php echo $totalLaptops; ?> disponibles</span>
                                </div>

                                <div class="list-group-item border rounded-3 p-3 d-flex justify-content-between align-items-center bg-light">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-printer fs-5 text-dark me-3"></i>
                                        <span class="fw-semibold text-dark">Impresora de Repuesto</span>
                                    </div>
                                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill"><?php echo $totalImpresora; ?> disponibles</span>
                                </div>

                                <div class="list-group-item border rounded-3 p-3 d-flex justify-content-between align-items-center bg-light">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-display fs-5 text-dark me-3"></i>
                                        <span class="fw-semibold text-dark">Monitor de Repuesto</span>
                                    </div>
                                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill"><?php echo $totalMonitor; ?> disponibles</span>
                                </div>

                                <div class="list-group-item border rounded-3 p-3 d-flex justify-content-between align-items-center bg-light">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-mouse fs-5 text-dark me-3"></i>
                                        <span class="fw-semibold text-dark">Mouses de Repuesto</span>
                                    </div>
                                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill"><?php echo $totalMouse; ?> disponibles</span>
                                </div>

                                <div class="list-group-item border rounded-3 p-3 d-flex justify-content-between align-items-center bg-light">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-cpu fs-5 text-dark me-3"></i>
                                        <span class="fw-semibold text-dark">CPU de Repuesto</span>
                                    </div>
                                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill"><?php echo $totalCPU; ?> disponibles</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                            <h5 class="fw-bold text-dark mb-3">Acciones Rápidas</h5>
                            <p class="text-muted small mb-3">Accesos directos para la gestión del almacén.</p>
                            
                            <div class="d-grid gap-3">
                                <button type="button" class="btn btn-outline-secondary py-3 rounded-3 text-start px-4 d-flex justify-content-between align-items-center" data-bs-toggle="modal" data-bs-target="#modalNuevaSalida">
                                    <span><i class="bi bi-arrow-up-right-square me-2"></i>Registrar Nueva Salida</span>
                                    <i class="bi bi-chevron-right"></i>
                                </button>

                                <button type="button" class="btn btn-outline-secondary py-3 rounded-3 text-start px-4 d-flex justify-content-between align-items-center" data-bs-toggle="modal" data-bs-target="#modalNuevoProducto">
                                    <span><i class="bi bi-box-arrow-in-down me-2"></i>Agregar Nuevo Producto</span>
                                    <i class="bi bi-chevron-right"></i>
                                </button>

                                <button type="button" class="btn btn-outline-secondary py-3 rounded-3 text-start px-4 d-flex justify-content-between align-items-center" data-bs-toggle="modal" data-bs-target="#exampleModalToggle">
                                    <span><i class="bi bi-person-plus me-2"></i>Registrar Trabajador / Empresa</span>
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Modal Nueva Salida -->        
        <div class="modal fade" id="modalNuevaSalida" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title"><i class="bi bi-arrow-up-right-square me-2"></i> Nueva Salida</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="../Controllers/guardarNuevaSalida.php" method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="col-form-label fw-bold">ID del Producto:</label>
                                <input type="number" class="form-control" name="producto_fk" required>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label fw-bold">Fecha de Salida:</label>
                                <input type="date" class="form-control" name="fecha_salida" required>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label fw-bold">ID del Trabajador Asignado:</label>
                                <input type="number" class="form-control" name="id_trabajador_fk" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-warning text-white">Continuar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Agregar Nuevo Producto --> 
        <div class="modal fade" id="modalNuevoProducto" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h3 class="fw-bold mb-3"><i class="bi bi-plus-lg"></i> Añadir Nuevo Producto</h3>
                            <hr class="mb-4">
                            <form action="../Controllers/guardarNuevoProducto.php" method="POST">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nombre:</label>
                                    <input type="text" class="form-control" name="nombre" placeholder="Ingrese nombre del Producto" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Marca:</label>
                                    <input type="text" class="form-control" name="marca" placeholder="Ingrese la Marca del Producto" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Fecha de Ingreso:</label>
                                    <input type="date" class="form-control" name="fecha_ingreso" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Costo del Producto:</label>
                                    <input type="number" step="0.01" class="form-control" name="costo" placeholder="Ej. 120.50" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Empresa:</label>
                                    <select class="form-select" name="empresa" required>
                                        <option value="">Seleccione una empresa...</option>
                                        <?php foreach ($empresa as $emp): ?>
                                            <option value="<?php echo $emp['id']; ?>"><?php echo htmlspecialchars($emp['razon_social_emp']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Estado:</label>
                                    <select class="form-select" name="estado" required>
                                        <option value="">Seleccione un Estado</option>
                                        <?php foreach ($estado_producto as $est): ?>
                                            <option value="<?php echo $est['id']; ?>"><?php echo htmlspecialchars($est['nombre']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tipo de Producto:</label>
                                    <select class="form-select" name="tipo_producto" required>
                                        <option value="">Seleccione el Tipo del Producto</option>
                                        <?php foreach ($tipo_producto as $tipo): ?>
                                            <option value="<?php echo $tipo['id']; ?>"><?php echo htmlspecialchars($tipo['nombre']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Guardar Producto</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modales Anidados: Trabajador y Empresa -->
        <div class="modal fade" id="exampleModalToggle" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="bi bi-arrow-up-right-square me-2"></i> Registrar Trabajador</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="../Controllers/guardarTrabajador.php" method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="col-form-label">DNI Trabajador:</label>
                                <input type="text" class="form-control" name="DNI" required>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">Nombres:</label>
                                <input type="text" class="form-control" name="nombres" required>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">Área asignada:</label>
                                <select class="form-select" name="id_area_fk" required>
                                    <option value="">Seleccione una Área...</option>
                                    <?php foreach ($areas_trabajador as $areas): ?>
                                        <option value="<?php echo $areas['id_area']; ?>"><?php echo htmlspecialchars($areas['nombre_area']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">Sede Asignada:</label>
                                <select class="form-select" name="id_sede_fk" required>
                                    <option value="">Seleccione una Sede...</option>
                                    <?php foreach ($sede_trabajador as $sede): ?>
                                        <option value="<?php echo $sede['id_sede']; ?>"><?php echo htmlspecialchars($sede['nombre']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Nueva Empresa</button>
                            <div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success text-white">Continuar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title"><i class="bi bi-arrow-up-right-square me-2"></i> Registrar Nueva Empresa</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="../Controllers/guardarEmpresa.php" method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="col-form-label">RUC de la Empresa:</label>
                                <input type="text" class="form-control" name="ruc_emp" required>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">Razón Social de la Empresa:</label>
                                <input type="text" class="form-control" name="razon_social_emp" required>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Nuevo Trabajador</button>
                            <div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-warning text-white">Continuar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>





inventario almacén 
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../Config/conexion.php';

try {
    // Selects para Filtros
    $stmtEmp = $conexion->query("SELECT id, razon_social_emp FROM gc_empresas ORDER BY razon_social_emp ASC");
    $lista_empresas = $stmtEmp->fetchAll();

    $stmtEst = $conexion->query("SELECT id, nombre FROM estado_producto ORDER BY id ASC");
    $lista_estados = $stmtEst->fetchAll();

    // Consulta principal de la tabla Producto uniendo con tablas relacionadas
    $sql = "SELECT p.*, e.razon_social_emp, est.nombre AS estado_nombre, tp.nombre AS tipo_nombre, s.nombre AS sede_nombre 
            FROM producto p 
            LEFT JOIN gc_empresas e ON p.id_empresa_fk = e.id 
            LEFT JOIN estado_producto est ON p.id_estado_fk = est.id 
            LEFT JOIN tipo_producto tp ON p.tipo_producto_fk = tp.id 
            LEFT JOIN sede s ON p.sede_fk = s.id_sede 
            ORDER BY p.id DESC";
    $stmtProd = $conexion->query($sql);
    $productos = $stmtProd->fetchAll();

} catch (PDOException $e) {
    $lista_empresas = [];
    $lista_estados = [];
    $productos = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario - Grupo T-Soluciona</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container-fluid">
        <div class="row min-vh-100">
            <!-- Menú -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-white border-end p-4 sidebar">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-success bg-opacity-10 p-2 rounded-3 text-success me-2">
                        <i class="bi bi-box-seam fs-5"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Grupo T-Soluciona</h6>
                        <small class="text-muted">Almacén de Sistemas</small>
                    </div>
                </div>

                <ul class="nav flex-column gap-1">
                    <li class="nav-item"><a href="centroAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-grid me-2"></i> Centro</a></li>
                    <li class="nav-item"><a href="inventarioAlmacen.php" class="nav-link text-success fw-semibold bg-success bg-opacity-10 px-3 py-2 rounded-3"><i class="bi bi-boxes me-2"></i> Inventario</a></li>
                    <li class="nav-item"><a href="movimientosAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-arrow-left-right me-2"></i> Movimientos</a></li>
                    <li class="nav-item"><a href="personalAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-buildings me-2"></i> Empresas y Personal</a></li> <br>
                    <li class="nav-item"><a href="../../index.php" class="btn btn-success px-5 rounded-pill shadow-sm btn-sm"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a></li>
                </ul>
            </nav>

            <!-- Contenido Principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5 py-4">
                <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded-4 shadow-sm mb-4 border border-light-subtle">
                    <div>
                        <h1 class="h4 fw-bold text-dark mb-1">Inventario General del Almacén</h1>
                        <p class="text-muted small mb-0">Gestión de máquinas, escritorios, mouses, teclados y stock general.</p>
                    </div>
                    <a href="nuevoProducto.php" class="btn btn-success px-4 rounded-pill shadow-sm"><i class="bi bi-plus-lg me-1"></i> Nuevo Ingreso</a>
                </div>

                <!-- Barra de Filtros -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small text-muted fw-semibold">Filtrar por Empresa</label>
                            <select class="form-select rounded-3">
                                <option selected>Todas las Empresas</option>
                                <?php foreach ($lista_empresas as $empresa): ?>
                                    <option value="<?php echo htmlspecialchars($empresa['razon_social_emp']); ?>"><?php echo htmlspecialchars($empresa['razon_social_emp']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted fw-semibold">Filtrar por Estado</label>
                            <select class="form-select rounded-3">
                                <option selected>Todos los Estados</option>
                                <?php foreach ($lista_estados as $nombreEstado): ?>
                                    <option value="<?php echo htmlspecialchars($nombreEstado['nombre']); ?>"><?php echo htmlspecialchars($nombreEstado['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted fw-semibold">Búsqueda Rápida</label>
                            <input type="text" id="inputBusqueda" class="form-control rounded-3" placeholder="Buscar por SKU, nombre, marca..." autocomplete="off">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Inventario Dinámica -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="text-muted small text-uppercase bg-light">
                                <tr>
                                    <th class="py-3">ID</th>
                                    <th class="py-3">Nombre</th>
                                    <th class="py-3">Marca</th>
                                    <th class="py-3">Fecha de Ingreso</th>
                                    <th class="py-3">Costo</th>
                                    <th class="py-3 rounded-start">SKU</th>
                                    <th class="py-3">Sede / Empresa</th>
                                    <th class="py-3">Estado</th>
                                    <th class="py-3">Tipo de Producto</th>
                                    <th class="py-3 text-center rounded-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($productos)): ?>
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-5">
                                            <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                            No hay productos registrados en el inventario.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($productos as $prod): ?>
                                        <tr>
                                            <td><?php echo $prod['id']; ?></td>
                                            <td><strong><?php echo htmlspecialchars($prod['nombre']); ?></strong></td>
                                            <td><?php echo htmlspecialchars($prod['marca']); ?></td>
                                            <td><?php echo htmlspecialchars($prod['fecha_ingreso'] ?? 'N/A'); ?></td>
                                            <td>S/ <?php echo number_format($prod['costo'] ?? 0, 2); ?></td>
                                            <td><code><?php echo htmlspecialchars($prod['codigo'] ?? 'SKU-' . $prod['id']); ?></code></td>
                                            <td><?php echo htmlspecialchars($prod['razon_social_emp'] ?? $prod['sede_nombre'] ?? 'Sin asignar'); ?></td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success px-2 py-1">
                                                    <?php echo htmlspecialchars($prod['estado_nombre'] ?? 'Activo'); ?>
                                                </span>
                                            </td>
                                            <td><?php echo htmlspecialchars($prod['tipo_nombre'] ?? 'General'); ?></td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-sm btn-outline-primary" title="Editar"><i class="bi bi-pencil"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




movimientos almacen
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../Config/conexion.php';

try {
    // Consulta de la bitácora uniendo la orden de salida con producto y trabajador
    $sql = "SELECT o.*, p.nombre AS producto_nombre, p.codigo, t.nombres AS trabajador_nombre, t.DNI 
            FROM orden_salida o 
            LEFT JOIN producto p ON o.producto_fk = p.id 
            LEFT JOIN trabajador t ON o.id_trabajador_fk = t.id 
            ORDER BY o.id DESC";
    $stmtMov = $conexion->query($sql);
    $movimientos = $stmtMov->fetchAll();

} catch (PDOException $e) {
    $movimientos = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos - Grupo T-Soluciona</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container-fluid">
        <div class="row min-vh-100">
            <!-- Menú -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-white border-end p-4 sidebar">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-success bg-opacity-10 p-2 rounded-3 text-success me-2">
                        <i class="bi bi-box-seam fs-5"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Grupo T-Soluciona</h6>
                        <small class="text-muted">Almacén de Sistemas</small>
                    </div>
                </div>

                <ul class="nav flex-column gap-1">
                    <li class="nav-item"><a href="centroAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-grid me-2"></i> Centro</a></li>
                    <li class="nav-item"><a href="inventarioAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-boxes me-2"></i> Inventario</a></li>
                    <li class="nav-item"><a href="movimientosAlmacen.php" class="nav-link text-success fw-semibold bg-success bg-opacity-10 px-3 py-2 rounded-3"><i class="bi bi-arrow-left-right me-2"></i> Movimientos</a></li>
                    <li class="nav-item"><a href="personalAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-buildings me-2"></i> Empresas y Personal</a></li> <br>
                    <li class="nav-item"><a href="../../index.php" class="btn btn-success px-5 rounded-pill shadow-sm btn-sm"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a></li>
                </ul>
            </nav>

            <!-- Contenido Principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5 py-4">
                <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded-4 shadow-sm mb-4 border border-light-subtle">
                    <div>
                        <h1 class="h4 fw-bold text-dark mb-1">Movimientos y Registro de Salidas</h1>
                        <p class="text-muted small mb-0">Control de entregas de equipos e historial de operaciones de almacén.</p>
                    </div>
                    <button type="button" class="btn btn-success px-4 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus-lg me-1"></i>Registrar Nueva Salida</button>
                </div>

                <!-- Modal Nueva Salida -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="exampleModalLabel">Nueva Salida</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="../Controllers/guardarNuevaSalida.php" method="POST">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="col-form-label fw-bold">ID del Producto:</label>
                                        <input type="number" class="form-control" name="producto_fk" placeholder="Ingrese ID del producto" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="col-form-label fw-bold">Fecha de Salida:</label>
                                        <input type="date" class="form-control" name="fecha_salida" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="col-form-label fw-bold">ID del Trabajador Asignado:</label>
                                        <input type="number" class="form-control" name="id_trabajador_fk" placeholder="Ingrese ID del trabajador" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success">Guardar Salida</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Movimientos Dinámica -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0">Bitácora de Movimientos</h5>
                        <input type="text" class="form-control w-25 rounded-3 form-control-sm" placeholder="Buscar movimiento...">
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="text-muted small text-uppercase bg-light">
                                <tr>
                                    <th class="py-3 rounded-start">ID Movimiento</th>
                                    <th class="py-3">Tipo</th>
                                    <th class="py-3">Producto</th>
                                    <th class="py-3">Trabajador Responsable</th>
                                    <th class="py-3">Fecha y Hora</th>
                                    <th class="py-3 text-center rounded-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($movimientos)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">
                                            <i class="bi bi-clock-history fs-2 d-block mb-2 opacity-50"></i>
                                            No hay movimientos registrados en el sistema.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($movimientos as $mov): ?>
                                        <tr>
                                            <td><strong>#<?php echo $mov['id']; ?></strong></td>
                                            <td><span class="badge bg-warning-subtle text-warning">Salida</span></td>
                                            <td>
                                                <strong><?php echo htmlspecialchars($mov['producto_nombre'] ?? 'Desconocido'); ?></strong><br>
                                                <small class="text-muted">SKU: <?php echo htmlspecialchars($mov['codigo'] ?? 'N/A'); ?></small>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($mov['trabajador_nombre'] ?? 'Sin asignar'); ?><br>
                                                <small class="text-muted">DNI: <?php echo htmlspecialchars($mov['DNI'] ?? 'N/A'); ?></small>
                                            </td>
                                            <td><?php echo htmlspecialchars($mov['fecha_salida'] ?? $mov['created_at'] ?? 'N/A'); ?></td>
                                            <td class="text-center">
                                                <span class="badge bg-info-subtle text-info px-2 py-1">Registrado</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>






nuevo producto 
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../Config/conexion.php';

try {
    $stmtEmpesa = $conexion->query("SELECT * FROM gc_empresas ORDER BY razon_social_emp ASC");
    $empresa = $stmtEmpesa->fetchAll();

    $stmtEstadoP = $conexion->query("SELECT * FROM estado_producto ORDER BY id ASC");
    $estado_producto = $stmtEstadoP->fetchAll();

    $stmtTipoP = $conexion->query("SELECT * FROM tipo_producto ORDER BY id ASC");
    $tipo_producto = $stmtTipoP->fetchAll();

} catch (PDOException $e) {
    $empresa = [];
    $estado_producto = [];
    $tipo_producto = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto - Grupo T-Soluciona</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
    <br><br>
    <div class="container" style="max-width: 600px;">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-3"><i class="bi bi-plus-lg"></i> Añadir Nuevo Producto</h3>
                <hr class="mb-4">

                <form action="../Controllers/guardarNuevoProducto.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre:</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Ingrese nombre del Producto" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Marca:</label>
                        <input type="text" class="form-control" name="marca" placeholder="Ingrese la Marca del Producto" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Fecha de Ingreso:</label>
                        <input type="date" class="form-control" name="fecha_ingreso" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Costo del Producto:</label>
                        <input type="number" step="0.01" class="form-control" name="costo" placeholder="Ej. 120.50" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Empresa:</label>
                        <select class="form-select" name="empresa" required>
                            <option value="">Seleccione una empresa...</option>
                            <?php foreach ($empresa as $emp): ?>
                                <option value="<?php echo $emp['id']; ?>">
                                    <?php echo htmlspecialchars($emp['razon_social_emp']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Estado:</label>
                        <select class="form-select" name="estado" required>
                            <option value="">Seleccione un Estado</option>
                            <?php foreach ($estado_producto as $est): ?>
                                <option value="<?php echo $est['id']; ?>">
                                    <?php echo htmlspecialchars($est['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tipo de Producto:</label>
                        <select class="form-select" name="tipo_producto" required>
                            <option value="">Seleccione el Tipo del Producto</option>
                            <?php foreach ($tipo_producto as $tipo): ?>
                                <option value="<?php echo $tipo['id']; ?>">
                                    <?php echo htmlspecialchars($tipo['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="inventarioAlmacen.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Guardar Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>






personal almacén 
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../Config/conexion.php';

try {
    // Listas para los modales
    $stmtAreas = $conexion->query("SELECT * FROM areas ORDER BY nombre_area ASC");
    $areas_trabajador = $stmtAreas->fetchAll();

    $stmtSede = $conexion->query("SELECT * FROM sede ORDER BY nombre ASC");
    $sede_trabajador = $stmtSede->fetchAll();

    // Obtener Empresas asociadas
    $stmtEmp = $conexion->query("SELECT * FROM gc_empresas ORDER BY id ASC");
    $lista_empresas = $stmtEmp->fetchAll();

    // Obtener Trabajadores vinculando su empresa, área y sede
    $sqlTrab = "SELECT t.*, e.razon_social_emp, a.nombre_area, s.nombre AS sede_nombre 
                FROM trabajador t 
                LEFT JOIN gc_empresas e ON t.id_empresa_fk = e.id 
                LEFT JOIN areas a ON t.id_area_fk = a.id_area 
                LEFT JOIN sede s ON t.id_sede_fk = s.id_sede 
                ORDER BY t.id DESC";
    $stmtTrab = $conexion->query($sqlTrab);
    $lista_trabajadores = $stmtTrab->fetchAll();

} catch (PDOException $e) {
    $areas_trabajador = [];
    $sede_trabajador = [];
    $lista_empresas = [];
    $lista_trabajadores = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresas y Personal - Grupo T-Soluciona</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container-fluid">
        <div class="row min-vh-100">
            <!-- Menú -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-white border-end p-4 sidebar">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-success bg-opacity-10 p-2 rounded-3 text-success me-2">
                        <i class="bi bi-box-seam fs-5"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Grupo T-Soluciona</h6>
                        <small class="text-muted">Almacén de Sistemas</small>
                    </div>
                </div>

                <ul class="nav flex-column gap-1">
                    <li class="nav-item"><a href="centroAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-grid me-2"></i> Centro</a></li>
                    <li class="nav-item"><a href="inventarioAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-boxes me-2"></i> Inventario</a></li>
                    <li class="nav-item"><a href="movimientosAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-arrow-left-right me-2"></i> Movimientos</a></li>
                    <li class="nav-item"><a href="personalAlmacen.php" class="nav-link text-success fw-semibold bg-success bg-opacity-10 px-3 py-2 rounded-3"><i class="bi bi-buildings me-2"></i> Empresas y Personal</a></li> <br>
                    <li class="nav-item"><a href="../../index.php" class="btn btn-success px-5 rounded-pill shadow-sm btn-sm"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a></li>
                </ul>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5 py-4">
                <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded-4 shadow-sm mb-4 border border-light-subtle">
                    <div>
                        <h1 class="h4 fw-bold text-dark mb-1">Gestión de Empresas Asociadas y Personal</h1>
                        <p class="text-muted small mb-0">Control de las empresas colaboradoras y sus trabajadores registrados.</p>
                    </div>
                    <button type="button" class="btn btn-success px-4 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNuevaEmpresa"><i class="bi bi-plus-lg me-1"></i>Nueva Empresa</button>
                </div>

                <!-- Contenido en dos columnas -->
                <div class="row g-4">
                    <!-- Tarjeta de Empresas -->
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold text-dark mb-0">Empresas Asociadas</h5>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="text-muted small text-uppercase bg-light">
                                        <tr>
                                            <th class="py-2 rounded-start">ID</th>
                                            <th class="py-2">RUC</th>
                                            <th class="py-2 text-center rounded-end">Razón Social</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($lista_empresas)): ?>
                                            <tr>
                                                <td colspan="3" class="text-center text-muted py-5">
                                                    <i class="bi bi-building fs-2 d-block mb-2 opacity-50"></i>
                                                    No hay Empresas registradas.
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($lista_empresas as $emp): ?>
                                                <tr>
                                                    <td><?php echo $emp['id']; ?></td>
                                                    <td><code><?php echo htmlspecialchars($emp['ruc_emp']); ?></code></td>
                                                    <td class="text-center"><strong><?php echo htmlspecialchars($emp['razon_social_emp']); ?></strong></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Trabajadores -->
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold text-dark mb-0">Trabajadores / Receptores</h5>
                                <button type="button" class="btn btn-outline-success btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#modalTrabajador"><i class="bi bi-person-plus"></i> Asignar Trabajador</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="text-muted small text-uppercase bg-light">
                                        <tr>
                                            <th class="py-2">ID</th>
                                            <th class="py-2 rounded-start">DNI / Nombres</th>
                                            <th class="py-2">Empresa</th>
                                            <th class="py-2">Área</th>
                                            <th class="py-2 text-center rounded-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($lista_trabajadores)): ?>
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-5">
                                                    <i class="bi bi-people fs-2 d-block mb-2 opacity-50"></i>
                                                    No hay trabajadores registrados.
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($lista_trabajadores as $trab): ?>
                                                <tr>
                                                    <td><?php echo $trab['id']; ?></td>
                                                    <td>
                                                        <strong><?php echo htmlspecialchars($trab['nombres']); ?></strong><br>
                                                        <small class="text-muted">DNI: <?php echo htmlspecialchars($trab['DNI']); ?></small>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($trab['razon_social_emp'] ?? 'Sin empresa'); ?></td>
                                                    <td><span class="badge bg-light text-dark"><?php echo htmlspecialchars($trab['nombre_area'] ?? 'Sin área'); ?></span></td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-sm btn-outline-primary" title="Editar"><i class="bi bi-pencil"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Modal Nueva Empresa -->
        <div class="modal fade" id="modalNuevaEmpresa" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="bi bi-arrow-up-right-square me-2"></i> Registrar Nueva Empresa</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="../Controllers/guardarEmpresa.php" method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="col-form-label fw-bold">RUC de la Empresa:</label>
                                <input type="text" class="form-control" name="ruc_emp" placeholder="Ingrese RUC de 11 dígitos" required>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label fw-bold">Razón Social de la Empresa:</label>
                                <input type="text" class="form-control" name="razon_social_emp" placeholder="Ingrese Nombre o Razón Social" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success text-white">Guardar Empresa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Registrar / Asignar Trabajador -->
        <div class="modal fade" id="modalTrabajador" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="bi bi-arrow-up-right-square me-2"></i> Registrar Nuevo Trabajador</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="../Controllers/guardarTrabajador.php" method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="col-form-label fw-bold">DNI Trabajador:</label>
                                <input type="text" class="form-control" name="DNI" placeholder="Ingrese DNI" required>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label fw-bold">Nombres del Trabajador:</label>
                                <input type="text" class="form-control" name="nombres" placeholder="Ingrese Nombres y Apellidos" required>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label fw-bold">Área asignada:</label>
                                <select class="form-select" name="id_area_fk" required>
                                    <option value="">Seleccione una Área...</option>
                                    <?php foreach ($areas_trabajador as $areas): ?>
                                        <option value="<?php echo $areas['id_area']; ?>">
                                            <?php echo htmlspecialchars($areas['nombre_area']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label fw-bold">Sede:</label>
                                <select class="form-select" name="id_sede_fk" required>
                                    <option value="">Seleccione una Sede...</option>
                                    <?php foreach ($sede_trabajador as $sede): ?>
                                        <option value="<?php echo $sede['id_sede']; ?>">
                                            <?php echo htmlspecialchars($sede['nombre']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success text-white">Guardar Trabajador</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

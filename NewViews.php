movimientoAlmacen.php
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../Config/conexion.php';

try {
    // Obtener la bitácora de movimientos uniendo orden_salida con producto y trabajador
    $sql = "SELECT o.*, p.nombre AS producto_nombre, p.codigo, t.nombres AS trabajador_nombre, t.DNI 
            FROM orden_salida o 
            LEFT JOIN producto p ON o.producto_fk = p.id 
            LEFT JOIN trabajador t ON o.id_trabajador_fk = t.id 
            ORDER BY o.id DESC";
    $stmt = $conexion->query($sql);
    $movimientos = $stmt.fetchAll(PDO::FETCH_ASSOC);

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
                                <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-arrow-up-right-square me-2"></i>Nueva Salida</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="../Controllers/nuevaSalidaController.php" method="POST">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="col-form-label fw-bold">ID del Producto:</label>
                                        <input type="text" class="form-control" name="producto_fk" placeholder="Ingrese ID del producto" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="col-form-label fw-bold">Fecha de Salida:</label>
                                        <input type="date" class="form-control" name="fecha_salida" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="col-form-label fw-bold">ID del Trabajador Asignado:</label>
                                        <input type="text" class="form-control" name="id_trabajador_fk" placeholder="Ingrese ID del trabajador" required>
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

                <!-- Tabla de Movimientos / Historial -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0">Bitácora de Movimientos</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="text-muted small text-uppercase bg-light">
                                <tr>
                                    <th class="py-3 rounded-start">ID Movimiento</th>
                                    <th class="py-3">Producto</th>
                                    <th class="py-3">Trabajador Responsable</th>
                                    <th class="py-3">Fecha de Salida</th>
                                    <th class="py-3 text-center rounded-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($movimientos)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5">
                                            <i class="bi bi-clock-history fs-2 d-block mb-2 opacity-50"></i>
                                            No hay movimientos registrados en el sistema.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($movimientos as $mov): ?>
                                        <tr>
                                            <td><strong>#<?php echo $mov['id']; ?></strong></td>
                                            <td>
                                                <?php echo htmlspecialchars($mov['producto_nombre'] ?? 'Desconocido'); ?><br>
                                                <small class="text-muted">SKU: <?php echo htmlspecialchars($mov['codigo'] ?? 'N/A'); ?></small>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($mov['trabajador_nombre'] ?? 'Sin asignar'); ?><br>
                                                <small class="text-muted">DNI: <?php echo htmlspecialchars($mov['DNI'] ?? 'N/A'); ?></small>
                                            </td>
                                            <td><?php echo htmlspecialchars($mov['fecha_salida']); ?></td>
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






inventarioAlmacen.php
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../Config/conexion.php';

try {
    // Obtener empresas para el filtro
    $stmtEmpresas = $conexion->query("SELECT id, razon_social_emp FROM gc_empresas ORDER BY razon_social_emp ASC");
    $empresas = $stmtEmpresas->fetchAll(PDO::FETCH_ASSOC);

    // Obtener estados para el filtro
    $stmtEstados = $conexion->query("SELECT id, nombre FROM estado_producto ORDER BY id ASC");
    $estados = $stmtEstados->fetchAll(PDO::FETCH_ASSOC);

    // Consulta real uniendo producto con empresa, estado y tipo de producto
    $sql = "SELECT p.*, e.razon_social_emp, est.nombre AS estado_nombre, tp.nombre AS tipo_nombre 
            FROM producto p 
            LEFT JOIN gc_empresas e ON p.id_empresa_fk = e.id 
            LEFT JOIN estado_producto est ON p.id_estado_fk = est.id 
            LEFT JOIN tipo_producto tp ON p.tipo_producto_fk = tp.id 
            ORDER BY p.id DESC";
    $stmt = $conexion->query($sql);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $empresas = [];
    $estados = [];
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
                                <?php foreach ($empresas as $emp): ?>
                                    <option value="<?php echo htmlspecialchars($emp['razon_social_emp']); ?>"><?php echo htmlspecialchars($emp['razon_social_emp']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted fw-semibold">Filtrar por Estado</label>
                            <select class="form-select rounded-3">
                                <option selected>Todos los Estados</option>
                                <?php foreach ($estados as $est): ?>
                                    <option value="<?php echo htmlspecialchars($est['nombre']); ?>"><?php echo htmlspecialchars($est['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted fw-semibold">Búsqueda Rápida</label>
                            <input type="text" id="inputBusqueda" class="form-control rounded-3" placeholder="Buscar por SKU, nombre, marca..." autocomplete="off">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Inventario -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="text-muted small text-uppercase bg-light">
                                <tr>
                                    <th class="py-3 rounded-start">SKU / Código</th>
                                    <th class="py-3">Producto</th>
                                    <th class="py-3">Marca</th>
                                    <th class="py-3">Empresa</th>
                                    <th class="py-3">Estado</th>
                                    <th class="py-3">Tipo</th>
                                    <th class="py-3 text-center rounded-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($productos)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-5">
                                            <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                            No hay productos registrados en el inventario.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($productos as $prod): ?>
                                        <tr>
                                            <td><strong><?php echo htmlspecialchars($prod['codigo'] ?? '#' . $prod['id']); ?></strong></td>
                                            <td><?php echo htmlspecialchars($prod['nombre']); ?></td>
                                            <td><?php echo htmlspecialchars($prod['marca']); ?></td>
                                            <td><?php echo htmlspecialchars($prod['razon_social_emp'] ?? 'Sin empresa'); ?></td>
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







personalAlmacen.php
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../Config/conexion.php';

try {
    // Obtener empresas asociadas
    $stmtEmp = $conexion->query("SELECT id, ruc_emp, razon_social_emp FROM gc_empresas ORDER BY id ASC");
    $lista_empresas = $stmtEmp->fetchAll(PDO::FETCH_ASSOC);

    // Obtener trabajadores vinculados a su empresa y área
    $stmtTrab = $conexion->query("SELECT t.*, e.razon_social_emp, a.nombre_area 
                                  FROM trabajador t 
                                  LEFT JOIN gc_empresas e ON t.id_empresa_fk = e.id 
                                  LEFT JOIN areas a ON t.id_area_fk = a.id_area 
                                  ORDER BY t.id DESC");
    $lista_trabajadores = $stmtTrab->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
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
                    <!-- Tabla de Empresas -->
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
                                                    <td><?php echo htmlspecialchars($emp['ruc_emp']); ?></td>
                                                    <td class="text-center"><?php echo htmlspecialchars($emp['razon_social_emp']); ?></td>
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
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="text-muted small text-uppercase bg-light">
                                        <tr>
                                            <th class="py-2 rounded-start">DNI / Nombre</th>
                                            <th class="py-2">Empresa</th>
                                            <th class="py-2 text-center rounded-end">Área</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($lista_trabajadores)): ?>
                                            <tr>
                                                <td colspan="3" class="text-center text-muted py-5">
                                                    <i class="bi bi-people fs-2 d-block mb-2 opacity-50"></i>
                                                    No hay trabajadores registrados.
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($lista_trabajadores as $trab): ?>
                                                <tr>
                                                    <td>
                                                        <strong><?php echo htmlspecialchars($trab['nombres'] ?? ''); ?></strong><br>
                                                        <small class="text-muted">DNI: <?php echo htmlspecialchars($trab['DNI'] ?? 'N/A'); ?></small>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($trab['razon_social_emp'] ?? 'Sin asignar'); ?></td>
                                                    <td class="text-center">
                                                        <span class="badge bg-light text-dark"><?php echo htmlspecialchars($trab['nombre_area'] ?? 'Sin área'); ?></span>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

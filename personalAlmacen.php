<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../Config/conexion.php';

try {       // Extraer de la base de datos.

    $stmtAreas = $conexion->query("SELECT * FROM areas");
    $areas_trabajador = $stmtAreas->fetchAll(PDO::FETCH_ASSOC);

    $stmtSede = $conexion->query("SELECT * FROM sede");
    $sede_trabajador = $stmtSede->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {

    $areas_trabajador = [];
    $sede_trabajador = [];
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
                    <li class="nav-item"><a href="centroAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-grid me-2"></i> Centroo</a></li>
                    <li class="nav-item"><a href="inventarioAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-boxes me-2"></i> Inventario</a></li>
                    <li class="nav-item"><a href="movimientosAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-arrow-left-right me-2"></i> Movimientos</a></li>
                    <li class="nav-item"><a href="personalAlmacen.php" class="nav-link text-success fw-semibold bg-success bg-opacity-10 px-3 py-2 rounded-3"><i class="bi bi-buildings me-2"></i> Empresas y Personal</a></li> <br>
                    <li class="nav-item"><a href="../../index.php" class="btn btn-success px-5 rounded-pill shadow-sm btn-sm"><i class="bi bi-box-arrow-right"></i>   Cerrar  Sesión</a></li>
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
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-5">
                                                <i class="bi bi-people fs-2 d-block mb-2 opacity-50"></i>
                                                No hay Empresas registrados.
                                            </td>
                                        </tr>
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
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-5">
                                                <i class="bi bi-people fs-2 d-block mb-2 opacity-50"></i>
                                                No hay trabajadores registrados.
                                            </td>
                                        </tr>
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
                    <div class="modal-dialog modal-md down">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title"><i class="bi bi-arrow-up-right-square me-2"></i> Registrar Nueva Empresa </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">RUC de la Empresa:</label>
                                    <input type="text" class="form-control" id="recipient-name">
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Razón Social de la Empresa:</label>
                                    <input type="date" class="form-control" id="recipient-name">
                                </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-success text-white">Continuar</button>
                                </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

<!-- Modal asignar Trabajador-->
                <div class="modal fade" id="modalTrabajador" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-md down">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title"><i class="bi bi-arrow-up-right-square me-2"></i> Registrar Nuevo Trabajador </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">DNI Trabajador:</label>
                                    <input type="text" class="form-control" id="recipient-name">
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Nombres del Trabajador:</label>
                                    <input type="text" class="form-control" id="recipient-name">
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Área asignada:</label>
                                        <select class="form-select" name="id_area" required>
                                            <option value="">Seleccione una Área...</option>
                                            <?php foreach ($areas_trabajador as $areas): ?>
                                                <option value="<?php echo $areas['id_area']; ?>">
                                                    <?php echo htmlspecialchars($areas['nombre_area']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Sede:</label>
                                        <select class="form-select" name="id_sede" required>
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
                                    <button type="button" class="btn btn-success text-white">Continuar</button>
                                </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
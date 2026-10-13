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
    <title>Centro de Almacen - Grupo T-Soluciona</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container-fluid">
        <div class="row min-vh-100">
            <!-- menú Lateral -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-white border-end p-4 sidebar">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-success bg-opacity-10 p-2 rounded-3 text-success me-2">
                        <i class="bi bi-box-seam fs-5"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Grupo T-soluciona</h6>
                        <small class="text-muted">Almacén de Sistemas</small>
                    </div>
                </div>

                <ul class="nav flex-column gap-1">
                    <li class="nav-item"><a href="centroAlmacen.php" class="nav-link text-success fw-semibold bg-success bg-opacity-10 px-3 py-2 rounded-3"><i class="bi bi-grid me-2"></i> Centroo</a></li>
                    <li class="nav-item"><a href="inventarioAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-boxes me-2"></i> Inventario</a></li>
                    <li class="nav-item"><a href="movimientosAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-arrow-left-right me-2"></i> Movimientos</a></li>
                    <li class="nav-item"><a href="personalAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-buildings me-2"></i> Empresas y Personal</a></li><br>
                    <li class="nav-item"><a href="../../index.php" class="btn btn-success px-5 rounded-pill shadow-sm btn-sm"><i class="bi bi-box-arrow-right"></i>   Cerrar  Sesión</a></li>
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

                <!-- Tarjetas de Mer listapa5a la baswe de datps -->


                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-3 border-start border-success border-4 h-100">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted text-uppercase small fw-bold mb-1">Hardware Principal</h6>
                                    <h3 class="fw-bold text-dark mb-0"><?php echo $totalHardware; ?></h3>
                                </div>
                                <div class="fs-1 text-success opacity-50"><i class="fab fa-google-drive"></i></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-3 border-start border-primary border-4 h-100">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted text-uppercase small fw-bold mb-1"> Accesorios</h6>
                                    <h3 class="fw-bold text-dark mb-0"><?php echo $totalAcces; ?></h3>
                                </div>
                                <div class="fs-1 text-primary opacity-50"><i class="fab fa-windows"></i></div>
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
                                <div class="fs-1 text-warning opacity-50"><i class="fas fa-briefcase"></i></div>
                            </div>
                        </div>
                    </div>
                    </div>


                <!--  Disponibilidad y Accesos Rápidos -->
                <div class="row g-4">
                    <!-- Panel de Disponibilidad de Backups -->
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

                    <!-- Accesos Rápidos -->
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                            <h5 class="fw-bold text-dark mb-3">Acciones Rápidas</h5>
                            <p class="text-muted small mb-3">Accesos directos para la gestión del almacén.</p>
                            
                            <div class="d-grid gap-3">

                                <button type="button" class="btn btn-outline-secondary py-3 rounded-3 text-start px-4 d-flex justify-content-between align-items-center" data-bs-toggle="modal" data-bs-target="#modalNuevaSalida" title="Registrar Nueva Salida">
                                    <span><i class="bi bi-arrow-up-right-square me-2"></i>Registrar Nueva Salida</span>
                                    <i class="bi bi-chevron-right"></i>
                                </button>

                                <button type="button" class="btn btn-outline-secondary py-3 rounded-3 text-start px-4 d-flex justify-content-between align-items-center" data-bs-toggle="modal" data-bs-target="#modalNuevoProducto" title="Registrar Nuevo Producto">
                                <span><i class="bi bi-box-arrow-in-down me-2"></i>Agregar Nuevo Producto</span>
                                    <i class="bi bi-chevron-right"></i>
                                </button>

                                <button type="button"  class="btn btn-outline-secondary py-3 rounded-3 text-start px-4 d-flex justify-content-between align-items-center" data-bs-toggle="modal" href="#exampleModalToggle" role="button">
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
                    <div class="modal-dialog modal-md down">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-white">
                                <h5 class="modal-title"><i class="bi bi-arrow-up-right-square me-2"></i> Nueva Salida</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="../Controllers/guardarNuevaSalida.php" method="POST">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">ID del Producto:</label>
                                    <input type="number" class="form-control" id="recipient-name">
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Fecha de Salida:</label>
                                    <input type="date" class="form-control" id="recipient-name">
                                </div>
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label">ID del trabajador asignado :</label>
                                    <input type="number" class="form-control" id="recipient-name">
                                </div>
                                
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-warning text-white">Continuar</button>
                                </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal  Agregar Nuevo Producto --> 
                <div class="modal fade" id="modalNuevoProducto" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg down">
                        <div class="modal-content" style="max-width: 600px;">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h3 class="fw-bold mb-3"><i class="bi bi-plus-lg"></i> Añadir Nuevo Producto</h3>
                                <hr class="mb-4">

                                <form action="../Controllers/nuevoProductoController.php" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nombre:</label>
                                        <input type="text" class="form-control" name="nombre" placeholder="Ingrese nombre del Producto"  required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Marca:</label>
                                        <input type="text" class="form-control" name="marca" placeholder="Ingrese la Marca del Producto"  required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Fecha de Ingreso:</label>
                                        <input type="date" class="form-control" name="fecha_ingreso" placeholder="Seleccione Fecha" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Costo del Producto:</label>
                                        <input type="number" class="form-control" name="costo" placeholder="Ej. 120.50" required>
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
                                            <option value="activo" selected>Seleccione un Estado</option>
                                            <?php foreach ($estado_producto as $estado): ?>
                                                <option value="<?php echo $estado['id']; ?>">
                                                    <?php echo htmlspecialchars($estado['nombre']); ?>
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
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Guardar Producto</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>


                <!-- Modal Registrar Trabajador o Empresa -->
                <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                             <div class="modal-header bg-success text-white">
                                <h5 class="modal-title"><i class="bi bi-arrow-up-right-square me-2"></i> Registrar Trabajador</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">DNI Trabajador:</label>
                                    <input type="text" class="form-control" id="recipient-name">
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Nombres:</label>
                                    <input type="text" class="form-control" id="recipient-name">
                                </div>
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label">Área asignada:</label>
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
                                    <label for="message-text" class="col-form-label">Sede Asignada:</label>
                                        <select class="form-select" name="id_sede" required>
                                            <option value="">Seleccione una Sede...</option>
                                            <?php foreach ($sede_trabajador as $sede): ?>
                                                <option value="<?php echo $sede['id_sede']; ?>">
                                                    <?php echo htmlspecialchars($sede['nombre']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                </div>
                                     
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-success text-white">Continuar</button>
                                </div>
                                </div>
                                </form>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">Nueva Empresa</button>
                    </div>
                    </div>
                </div>
                </div>
                <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                             <div class="modal-header bg-warning text-white">
                                <h5 class="modal-title"><i class="bi bi-arrow-up-right-square me-2"></i>Registrar Nueva Empresa</h5>
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
                                    <input type="text" class="form-control" id="recipient-name">
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-warning text-white">Continuar</button>
                                </div>
                                </div>
                                </form>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-bs-target="#exampleModalToggle" data-bs-toggle="modal" data-bs-dismiss="modal">Nuevo Trabajador</button>
                    </div>
                    </div>
                </div>
                </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
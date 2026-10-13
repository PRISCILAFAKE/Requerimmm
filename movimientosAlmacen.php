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
            <!-- Menú  -->
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
                    <li class="nav-item"><a href="movimientosAlmacen.php" class="nav-link text-success fw-semibold bg-success bg-opacity-10 px-3 py-2 rounded-3"><i class="bi bi-arrow-left-right me-2"></i> Movimientos</a></li>
                    <li class="nav-item"><a href="personalAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-buildings me-2"></i> Empresas y Personal</a></li> <br>
                    <li class="nav-item"><a href="../../index.php" class="btn btn-success px-5 rounded-pill shadow-sm btn-sm"><i class="bi bi-box-arrow-right"></i>   Cerrar  Sesión</a></li>
                </ul>
            </nav>

            <!-- Contenido Principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5 py-4">
                <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded-4 shadow-sm mb-4 border border-light-subtle">
                    <div>
                        <h1 class="h4 fw-bold text-dark mb-1">Movimientos y Registro de Salidas</h1>
                        <p class="text-muted small mb-0">Control de entregas de equipos e historial de operaciones de almacén.</p>
                    </div>
                     <button type="button" class="btn btn-success px-4 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><i class="bi bi-plus-lg me-1"></i>Registrar Nueva Salida</button>
                </div>



                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Nueva Salida</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
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
                                <button type="button" class="btn btn-success">Continuar</button>
                            </div>
                            </div>
                                 </form>
                        </div>
                        </div>



                <!-- Tabla de Movimientos / Historial  -->
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
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                        <i class="bi bi-clock-history fs-2 d-block mb-2 opacity-50"></i>
                                        No hay movimientos registrados en el sistema.
                                    </td>
                                </tr>
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
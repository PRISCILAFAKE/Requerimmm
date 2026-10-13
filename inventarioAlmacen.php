<?php
session_start();

$host = "localhost";
$db = "xternaco_sistemas";
$user = "root"; //cambiar cuando lo suban 
$pass = "";

try {
    $conexion = new mysqli($host, $user,$pass, $db);$conexion->set_charset("utf8mb4");
    
    $query_empresas = "SELECT id, razon_social_emp FROM gc_empresas ORDER BY razon_social_emp ASC";
    $resultado_empresas = $conexion->query($query_empresas);

} catch (mysqli_sql_exception $e) {
    die("<div class='container mt-5 alert alert-danger'><strong>Error de conexión:</strong> " . $e->getMessage() . "<br><small class='text-muted'>Verifica si tu base de datos se llama 'xternaco_sistemas' exactamente.</small></div>");
}


try {
    $conexion = new mysqli($host, $user,$pass, $db);$conexion->set_charset("utf8mb4");
    
    $query_estados= "SELECT id, nombre FROM estado_producto ORDER BY id ASC";
    $resultado_estados = $conexion->query($query_estados);

    } catch (mysqli_sql_exception $e) {
        die("<div class='container mt-5 alert alert-danger'><strong>Error de conexión:</strong> " . $e->getMessage() . "<br><small class='text-muted'>Verifica si MySQL utiliza el puerto 3307 en tu XAMPP.</small></div>");
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
            <!-- Mmnú -->
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
                    <li class="nav-item"><a href="centroAlmacen.php" class="nav-link text-secondary  px-3 py-2 rounded-3"><i class="bi bi-grid me-2"></i> Centroo</a></li>
                    <li class="nav-item"><a href="inventarioAlmacen.php" class="nav-link text-success fw-semibold bg-success bg-opacity-10 px-3 py-2 rounded-3"><i class="bi bi-boxes me-2"></i> Inventario</a></li>
                    <li class="nav-item"><a href="movimientosAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-arrow-left-right me-2"></i> Movimientos</a></li>
                    <li class="nav-item"><a href="personalAlmacen.php" class="nav-link text-secondary px-3 py-2 rounded-3"><i class="bi bi-buildings me-2"></i> Empresas y Personal</a></li> <br>
                    <li class="nav-item"><a href="../../index.php" class="btn btn-success px-5 rounded-pill shadow-sm btn-sm"><i class="bi bi-box-arrow-right"></i>   Cerrar  Sesión</a></li>
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
                                    <?php 
                                    if (isset($resultado_empresas) &&$resultado_empresas->num_rows > 0) {
                                        while ($empresa =$resultado_empresas->fetch_assoc()) {
                                            echo '<option value="' . htmlspecialchars($empresa['razon_social_emp']) . '">' . htmlspecialchars($empresa['razon_social_emp']) . '</option>';
                                        }
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted fw-semibold">Filtrar por Estado</label>
                            <select class="form-select rounded-3">
                                <option selected>Todos los Estados</option>
                                    <?php 
                                    if (isset($resultado_estados) &&$resultado_estados->num_rows > 0) {
                                        while ($nombreEstado =$resultado_estados->fetch_assoc()) {
                                            echo '<option value="' . htmlspecialchars($nombreEstado['nombre']) . '">' . htmlspecialchars($nombreEstado['nombre']) . '</option>';
                                        }
                                    }
                                    ?>
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                                <label class="form-label small text-muted fw-semibold">Búsqueda Rápida</label>
                                <input type="text" id="inputBusqueda" class="form-control rounded-3" placeholder="Buscar por SKU, nombre, marca..." autocomplete="off">
                        
                        </div>
                    </div>
                </div>


                <!-- Tabla de Inventario-->
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
                                    <th class="py-3">Sede</th>
                                    <th class="py-3">Estado</th>
                                    <th class="py-3">Tipo de Producto</th>
                                    <th class="py-3 text-center rounded-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                        No hay productos registrados en el inventario.
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
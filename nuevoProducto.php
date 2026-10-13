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
    <title>Nueva Producto - Grupo T-Soluciona</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
<br>
<br>
    <div class="container" style="max-width: 600px;">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-3"><i class="bi bi-plus-lg"></i> Añadir Nuevo Producto</h3>
                <hr class="mb-4">

                <form action="../Controllers/guardarNuevoProducto.php" method="POST">
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
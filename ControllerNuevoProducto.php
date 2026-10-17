//nuevoaProductoController:
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../Config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre         = trim($_POST['nombre'] ?? '');
    $marca          = trim($_POST['marca'] ?? '');
    $fecha_ingreso  = trim($_POST['fecha_ingreso'] ?? '');
    $costo          = trim($_POST['costo'] ?? 0);
    $fk_empresa     = trim($_POST['empresa'] ?? null);
    $id_estado_fk   = trim($_POST['estado'] ?? null);
    $tipo_producto  = trim($_POST['tipo_producto'] ?? null);

    if (empty($nombre) || empty($marca) || empty($fecha_ingreso) || empty($costo) || empty($fk_empresa) || empty($id_estado_fk) || empty($tipo_producto)) {
        die("<div style='color:red; font-family:sans-serif; padding:20px;'><strong>Error:</strong> Todos los campos obligatorios deben ser completados. <a href='../Views/nuevoProducto.php'>Volver</a></div>");
    }

    try {
        // 1. Obtener las 3 primeras letras del tipo de producto
        $stmtTipo = $conexion->prepare("SELECT nombre FROM al_tipo_producto WHERE id = :id");
        $stmtTipo->execute([':id' => $tipo_producto]);
        $tipoData = $stmtTipo->fetch();
        $nombreTipo = $tipoData ? $tipoData['nombre'] : 'GEN';
        $prefijoTipo = strtoupper(substr($nombreTipo, 0, 3));

        // 2. Obtener las 3 primeras letras de la marca
        $prefijoMarca = strtoupper(substr($marca, 0, 3));

        // 3. Insertar primero el producto para obtener su ID autoincrementable real
        $sqlInsert = "INSERT INTO al_producto (nombre, marca, fecha_ingreso, costo, fk_empresa, id_estado_fk, tipo_producto_fk) 
                      VALUES (:nombre, :marca, :fecha_ingreso, :costo, :fk_empresa, :id_estado_fk, :tipo_producto_fk)";
        
        $stmt = $conexion->prepare($sqlInsert);
        $stmt->execute([
            ':nombre'           => $nombre,
            ':marca'            => $marca,
            ':fecha_ingreso'    => $fecha_ingreso,
            ':costo'            => $costo,
            ':fk_empresa'       => $fk_empresa,
            ':id_estado_fk'     => $id_estado_fk,
            ':tipo_producto_fk' => $tipo_producto
        ]);

        // 4. Obtener el ID real generado en la base de datos
        $idGenerado = $conexion->lastInsertId();

        // 5. Aplicar ceros dinámicos al ID (ej. 1 -> 001, 12 -> 012)
        $correlativo = str_pad($idGenerado, 3, '0', STR_PAD_LEFT);

        // 6. Construir el SKU definitivo
        $codigo = $prefijoTipo . '-' . $prefijoMarca . '-' . $correlativo;

        // 7. Actualizar el registro con el código SKU generado
        $sqlUpdate = "UPDATE al_producto SET codigo = :codigo WHERE id = :id";
        $stmtUpdate = $conexion->prepare($sqlUpdate);
        $stmtUpdate->execute([
            ':codigo' => $codigo,
            ':id'     => $idGenerado
        ]);

        // Redirigir al inventario con éxito
        header("Location: ../Views/inventarioAlmacen.php?exito=1");
        exit();

    } catch (PDOException $e) {
        echo "<div style='color:red; font-family:sans-serif; padding:20px;'>
                <strong>Error al guardar el producto en la Base de Datos:</strong> " . htmlspecialchars($e->getMessage()) . "<br><br>
                <a href='../Views/nuevoProducto.php'>Regresar al formulario</a>
              </div>";
    }
} else {
    header("Location: ../Views/inventarioAlmacen.php");
    exit();
}
?>






//guardar salida controller:

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../Config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $producto       = trim($_POST['producto_fk'] ?? null);
    $fecha_salida     = trim($_POST['fecha_salida'] ?? '');
    $id_trabajador       = trim($_POST['id_trabajador_fk'] ?? null);

    try {
        $sql = "INSERT INTO al_orden_salida (producto_fk, fecha_salida, id_trabajador_fk)
                VALUES (:producto, :fecha, :trabajador)";

        $stmt = $conexion->prepare($sql);

        $stmt->execute([
            ':producto'   => $producto,
            ':fecha'      => $fecha_salida,
            ':trabajador' => $id_trabajador // Corregido: se agregaron los dos puntos ':'
        ]);

        header("Location: ../Views/movimientosAlmacen.php?exito=1");
        exit();

    } catch (PDOException $e) {
        echo "<div style='color:red; font-family:sans-serif; padding:20px;'>
                <strong>Error al Registrar la Salida en la BD:</strong> " . htmlspecialchars($e->getMessage()) . "<br><br>
                <a href='../Views/centroAlmacen.php'>Regresar al inicio</a>
              </div>";
    }
} else {
    header("Location: ../Views/centroAlmacen.php");
    exit();
}
?>






//inventarioAlmscen
modal de edición

<div class="mb-3">
    <label class="col-form-label fw-bold">Fecha de Ingreso:</label>
    <input type="date" class="form-control" name="fecha_ingreso" id="edit-fecha" required>
</div>
<div class="mb-3">
    <label class="col-form-label fw-bold">Costo del Producto:</label>
    <input type="number" step="0.01" class="form-control" name="costo" id="edit-costo" required> <!-- Corregido de edit-fecha a edit-costo -->
</div>











//script de modal edición:
document.addEventListener('DOMContentLoaded', function () {
    const modalEditar = document.getElementById('modalEditarProducto');
    modalEditar.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');
        const nombre = button.getAttribute('data-nombre');
        const marca = button.getAttribute('data-marca');
        const fecha = button.getAttribute('data-fecha');
        const costo = button.getAttribute('data-costo');
        const estado = button.getAttribute('data-estado');
        const tipo = button.getAttribute('data-tipo');
        const empresa = button.getAttribute('data-empresa');

        // Rellenar los campos del formulario dentro del modal
        modalEditar.querySelector('#edit-id').value = id;
        modalEditar.querySelector('#edit-nombre').value = nombre;
        modalEditar.querySelector('#edit-marca').value = marca;
        modalEditar.querySelector('#edit-fecha').value = fecha;
        modalEditar.querySelector('#edit-costo').value = costo; // Apunta correctamente al id edit-costo
        modalEditar.querySelector('#edit-estado').value = String(estado);
        modalEditar.querySelector('#edit-tipo').value = String(tipo);
        modalEditar.querySelector('#edit-empresa').value = String(empresa);
    });
});

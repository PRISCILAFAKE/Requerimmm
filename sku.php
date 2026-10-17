
//nuevoProductoController.php:
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
        //  Obtener las 3 primeras letras del tipo de producto
        $stmtTipo = $conexion->prepare("SELECT nombre FROM tipo_producto WHERE id = :id");
        $stmtTipo->execute([':id' => $tipo_producto]);
        $tipoData = $stmtTipo->fetch();
        $nombreTipo = $tipoData ? $tipoData['nombre'] : 'GEN';
        $prefijoTipo = strtoupper(substr($nombreTipo, 0, 3));

        //  Obtener las 3 primeras letras de la marca
        $prefijoMarca = strtoupper(substr($marca, 0, 3));

        // Insertar primero el producto para obtener su ID autoincrementable real
        $sqlInsert = "INSERT INTO producto (nombre, marca, fecha_ingreso, costo, fk_empresa, id_estado_fk, tipo_producto_fk) 
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

        //  Obtener el ID recién asignado en la BD
        $idGenerado = $conexion->lastInsertId();

        //  Formatear el ID con ceros dinámicos según su cantidad de dígitos (ej: 1 -> 001, 12 -> 012, 123 -> 123)
        $correlativo = str_pad($idGenerado, 3, '0', STR_PAD_LEFT);

        //  Construir el código SKU definitivo
        $codigo = $prefijoTipo . '-' . $prefijoMarca . '-' . $correlativo;

        //  Actualizar el registro recién creado con su código generado
        $sqlUpdate = "UPDATE producto SET codigo = :codigo WHERE id = :id";
        $stmtUpdate = $conexion->prepare($sqlUpdate);
        $stmtUpdate->execute([
            ':codigo' => $codigo,
            ':id'     => $idGenerado
        ]);

        // Redirigir al inventario
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

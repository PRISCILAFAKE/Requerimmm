<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../Config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo_usuario'] ?? '');
    $contrasena = trim($_POST['contraseña_usuario'] ?? '');

    if (empty($correo) || empty($contrasena)) {
        echo "<script>alert('Por favor, complete todos los campos.'); window.location.href='../index.php';</script>";
        exit();
    }

    try {
        // Consulta adaptada para obtener nombre real y datos de área
        $sql = "SELECT u.*, 
                       t.nombres AS nombre, 
                       t.id_area_fk, 
                       a.nombre_area AS nombre_area 
                FROM usuario u 
                LEFT JOIN trabajador t ON u.id_trabajador_fk = t.id 
                LEFT JOIN areas a ON t.id_area_fk = a.id_area 
                WHERE u.correo = :correo AND u.contrasena = :contrasena and u.rol in ('Administrador_al')";
                
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':correo' => $correo,
            ':contrasena' => $contrasena
        ]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $estado = strtolower(trim($usuario['estado'] ?? 'activo'));
            if ($estado === 'inhabilitado' || $estado === 'inactivo' || $estado === '0') {
                echo "<script>alert('Su cuenta se encuentra inhabilitada. Contacte al administrador.'); window.location.href='../index.php';</script>";
                exit();
            }

            $_SESSION['user'] = $usuario['nombre'] ?? $usuario['correo'];
            $_SESSION['correo'] = $usuario['correo'];
            $_SESSION['rol'] = $usuario['rol'];
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['id_area'] = $usuario['id_area_fk'] ?? 'No asignado';
            $_SESSION['nombre_area'] = $usuario['nombre_area'] ?? 'Sin área';
            $_SESSION['es_jefe'] = $usuario['es_jefe'] ?? 0;

            $rol = strtolower(trim($usuario['rol']));
            $es_jefe = intval($usuario['es_jefe'] ?? 0);

            if ($es_jefe === 1) {
                header("Location: ../View/bandeja_jefe_view.php");
                exit();
            } elseif ($rol === 'solicitante') {
                header("Location: ../View/solicitud_view.php");
                exit();
            } elseif ($rol === 'encargado' || $rol === 'admin' || $rol === 'administrador') {
                header("Location: ../View/solicitud_crud_view.php");
                exit();
            } elseif ($rol === 'gerencia' || $rol === 'gerente') {
                header("Location: ../View/solicitud_ge_view.php");
                exit();
            } elseif ($rol === 'encargado_tck' || $rol === 'admin_tck' || $rol === 'administrador_tck' || $rol === 'solicitante_tck') {
                header("Location: ../../tck/index.php");
                exit();
            } elseif ($rol === 'encargado_gc' || $rol === 'admin_gc' || $rol === 'administrador_gc') {
                header("Location: ../../index.php");
                exit();
            } elseif ($rol === 'encargado_al' || $rol === 'admin_al' || $rol === 'administrador_al') {
                header("Location: ../Views/centroAlmacen.php");
                exit();
            } else {
                die("Error: El rol de este usuario ('" . htmlspecialchars($usuario['rol']) . "') no está configurado.");
            }

        } else {
            echo "<script>alert('Correo o contraseña incorrectos.'); window.location.href='../index.php';</script>";
            exit();
        }

    } catch (PDOException $e) {
        die("Error en el login: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>
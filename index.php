<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Sesión Sistema Almacen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 25rem;">
            
            <div class="d-flex align-items-center justify-content-between mb-4">
                <a href="../index.php" class="btn btn-outline-secondary btn-sm p-2 d-flex align-items-center justify-content-center rounded-circle" style="width: 38px; height: 38px;" title="Ir al inicio">
                    <i class="bi bi-house-door fs-5"></i>
                </a>
                <h3 class="mb-0 text-center flex-grow-1">Iniciar Sesión</h3>

                <div style="width: 38px;"></div>
            </div>

            <form action="Controllers/login_controller.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Usuario:</label>
                    <input type="email" name="correo_usuario" class="form-control" placeholder="Ej. tunombre@gmail.com" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" name="contraseña_usuario" placeholder="Ingresa tu contraseña" required>
                </div>

                <button type="submit" class="btn btn-success w-100" >Continuar</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
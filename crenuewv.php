edit centroAlmacenController:
try {
    // Listas para el buscador del modal de salidas
    $stmtProdSalida = $conexion->query("SELECT id, nombre, marca, codigo FROM producto ORDER BY nombre ASC");
    $lista_productos_salida = $stmtProdSalida->fetchAll();

    $stmtTrabSalida = $conexion->query("SELECT id, DNI, nombres FROM trabajador ORDER BY nombres ASC");
    $lista_trabajadores_salida = $stmtTrabSalida->fetchAll();
} catch (PDOException $e) {
    $lista_productos_salida = [];
    $lista_trabajadores_salida = [];
}




movimientosAlmacen:  al principio 
try {
    // Listas para el buscador del modal de salidas
    $stmtProdSalida = $conexion->query("SELECT id, nombre, marca, codigo FROM producto ORDER BY nombre ASC");
    $lista_productos_salida = $stmtProdSalida->fetchAll();

    $stmtTrabSalida = $conexion->query("SELECT id, DNI, nombres FROM trabajador ORDER BY nombres ASC");
    $lista_trabajadores_salida = $stmtTrabSalida->fetchAll();
} catch (PDOException $e) {
    $lista_productos_salida = [];
    $lista_trabajadores_salida = [];
}





modal centroAlmacenyMovimirnyo
<!-- Modal Nueva Salida -->
<div class="modal fade" id="modalNuevaSalida" tabindex="-1" aria-hidden="true"> <!-- (Nota: En movimientosAlmacen el ID es #exampleModal, ajusta según corresponda) -->
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title"><i class="bi bi-arrow-up-right-square me-2"></i> Nueva Salida</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/guardarSalidaController.php" method="POST" id="formNuevaSalida">
                <div class="modal-body">
                    
                    <!-- Selector con buscador para Producto -->
                    <div class="mb-3">
                        <label class="col-form-label fw-bold">Producto:</label>
                        <input type="text" class="form-control" list="datalistProductos" id="inputBusquedaProducto" placeholder="Escriba para buscar por nombre, marca o SKU..." autocomplete="off" required>
                        <datalist id="datalistProductos">
                            <?php foreach ($lista_productos_salida as $prod): ?>
                                <option data-id="<?php echo $prod['id']; ?>" value="<?php echo htmlspecialchars($prod['nombre'] . ' - ' . $prod['marca'] . ' (' . ($prod['codigo'] ?? 'SKU-' . $prod['id']) . ')'); ?>">
                            <?php endforeach; ?>
                        </datalist>
                        <!-- Input oculto que envía el ID real a la base de datos -->
                        <input type="hidden" name="producto_fk" id="producto_fk_hidden" required>
                    </div>

                    <div class="mb-3">
                        <label class="col-form-label fw-bold">Fecha de Salida:</label>
                        <input type="date" class="form-control" name="fecha_salida" required>
                    </div>

                    <!-- Selector con buscador para Trabajador -->
                    <div class="mb-3">
                        <label class="col-form-label fw-bold">Trabajador Asignado:</label>
                        <input type="text" class="form-control" list="datalistTrabajadores" id="inputBusquedaTrabajador" placeholder="Escriba para buscar por DNI o nombres..." autocomplete="off" required>
                        <datalist id="datalistTrabajadores">
                            <?php foreach ($lista_trabajadores_salida as $trab): ?>
                                <option data-id="<?php echo $trab['id']; ?>" value="<?php echo htmlspecialchars($trab['nombres'] . ' - DNI: ' . $trab['DNI']); ?>">
                            <?php endforeach; ?>
                        </datalist>
                        <!-- Input oculto que envía el ID real a la base de datos -->
                        <input type="hidden" name="id_trabajador_fk" id="id_trabajador_fk_hidden" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning text-white">Continuar</button>
                </div>
            </form>
        </div>
    </div>
</div>




script 
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Sincronizar ID de Producto
    const inputProd = document.getElementById('inputBusquedaProducto');
    const hiddenProd = document.getElementById('producto_fk_hidden');
    const listProd = document.getElementById('datalistProductos');

    if (inputProd) {
        inputProd.addEventListener('input', function () {
            let val = this.value;
            hiddenProd.value = ''; // Limpiar por si escriben algo inválido
            for (let option of listProd.options) {
                if (option.value === val) {
                    hiddenProd.value = option.getAttribute('data-id');
                    break;
                }
            }
        });
    }

    // Sincronizar ID de Trabajador
    const inputTrab = document.getElementById('inputBusquedaTrabajador');
    const hiddenTrab = document.getElementById('id_trabajador_fk_hidden');
    const listTrab = document.getElementById('datalistTrabajadores');

    if (inputTrab) {
        inputTrab.addEventListener('input', function () {
            let val = this.value;
            hiddenTrab.value = ''; // Limpiar por si escriben algo inválido
            for (let option of listTrab.options) {
                if (option.value === val) {
                    hiddenTrab.value = option.getAttribute('data-id');
                    break;
                }
            }
        });
    }

    // Validación extra antes de enviar el formulario por si escriben texto manual inexistente
    const formSalida = document.getElementById('formNuevaSalida');
    if (formSalida) {
        formSalida.addEventListener('submit', function(e) {
            if (!hiddenProd.value) {
                alert('Por favor, seleccione un producto válido de la lista sugerida.');
                inputProd.focus();
                e.preventDefault();
            } else if (!hiddenTrab.value) {
                alert('Por favor, seleccione un trabajador válido de la lista sugerida.');
                inputTrab.focus();
                e.preventDefault();
            }
        });
    }
});
</script>

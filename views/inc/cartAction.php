<script>
    // Función para agregar un producto al carrito
    function agregarProducto(productoId, cantidad) {
        $.post('ajax/carritoAjax.php', {
            accion: 'agregar',
            producto_id: productoId,
            cantidad: cantidad
        }, function(response) {
            const data = JSON.parse(response);
            if (data.success) {
                alert('Producto agregado al carrito.');
            } else {
                alert('Error al agregar producto.');
            }
        });
    }

    // Función para eliminar un producto del carrito
    function eliminarProducto(productoId) {
        $.post('ajax/carritoAjax.php', {
            accion: 'eliminar',
            producto_id: productoId
        }, function(response) {
            const data = JSON.parse(response);
            if (data.success) {
                alert('Producto eliminado del carrito.');
                location.reload(); // Recarga la página para actualizar el carrito
            } else {
                alert('Error al eliminar producto.');
            }
        });
    }

    // Función para actualizar la cantidad de un producto en el carrito
    function actualizarCantidad(productoId) {
        const cantidad = prompt('Ingrese la nueva cantidad:');
        if (cantidad) {
            $.post('ajax/carritoAjax.php', {
                accion: 'actualizar',
                producto_id: productoId,
                cantidad: cantidad
            }, function(response) {
                const data = JSON.parse(response);
                if (data.success) {
                    alert('Cantidad actualizada.');
                    location.reload(); // Recarga la página para actualizar el carrito
                } else {
                    alert('Error al actualizar cantidad.');
                }
            });
        }
    }

    // Función para obtener el carrito y mostrarlo en la vista
    function obtenerCarrito() {
        $.post('ajax/carritoAjax.php', {
            accion: 'obtener'
        }, function(response) {
            const data = JSON.parse(response);
            // Aquí puedes actualizar la vista del carrito dinámicamente
        });
    }
</script>
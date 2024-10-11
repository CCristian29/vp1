<script>
    $(document).ready(function() {

        // Eliminar producto del carrito
        $('.eliminar-producto').on('click', function() {
            var idProducto = $(this).data('id');

            $.ajax({
                url: <?= SERVERURL ?>'ajax/carritoAjax.php',
                method: 'POST',
                data: {
                    modulo_carrito: 'eliminar',
                    idProducto: idProducto
                },
                success: function(response) {
                    location.reload(); // Recargar la página para ver los cambios
                },
                error: function() {
                    alert('Error al eliminar el producto');
                }
            });
        });

        // Actualizar cantidad de producto en el carrito
        $('.actualizar-cantidad').on('change', function() {
            var idProducto = $(this).data('id');
            var cantidad = $(this).val();

            $.ajax({
                url: 'ajax/carritoAjax.php',
                method: 'POST',
                data: {
                    modulo_carrito: 'actualizar',
                    idProducto: idProducto,
                    cantidad: cantidad
                },
                success: function(response) {
                    location.reload(); // Recargar la página para ver los cambios
                },
                error: function() {
                    alert('Error al actualizar la cantidad');
                }
            });
        });

        // Finalizar compra
        $('#finalizar-compra').on('click', function() {
            $.ajax({
                url: 'ajax/carritoAjax.php',
                method: 'POST',
                data: {
                    modulo_carrito: 'finalizar'
                },
                success: function(response) {
                    alert('Compra realizada con éxito');
                    location.href = 'finalizar-compra.php'; // Redirige a la página de finalización de compra
                },
                error: function() {
                    alert('Error al finalizar la compra');
                }
            });
        });
    });
</script>
<script>
    document.querySelector(".btn-exit-system").addEventListener('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Quieres salir del sistema?',
            text: "La sesión actual se cerrará y saldrás del sistema",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#FB9001',
            confirmButtonText: 'Salir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                let url = '<?php echo SERVERURL; ?>ajax/loginAjax.php';
                let token = '<?php echo $lc->encryption($_SESSION['token_virtual']); ?>';
                let correo = '<?php echo $lc->encryption($_SESSION['correo_virtual']); ?>';

                let datos = new FormData();
                datos.append("token", token);
                datos.append("correo", correo);

                fetch(url, {
                        method: 'POST',
                        body: datos
                    })
                    .then(response => response.json())
                    .then(response => {
                        if (response.Alerta === "redireccionar") {
                            window.location.href = response.URL;
                        } else {
                            Swal.fire({
                                title: response.Titulo,
                                text: response.Texto,
                                icon: response.Tipo,
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    });
            }
        });
    });
</script>
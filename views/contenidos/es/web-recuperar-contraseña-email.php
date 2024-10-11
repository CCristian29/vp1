<div class="container d-flex justify-content-center align-items-center mt-5 vh-80">
    <div class="row w-100 py-5">
        <div class="col-md-6 offset-md-3">
            <div id="request-email" class="card bg-transparent text-white mb-3">
                <div class="card-header text-center bg-transparent">
                    <h3>Recuperar Contraseña</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= SERVERURL ?>ajax/usuariosAjax.php">
                        <input type="hidden" name="modulo_cliente" value="restablecer_clave">
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <input type="submit" class="btn btn-primary btn-block" value="enviar codigo"></input>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
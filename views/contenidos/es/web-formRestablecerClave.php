<div class="claverest">
    <div class="w-100 ">
        <div class="col-md-7 offset-md-3">
            <div id="request-email" class="card bg-transparent text-white mb-3">
                <div class="card-header text-center bg-transparent">
                    <h3>Recuperar tu contraseña</h3>
                </div>
                <div class="card-body">
                    <form method="post" class="FormularioAjax" action="<?= SERVERURL ?>ajax/usuariosAjax.php">
                        <input type="hidden" name="modulo_cliente" value="restablecer_clave">
                        <div class="form-group">
                            <label for="email">Correo Electrónico:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="ejemplo@email.com" required>
                        </div>
                        <input type="submit" class="btn btn-primary btn-block" value="Enviar Código">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
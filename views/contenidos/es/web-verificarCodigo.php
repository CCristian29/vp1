<div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="row w-100 py-5">
        <div class="col-md-7 offset-md-3">
            <div id="verify-code" class="card bg-transparent text-white mb-3">
                <div class="card-header text-center bg-transparent">
                    <h3>Verificar Código</h3>
                </div>
                <div class="card-body">
                    <form method="post" class="FormularioAjax" action="<?= SERVERURL ?>ajax/usuariosAjax.php">
                        <input type="hidden" name="modulo_cliente" value="verificar_codigo">
                        <div class="form-group">
                            <label for="email">Correo Electrónico:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="ejemplo@email.com" required>
                        </div>
                        <div class="form-group">
                            <label for="code">Código de Verificación:</label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="123456" maxlength="6" required>
                        </div>
                        <input type="submit" class="btn btn-primary btn-block" value="Verificar Código">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
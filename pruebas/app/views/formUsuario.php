<div class="container">
    <div class="row">
        <div class="col">
            <div class="d-flex" style="height: 100vh;">
                <div class="m-auto">
                    <h4>Formulario para crear cuenta</h4>
                    <form action="<?= URL ?>principal/CrearCuenta" method="post" style="width: 500px;">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" minlength="2" maxlength="120" required>
                        </div>
                        <div class="mb-3">
                            <label for="mail" class="form-label">Email:</label>
                            <input type="email" id="mail" name="mail" class="form-control" minlength="8" maxlength="120" required>
                        </div>
                        <div class="mb-3">
                            <label for="clave" class="form-label">Clave:</label>
                            <input type="password" class="form-control" id="clave" name="clave" required>
                        </div>
                        <div class="mb-3">
                            <input type="submit" value="Crear Usuario" class="btn btn-success">
                            <a href="<?= URL ?>" class="ms-3">Iniciar Sesi&oacute;n</a>
                        </div>
                    </form>
                    <div class="alert alert-<?= $alerta ?>" role="alert">
                        <?= $mensaje ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
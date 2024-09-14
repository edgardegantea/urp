<?= $this->extend('template/main') ?>

<?= $this->section('content') ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php if (session()->has('error')): ?>
    <script>
        // Muestra un toast de SweetAlert con el mensaje de error
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?= session('error') ?>',
        });

        // Limpia la sesión después de mostrar el mensaje
        <?php session()->remove('error'); ?>
    </script>
<?php endif; ?>


    <h1><?= ($action == 'crear') ? 'Crear nuevo usuario' : 'Editar información de usuario' ?></h1>

<?php if (session()->has('errors')): ?>
    <ul>
        <?php foreach (session('errors') as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger">
        <?= session('error') ?>
    </div>
<?php endif; ?>

    <form method="post" action="<?= ($action == 'crear') ? '/admin/users' : '/admin/users/' . $user['id'] ?>">

        <?php if ($action == 'editar'): ?>
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>

        <div class="form-group mt-2">
            <label for="nombre_usuario">Nombre de Usuario:</label>
            <input type="text" name="nombre_usuario" class="form-control"
                   value="<?= old('nombre_usuario', $user['nombre_usuario'] ?? '') ?>">
        </div>

        <div class="form-group mt-2">
            <label for="correo_electronico">Correo Electrónico:</label>
            <input class="form-control" type="email" name="correo_electronico"
                   value="<?= old('correo_electronico', $user['correo_electronico'] ?? '') ?>">
        </div>

        <div class="form-group mt-2">
            <label for="contrasena">Contraseña:</label>
            <input class="form-control" type="password" name="contrasena">
        </div>


        <div class="form-group mt-2">
            <label for="confirmar_contrasena">Confirmar Contraseña:</label>
            <input class="form-control" type="password" name="confirmar_contrasena">
        </div>


        <div class="form-group mt-2">
            <label>Seleccione el perfil para el usuario:</label>
        <select name="rol_id" class="form-select">
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role['id'] ?>" <?= (isset($user['rol_id']) && $user['rol_id'] == $role['id']) ? 'selected' : '' ?>>
                    <?= $role['nombre'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        </div>

        <div class="form-group mt-2">
            <button class="btn btn-primary" type="submit"><?= ($action == 'crear') ? 'Crear Usuario' : 'Actualizar Usuario' ?></button>
        </div>
    </form>


<?= $this->endSection() ?>
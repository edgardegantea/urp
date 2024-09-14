<!DOCTYPE html>
<html>
<head>
    <title><?= ($action == 'crear') ? 'Crear Nuevo Rol' : 'Editar Rol' ?></title>
</head>
<body>
<h1><?= ($action == 'crear') ? 'Crear Nuevo Rol' : 'Editar Rol' ?></h1>

<?php if (session()->has('errors')): ?>
    <ul>
        <?php foreach (session('errors') as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" action="<?= ($action == 'crear') ? '/roles' : '/roles/' . $role['id'] ?>">
    <?php if ($action == 'editar'): ?>
        <input type="hidden" name="_method" value="PUT">
    <?php endif; ?>

    <div>
        <label for="nombre">Nombre del Rol:</label>
        <input type="text" name="nombre" value="<?= old('nombre', $role['nombre'] ?? '') ?>">
    </div>


    <div>
        <label for="permissions[]">Permisos:</label>
        <select name="permissions[]" multiple>
            <?php foreach ($permissions as $permission): ?>
                <option value="<?= $permission['id'] ?>"
                    <?php if (in_array($permission['id'], array_column($rolePermissions, 'id'))): ?> selected <?php endif; ?>
                >
                    <?= $permission['nombre'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!--
    <div>
        <label for="permissions[]">Permisos:</label>
        <select name="permissions[]" multiple>
            <?php foreach ($permissions as $permission): ?>
                <option value="<?= $permission['id'] ?>"
                    <?php if (in_array($permission['id'], array_column($rolePermissions, 'id'))): ?> selected <?php endif; ?>
                >
                    <?= $permission['nombre'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    -->

    <div>
        <button type="submit"><?= ($action == 'crear') ? 'Crear Rol' : 'Actualizar Rol' ?></button>
    </div>
</form>
</body>
</html>

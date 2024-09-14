<!DOCTYPE html>
<html>
<head>
    <title>Asignar Permiso a Rol</title>
</head>
<body>
<h1>Asignar Permiso a Rol</h1>

<?php if (session()->has('errors')): ?>
    <ul>
        <?php foreach (session('errors') as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" action="/role_permissions">
    <div>
        <label for="rol_id">Rol:</label>
        <select name="rol_id">
            <option value="">Selecciona un Rol</option>
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role['id'] ?>"><?= $role['nombre'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="permiso_id">Permiso:</label>
        <select name="permiso_id">
            <option value="">Selecciona un Permiso</option>
            <?php foreach ($permissions as $permission): ?>
                <option value="<?= $permission['id'] ?>"><?= $permission['nombre'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <button type="submit">Asignar Permiso</button>
    </div>
</form>
</body>
</html>
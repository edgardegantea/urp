<!DOCTYPE html>
<html>
<head>
    <title>Detalles del Rol</title>
</head>
<body>
<h1>Detalles del Rol</h1>

<p><strong>ID:</strong> <?= $role['id'] ?></p>
<p><strong>Nombre:</strong> <?= $role['nombre'] ?></p>
<p><strong>Creado el:</strong> <?= $role['created_at'] ?></p>
<p><strong>Actualizado el:</strong> <?= $role['updated_at'] ?></p>

<h2>Permisos Asociados</h2>
<ul>
    <?php foreach ($permissions as $permission): ?>
        <li><?= $permission['nombre'] ?></li>
    <?php endforeach; ?>
</ul>

<a href="/roles">Volver a la Lista de Roles</a>
</body>
</html>
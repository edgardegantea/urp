<!DOCTYPE html>
<html>
<head>
    <title>Detalles del Usuario</title>
</head>
<body>
<h1>Detalles del Usuario</h1>

<p><strong>ID:</strong> <?= $user['id'] ?></p>
<p><strong>Nombre de Usuario:</strong> <?= $user['nombre_usuario'] ?></p>
<p><strong>Correo Electrónico:</strong> <?= $user['correo_electronico'] ?></p>
<p><strong>Rol:</strong> <?= $user->role['nombre'] ?? 'Sin Rol' ?></p>
<p><strong>Creado el:</strong> <?= $user['created_at'] ?></p>
<p><strong>Actualizado el:</strong> <?= $user['updated_at'] ?></p>

<a href="/users">Volver a la Lista de Usuarios</a>
</body>
</html>
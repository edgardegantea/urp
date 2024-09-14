<!DOCTYPE html>
<html>
<head>
    <title>Relaciones Rol-Permiso</title>
</head>
<body>
<h1>Relaciones Rol-Permiso</h1>

<a href="/role_permissions/create">Asignar Permiso a Rol</a>

<table>
    <thead>
    <tr>
        <th>Rol</th>
        <th>Permiso</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($rolePermissions as $rolePermission): ?>
        <tr>
            <td><?= $rolePermission->role->nombre ?></td>
            <td><?= $rolePermission->permission->nombre ?></td>
            <td>
                <a href="/role_permissions/delete/<?= $rolePermission->rol_id . '/' . $rolePermission->permiso_id ?>" onclick="return confirm('¿Estás seguro de eliminar esta relación?')">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
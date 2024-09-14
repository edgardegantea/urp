<?= $this->extend('template/main'); ?>

<?= $this->section('content'); ?>

<h1>Permisos</h1>

<a href="/admin/permissions/create">Crear Nuevo Permiso</a>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($permissions as $permission): ?>
        <tr>
            <td><?= $permission['id'] ?></td>
            <td><?= $permission['nombre'] ?></td>
            <td>
                <a href="/admin/permissions/<?= $permission['id'] ?>">Ver</a>
                <a href="/admin/permissions/edit/<?= $permission['id'] ?>">Editar</a>
                <a href="/admin/permissions/delete/<?= $permission['id'] ?>" onclick="return confirm('¿Estás seguro de eliminar este permiso?')">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<?= $this->endSection(); ?>
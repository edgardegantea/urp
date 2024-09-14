<?= $this->extend('template/main'); ?>

<?= $this->section('content'); ?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<h1>Roles</h1>

<a href="/admin/roles/create">Crear Nuevo Rol</a>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($roles as $role): ?>
        <tr>
            <td><?= $role['id'] ?></td>
            <td><?= $role['nombre'] ?></td>
            <td>
                <a href="/admin/roles/<?= $role['id'] ?>">Ver</a>
                <a href="/admin/roles/edit/<?= $role['id'] ?>">Editar</a>
                <form method="post" action="/admin/roles/<?= $role['id'] ?>" style="display: inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este rol?')">Eliminar</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<?= $this->endSection(); ?>
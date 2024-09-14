<?= $this->extend('template/main'); ?>

<?= $this->section('content'); ?>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div class="col-md-4 d-flex align-items-center">
                <h3>Usuarios</h3>
            </div>

            <div class="nav col-md-4 justify-content-end list-unstyled d-flex">
                <a class="btn btn-primary btn-sm mb-2" href="/admin/users/create">Registrar Usuario</a>
            </div>
        </div>
    </div>


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

    <table id="example" class="display" style="width:100%" class="table table-justify table-bordered table-hovered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre de Usuario</th>
            <th>Correo Electrónico</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['nombre_usuario'] ?></td>
                <td><?= $user['correo_electronico'] ?></td>
                <td><?= $user['rol'] ?? 'Sin Rol' ?></td>
                <td>
                    <a href="/admin/users/<?= $user['id'] ?>"><i class="bi bi-eye"></i></a>
                    <a href="/admin/users/edit/<?= $user['id'] ?>"><i class="bi bi-pencil-square"></i></a>


                    <form method="post" action="/admin/users/<?= $user['id'] ?>" style="display: inline;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="delete_type" value="hard">
                        <a onclick="return confirm('¿Estás seguro de eliminar este usuario permanentemente?')">
                            <i class="bi bi-trash text-danger mr-2"></i>
                        </a>
                    </form>


                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>


<?= $this->endSection(); ?>
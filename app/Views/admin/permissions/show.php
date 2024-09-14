<?= $this->extend('template/main'); ?>

<?= $this->section('content'); ?>

<h1>Detalles del Permiso</h1>

<p><strong>ID:</strong> <?= $permission['id'] ?></p>
<p><strong>Nombre:</strong> <?= $permission['nombre'] ?></p>
<p><strong>Creado el:</strong> <?= $permission['created_at'] ?></p>
<p><strong>Actualizado el:</strong> <?= $permission['updated_at'] ?></p>

<a href="/admin/permissions">Volver a la Lista de Permisos</a>


<?= $this->endSection(); ?>
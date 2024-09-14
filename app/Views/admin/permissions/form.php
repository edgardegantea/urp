<?= $this->extend('template/main'); ?>

<?= $this->section('content'); ?>

<h1><?= ($action == 'crear') ? 'Crear Nuevo Permiso' : 'Editar Permiso' ?></h1>

<?php if (session()->has('errors')): ?>
    <ul>
        <?php foreach (session('errors') as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" action="<?= ($action == 'crear') ? '/admin/permissions' : '/admin/permissions/' . $permission['id'] ?>">
    <?php if ($action == 'editar'): ?>
        <input type="hidden" name="_method" value="PUT">
    <?php endif; ?>

    <div>
        <label for="nombre">Nombre del Permiso:</label>
        <input type="text" name="nombre" value="<?= old('nombre', $permission['nombre'] ?? '') ?>">
    </div>

    <div>
        <button type="submit"><?= ($action == 'crear') ? 'Crear Permiso' : 'Actualizar Permiso' ?></button>
    </div>
</form>

<?= $this->endSection(); ?>
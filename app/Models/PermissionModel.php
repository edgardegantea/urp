<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionModel extends Model
{
    protected $table = 'permisos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $dateFormat = 'datetime';

    // Relación con la tabla 'roles' (un permiso puede pertenecer a muchos roles a través de la tabla pivote)
    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, 'roles_permisos', 'permiso_id', 'rol_id');
    }
}

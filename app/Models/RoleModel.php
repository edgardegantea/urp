<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $dateFormat = 'datetime';

    // Relación con la tabla 'usuarios' (un rol puede tener muchos usuarios)
    public function users()
    {
        return $this->hasMany(UserModel::class, 'rol_id');
    }

    // Relación con la tabla 'permisos' (un rol puede tener muchos permisos a través de la tabla pivote)
    public function permissions()
    {
        return $this->belongsToMany(PermissionModel::class, 'roles_permisos', 'rol_id', 'permiso_id');
    }

}

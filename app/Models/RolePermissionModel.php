<?php

namespace App\Models;

use CodeIgniter\Model;

class RolePermissionModel extends Model
{
    protected $table = 'roles_permisos';
    protected $primaryKey = ['rol_id', 'permiso_id']; // Clave primaria compuesta
    protected $allowedFields = ['rol_id', 'permiso_id'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $dateFormat = 'datetime';
}

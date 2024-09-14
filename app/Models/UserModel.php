<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    public $allowedFields
        = ['nombre_usuario', 'correo_electronico', 'contrasena',
            'rol_id'];
    protected $useTimestamps = true; // Habilita timestamps automáticos
    protected $useSoftDeletes = true; // Habilita borrado lógico
    protected $dateFormat = 'datetime'; // Formato de fecha y hora

    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'rol_id');
    }

}

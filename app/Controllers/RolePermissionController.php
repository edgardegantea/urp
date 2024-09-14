<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RoleModel;
use App\Models\RolePermissionModel;
use App\Models\PermissionModel;

class RolePermissionController extends BaseController
{
    protected $rolePermissionModel;
    protected $roleModel;
    protected $permissionModel;
    protected $validation;

    public function __construct()
    {
        $this->rolePermissionModel = new RolePermissionModel();
        $this->roleModel = new RoleModel();
        $this->permissionModel = new PermissionModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data['rolePermissions'] = $this->rolePermissionModel->findAll();
        // Puedes obtener los nombres de roles y permisos para mostrarlos en la vista
        // $data['roles'] = $this->roleModel->findAll();
        // $data['permissions'] = $this->permissionModel->findAll();

        return view('role_permissions/index', $data);
    }

    public function create()
    {
        $data['roles'] = $this->roleModel->findAll();
        $data['permissions'] = $this->permissionModel->findAll();

        return view('role_permissions/create', $data);
    }

    public function store()
    {
        $rules = [
            'rol_id' => 'required|integer',
            'permiso_id' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $data = $this->request->getPost();

        if ($this->rolePermissionModel->insert($data)) {
            return redirect()->to('/role_permissions')->with('success', 'Relación Rol-Permiso creada exitosamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->rolePermissionModel->errors());
        }
    }
}

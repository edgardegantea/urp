<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PermissionModel;
use App\Models\RoleModel;

class RoleController extends BaseController
{
    protected $roleModel;
    protected $permissionModel;
    protected $validation;

    public function __construct()
    {
        $this->roleModel = new RoleModel();
        $this->permissionModel = new PermissionModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data['roles'] = $this->roleModel->findAll();

        return view('admin/roles/index', $data);
    }

    public function create()
    {
        $permissionModel = new PermissionModel();
        $data['permissions'] = $permissionModel->findAll();
        $data['action'] = 'crear';
        $data['rolePermissions'] = [];

        return view('admin/roles/form', $data);
    }

    public function store()
    {
        $rules = [
            'nombre' => 'required|min_length[3]|max_length[255]|is_unique[roles.nombre]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $data = $this->request->getPost();

        if ($this->roleModel->insert($data)) {
            $roleId = $this->roleModel->getInsertID();

            // Guardar permisos asociados al rol
            if (isset($data['permissions'])) {
                $this->roleModel->permissions()->sync($data['permissions']);
            }

            return redirect()->to('/admin/roles')->with('success', 'Rol creado exitosamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->roleModel->errors());
        }
    }

    public function show($id)
    {
        $data['role'] = $this->roleModel->find($id);

        if (!$data['role']) {
            return redirect()->to('/admin/roles')->with('error', 'Rol no encontrado');
        }

        // Convertir el array $role en un objeto de entidad
        $data['role'] = $this->roleModel->toEntity($data['role']);

        // Obtener los permisos asociados al rol
        $data['permissions'] = $data['role']->permissions;

        return view('admin/roles/show', $data);
    }

    public function edit($id)
    {
        $roleModel = new RoleModel();
        $data['role'] = $roleModel->find($id);
        $permissionModel = new PermissionModel();
        $data['permissions'] = $permissionModel->findAll();
        $data['action'] = 'editar';

        // Obtener los permisos actuales del rol (¡Esta es la línea clave!)
        $data['rolePermissions'] = $data['role']->permissions()->findAll(); // Asegúrate de que la relación 'permissions' esté definida en tu modelo RoleModel

        if (!$data['role']) {
            return redirect()->to('/admin/roles')->with('error', 'Rol no encontrado');
        }

        return view('roles/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'nombre' => 'required|min_length[3]|max_length[255]|is_unique[roles.nombre,id,' . $id . ']',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $data = $this->request->getPost();

        if ($this->roleModel->update($id, $data)) {
            // Actualizar permisos asociados al rol
            if (isset($data['permissions'])) {
                $this->roleModel->permissions()->sync($data['permissions']);
            }

            return redirect()->to('/admin/roles')->with('success', 'Rol actualizado exitosamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->roleModel->errors());
        }
    }

    public function delete($id)
    {
        $this->roleModel->delete($id);

        return redirect()->to('/admin/roles')->with('success', 'Rol eliminado exitosamente');
    }
}

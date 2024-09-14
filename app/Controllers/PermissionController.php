<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PermissionModel;

class PermissionController extends BaseController
{
    protected $permissionModel;
    protected $validation;

    public function __construct()
    {
        $this->permissionModel = new PermissionModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data['permissions'] = $this->permissionModel->findAll();

        return view('admin/permissions/index', $data);
    }

    public function create()
    {
        $data['action'] = 'crear';

        return view('admin/permissions/form', $data);
    }

    public function store()
    {
        $rules = [
            'nombre' => 'required|min_length[3]|max_length[255]|is_unique[permisos.nombre]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $data = $this->request->getPost();

        if ($this->permissionModel->insert($data)) {
            return redirect()->to('/admin/permissions')->with('success', 'Permiso creado exitosamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->permissionModel->errors());
        }
    }

    public function show($id)
    {
        $data['permission'] = $this->permissionModel->find($id);

        if (!$data['permission']) {
            return redirect()->to('/admin/permissions')->with('error', 'Permiso no encontrado');
        }

        return view('admin/permissions/show', $data);
    }

    public function edit($id)
    {
        $data['permission'] = $this->permissionModel->find($id);
        $data['action'] = 'editar';

        if (!$data['permission']) {
            return redirect()->to('/admin/permissions')->with('error', 'Permiso no encontrado');
        }

        return view('admin/permissions/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'nombre' => 'required|min_length[3]|max_length[255]|is_unique[permisos.nombre,id,' . $id . ']',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $data = $this->request->getPost();

        if ($this->permissionModel->update($id, $data)) {
            return redirect()->to('/admin/permissions')->with('success', 'Permiso actualizado exitosamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->permissionModel->errors());
        }
    }

    public function delete($id)
    {
        $this->permissionModel->delete($id);

        return redirect()->to('/admin/permissions')->with('success', 'Permiso eliminado exitosamente');
    }
}

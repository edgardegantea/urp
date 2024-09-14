<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\RoleModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $roleModel;
    protected $validation;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data['users'] = $this->userModel->select('usuarios.*, roles.nombre as rol')->withDeleted()->join('roles', 'roles.id = usuarios.rol_id')->findAll();

        return view('admin/users/index', $data);
    }

    public function create()
    {
        $data['roles'] = $this->roleModel->findAll();
        $data['action'] = 'crear';
        $data['rolePermissions'] = [];
        $data['user'] = []; // Inicializar $user como un array vacío

        return view('admin/users/form', $data);
    }

    public function store()
    {
        $rules = [
            'nombre_usuario' => 'required|min_length[3]|max_length[255]|is_unique[usuarios.nombre_usuario]',
            'correo_electronico' => 'required|valid_email|is_unique[usuarios.correo_electronico]',
            'contrasena' => 'required|min_length[6]',
            'confirmar_contrasena' => 'required|matches[contrasena]',
            'rol_id' => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $data = $this->request->getPost();

        // Verificar si el correo electrónico ya existe
        $existingUser = $this->userModel->where('correo_electronico', $data['correo_electronico'])->first();
        if ($existingUser) {
            return redirect()->back()->withInput()->with('error', 'El correo electrónico ya está en uso.');
        }

        // Verificar si el nombre de usuario ya existe
        $existingUser = $this->userModel->where('nombre_usuario', $data['nombre_usuario'])->first();
        if ($existingUser) {
            return redirect()->back()->withInput()->with('error', 'El nombre de usuario ya está en uso.');
        }

        $data['contrasena'] = password_hash($data['contrasena'], PASSWORD_DEFAULT);

        if ($this->userModel->insert($data)) {
            return redirect()->to('/admin/users')->with('success', 'Usuario creado exitosamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }
    }

    public function show($id)
    {
        $data['user'] = $this->userModel->find($id);

        if (!$data['user']) {
            return redirect()->to('/admin/users')->with('error', 'Usuario no encontrado');
        }

        // Convertir el array $user en un objeto de entidad
        $data['user'] = $this->userModel->toEntity($data['user']);

        return view('admin/users/show', $data);
    }

    public function edit($id)
    {
        $data['user'] = $this->userModel->find($id);
        $data['roles'] = $this->roleModel->findAll();
        $data['action'] = 'editar';

        if (!$data['user']) {
            return redirect()->to('/admin/users')->with('error', 'Usuario no encontrado');
        }

        return view('admin/users/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'nombre_usuario' => 'required|min_length[3]|max_length[255]|is_unique[usuarios.nombre_usuario,id,' . $id . ']',
            'correo_electronico' => 'required|valid_email|is_unique[usuarios.correo_electronico,id,' . $id . ']',
            'rol_id' => 'required|integer'
        ];

        // Solo validar la contraseña si se proporciona
        if ($this->request->getPost('contrasena')) {
            $rules['contrasena'] = 'required|min_length[6]';
            $rules['confirmar_contrasena'] = 'required|matches[contrasena]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $data = $this->request->getPost();

        // Verificar si el correo electrónico ya existe en otro usuario
        $existingUser = $this->userModel->where('correo_electronico', $data['correo_electronico'])->first();
        if ($existingUser && $existingUser['id'] != $id) {
            return redirect()->back()->withInput()->with('error', 'El correo electrónico ya está en uso por otro usuario.');
        }

        // Verificar si el nombre de usuario ya existe en otro usuario
        $existingUser = $this->userModel->where('nombre_usuario', $data['nombre_usuario'])->first();
        if ($existingUser && $existingUser['id'] != $id) {
            return redirect()->back()->withInput()->with('error', 'El nombre de usuario ya está en uso por otro usuario.');
        }

        // Hashear la contraseña solo si se proporciona
        if ($this->request->getPost('contrasena')) {
            $data['contrasena'] = password_hash($data['contrasena'], PASSWORD_DEFAULT);
        }

        if ($this->userModel->update($id, $data)) {
            return redirect()->to('/admin/users')->with('success', 'Usuario actualizado exitosamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }
    }


    public function delete($id)
    {
        // Verificar si el usuario existe, incluyendo los eliminados lógicamente
        $user = $this->userModel->withDeleted()->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Usuario no encontrado');
        }

        // Obtener el tipo de eliminación desde la solicitud
        $deleteType = $this->request->getPost('delete_type');

        if ($deleteType == 'soft') {
            // Borrado lógico (soft delete)
            if ($this->userModel->delete($id)) { // $purge = false por defecto
                return redirect()->to('/admin/users')->with('success', 'Usuario eliminado (borrado lógico)');
            } else {
                return redirect()->to('/admin/users')->with('error', 'Error al eliminar el usuario (borrado lógico)');
            }
        } else if ($deleteType == 'hard') {
            // Borrado permanente (hard delete)
            if ($this->userModel->delete($id, true)) { // $purge = true para borrado permanente
                return redirect()->to('/admin/users')->with('success', 'Usuario eliminado permanentemente');
            } else {
                return redirect()->to('/admin/users')->with('error', 'Error al eliminar el usuario permanentemente');
            }
        } else {
            // Tipo de eliminación no válido
            return redirect()->to('/admin/users')->with('error', 'Tipo de eliminación no válido');
        }
    }


    public function restore($id)
    {
        // Verificar si el usuario existe, incluyendo los eliminados lógicamente
        $user = $this->userModel->withDeleted()->find($id);

        if (!$user) {
            return redirect()->to('/users')->with('error', 'Usuario no encontrado');
        }

        // Verificar si el usuario está eliminado lógicamente (tiene un valor en deleted_at)
        if ($user['deleted_at'] === null) {
            return redirect()->to('/users')->with('error', 'El usuario no está eliminado');
        }

        // Excluir temporalmente el campo updated_at de los campos permitidos
        $allowedFieldsOriginal = $this->userModel->allowedFields;
        $updatedField = $this->userModel->updatedField;
        if ($updatedField && in_array($updatedField, $allowedFieldsOriginal)) {
            $this->userModel->allowedFields = array_diff($allowedFieldsOriginal, [$updatedField]);
        }

        // Restaurar el usuario (establecer deleted_at a null)
        if ($this->userModel->update($id, ['deleted_at' => null])) {

            // Restaurar los campos permitidos originales
            $this->userModel->allowedFields = $allowedFieldsOriginal;

            return redirect()->to('/users')->with('success', 'Usuario restaurado exitosamente');
        } else {
            // Restaurar los campos permitidos originales incluso si la actualización falla
            $this->userModel->allowedFields = $allowedFieldsOriginal;

            return redirect()->to('/users')->with('error', 'Error al restaurar el usuario');
        }
    }
}

<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\AuditLog;

class UserController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth');
        }

        $this->checkModuleAccess('users');
        $this->userModel = new User();
    }

    public function index()
    {
        $search = $_GET['search'] ?? null;

        if ($search) {
            $users = $this->userModel->searchWithRoles($search);
        } else {
            $users = $this->userModel->getAllWithRoles();
        }

        $roleModel = new Role();
        $roles = $roleModel->all();

        $permModel = new Permission();
        $modules = $permModel->getModules();
        $modulePermissions = [];
        foreach ($modules as $mod) {
            $modulePermissions[$mod->module] = $permModel->getByModule($mod->module);
        }

        return $this->view('admin/users/index', [
            'title' => 'User Management',
            'users' => $users,
            'roles' => $roles,
            'modules' => $modules,
            'modulePermissions' => $modulePermissions
        ]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($password) || strlen($password) < 6) {
                $_SESSION['error'] = 'Password must be at least 6 characters.';
                return $this->redirect('admin/users');
            }

            if ($password !== $confirmPassword) {
                $_SESSION['error'] = 'Passwords do not match.';
                return $this->redirect('admin/users');
            }

            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role_id' => !empty($_POST['role_id']) ? $_POST['role_id'] : null,
                'status' => $_POST['status'] ?? 'active'
            ];

            if ($this->userModel->create($data)) {
                $userId = $this->userModel->lastInsertId();
                $permModel = new Permission();
                $permModel->removeAllFromUser($userId);
                if (!empty($_POST['permissions'])) {
                    foreach ($_POST['permissions'] as $permId) {
                        $permModel->assignToUser($permId, $userId);
                    }
                }
                $_SESSION['success'] = 'User added successfully.';
            } else {
                $_SESSION['error'] = 'Failed to add user.';
            }
        }
        return $this->redirect('admin/users');
    }

    public function get($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            json_response(['status' => 'error', 'message' => 'User not found']);
            exit;
        }

        $roleModel = new Role();
        $role = $roleModel->find($user->role_id);
        $user->role_name = $role ? $role->name : '';

        $permModel = new Permission();
        if ($user->role_id == 1) {
            $allPerms = $permModel->all();
            $user->permission_ids = array_map(function($p) { return $p->id; }, $allPerms);
        } else {
            $userPerms = $permModel->getUserPermissions($user->id);
            $user->permission_ids = array_map(function($p) { return $p->id; }, $userPerms);
        }

        json_response(['status' => 'success', 'data' => $user]);
        exit;
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get old data for audit log
            $oldUser = $this->userModel->find($id);
            $permModel = new Permission();
            $oldPermissions = $permModel->getUserPermissions($oldUser->id);
            
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'role_id' => !empty($_POST['role_id']) ? $_POST['role_id'] : null,
                'status' => $_POST['status'] ?? 'active'
            ];

            $password = $_POST['password'] ?? '';
            if (!empty($password)) {
                if (strlen($password) < 6) {
                    $_SESSION['error'] = 'Password must be at least 6 characters.';
                    return $this->redirect('admin/users');
                }
                $data['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            if ($this->userModel->update($id, $data)) {
                $permModel->removeAllFromUser($oldUser->id);
                $newPermissions = [];
                if (!empty($_POST['permissions'])) {
                    foreach ($_POST['permissions'] as $permId) {
                        $permModel->assignToUser($permId, $oldUser->id);
                    }
                    $newPermissions = $_POST['permissions'];
                }
                
                // Log the update with detailed changes
                $oldData = [
                    'name' => $oldUser->name,
                    'email' => $oldUser->email,
                    'role_id' => $oldUser->role_id,
                    'status' => $oldUser->status,
                    'permissions' => array_map(function($p) { return $p->id; }, $oldPermissions),
                    'password_changed' => false
                ];
                
                $newData = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'role_id' => $data['role_id'],
                    'status' => $data['status'],
                    'permissions' => $newPermissions,
                    'password_changed' => !empty($password)
                ];
                
                AuditLog::log('update', 'users', $oldUser->id, $oldData, $newData);
                
                $_SESSION['success'] = 'User updated successfully.';
            } else {
                $_SESSION['error'] = 'Failed to update user.';
            }
        }
        return $this->redirect('admin/users');
    }

    public function delete($id)
    {
        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = 'You cannot delete your own account.';
            return $this->redirect('admin/users');
        }

        // Get user data before deletion for audit log
        $user = $this->userModel->find($id);
        $permModel = new Permission();
        $userPermissions = $permModel->getUserPermissions($user->id);
        
        $oldData = [
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => $user->role_id,
            'status' => $user->status,
            'permissions' => array_map(function($p) { return $p->id; }, $userPermissions)
        ];

        if ($this->userModel->delete($id)) {
            // Log the deletion
            AuditLog::log('delete', 'users', $user->id, $oldData, null);
            
            $_SESSION['success'] = 'User deleted successfully.';
        } else {
            $_SESSION['error'] = 'Failed to delete user.';
        }
        return $this->redirect('admin/users');
    }

    public function storeRole()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            if (!empty($name)) {
                $roleModel = new Role();
                $roleModel->create(['name' => $name]);
                $roleId = $roleModel->lastInsertId();
                
                // Log role creation
                AuditLog::log('create', 'roles', $roleId, null, ['name' => $name]);
                
                $_SESSION['success'] = 'Role added successfully.';
            } else {
                $_SESSION['error'] = 'Please enter a role name.';
            }
        }
        return $this->redirect('admin/users#modal-add-role');
    }

    public function deleteRole($id)
    {
        $roleModel = new Role();
        $role = $roleModel->find($id);
        if ($role && strtolower($role->name) !== 'super admin') {
            // Log role deletion
            AuditLog::log('delete', 'roles', $id, ['name' => $role->name], null);
            
            $roleModel->delete($id);
            $_SESSION['success'] = 'Role deleted successfully.';
        } else {
            $_SESSION['error'] = 'Cannot delete the Super Admin role.';
        }
        return $this->redirect('admin/users#modal-add-role');
    }

    public function toggleStatus($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            $_SESSION['error'] = 'User not found.';
            return $this->redirect('admin/users');
        }

        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = 'You cannot change your own status.';
            return $this->redirect('admin/users');
        }

        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        
        // Log status change
        AuditLog::log(
            'status_change',
            'users',
            $id,
            ['status' => $user->status, 'name' => $user->name, 'email' => $user->email],
            ['status' => $newStatus, 'name' => $user->name, 'email' => $user->email]
        );
        
        if ($this->userModel->update($id, ['status' => $newStatus])) {
            $_SESSION['success'] = "User status changed to {$newStatus}.";
        } else {
            $_SESSION['error'] = 'Failed to update user status.';
        }
        return $this->redirect('admin/users');
    }
}

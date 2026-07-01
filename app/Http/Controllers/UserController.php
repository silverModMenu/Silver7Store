<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Listar todos os usuários
     */
    public function index(Request $request)
    {
        $users = User::paginate(15);
        return view('users.index', compact('users'));
    }

    /**
     * Mostrar formulário de criação
     */
    public function create()
    {
        $roles = [
            User::ROLE_ADMIN => 'Administrador',
            User::ROLE_MANAGER => 'Gerenciador',
            User::ROLE_USER => 'Usuário',
        ];
        return view('users.create', compact('roles'));
    }

    /**
     * Armazenar novo usuário
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,manager,user',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
            'must_change_password' => true,
        ]);

        // Log de auditoria
        AuditLog::log(
            auth()->id(),
            AuditLog::ACTION_USER_CREATE,
            "Novo usuário criado: {$user->name}",
            'User',
            $user->id,
            null,
            $user->toArray()
        );

        return redirect()->route('users.index')
            ->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Mostrar formulário de edição
     */
    public function edit(User $user)
    {
        $roles = [
            User::ROLE_ADMIN => 'Administrador',
            User::ROLE_MANAGER => 'Gerenciador',
            User::ROLE_USER => 'Usuário',
        ];
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Atualizar usuário
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,manager,user',
            'is_active' => 'boolean',
        ]);

        $oldValues = $user->toArray();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ]);

        // Log de auditoria
        AuditLog::log(
            auth()->id(),
            AuditLog::ACTION_USER_UPDATE,
            "Usuário atualizado: {$user->name}",
            'User',
            $user->id,
            $oldValues,
            $user->toArray()
        );

        return redirect()->route('users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Deletar usuário
     */
    public function destroy(User $user)
    {
        // Proteção: não permitir deletar Super Admin
        if ($user->role === User::ROLE_SUPER_ADMIN) {
            return back()->with('error', 'Não é possível deletar o Super Administrador.');
        }

        $userData = $user->toArray();
        $user->delete();

        // Log de auditoria
        AuditLog::log(
            auth()->id(),
            AuditLog::ACTION_USER_DELETE,
            "Usuário deletado: {$user->name}",
            'User',
            $user->id,
            $userData,
            null
        );

        return redirect()->route('users.index')
            ->with('success', 'Usuário deletado com sucesso!');
    }

    /**
     * Resetar senha de um usuário
     */
    public function resetPassword(Request $request, User $user)
    {
        $temporaryPassword = bin2hex(random_bytes(4));

        $user->update([
            'password' => Hash::make($temporaryPassword),
            'must_change_password' => true,
        ]);

        // Log de auditoria
        AuditLog::log(
            auth()->id(),
            AuditLog::ACTION_PASSWORD_CHANGE,
            "Senha resetada para usuário: {$user->name}",
            'User',
            $user->id
        );

        return back()->with('success', "Senha resetada! Temporária: {$temporaryPassword}");
    }
}

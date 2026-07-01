<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário - Silver7Store</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar h1 {
            font-size: 24px;
        }

        .navbar-right {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .navbar-right a,
        .navbar-right form {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .navbar-right button {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid white;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }

        .navbar-right button:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .header {
            margin-bottom: 30px;
        }

        .header h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        .section {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
            font-family: inherit;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        input[type="checkbox"] {
            width: auto;
            margin-right: 8px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
        }

        .error-message {
            background-color: #fee;
            border: 1px solid #fcc;
            color: #c00;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .error-text {
            color: #dc3545;
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }

        .info-box {
            background: #f0f4ff;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 13px;
            color: #333;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
        }

        .btn-cancel:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.4);
        }

        .user-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .user-info p {
            margin: 5px 0;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            background: #d1ecf1;
            color: #0c5460;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>🛍️ Silver7Store</h1>
        <div class="navbar-right">
            <span>Bem-vindo, <strong>{{ auth()->user()->name }}</strong></span>
            <a href="{{ route('users.index') }}">Usuários</a>
            <form action="{{ route('auth.logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit">Sair</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h2>✏️ Editar Usuário</h2>
            <p>Atualize as informações do usuário</p>
        </div>

        <div class="section">
            <div class="user-info">
                <p><strong>Usuário:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Função:</strong> <span class="badge">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span></p>
                <p><strong>Criado em:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                @if($user->last_login_at)
                    <p><strong>Último login:</strong> {{ $user->last_login_at->format('d/m/Y H:i') }}</p>
                @endif
            </div>

            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nome Completo</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role">Função</label>
                    <select id="role" name="role" required>
                        @foreach($roles as $value => $label)
                            <option value="{{ $value }}" {{ old('role', $user->role) == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_active" name="is_active" value="1" 
                               {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                        <label for="is_active" style="margin: 0; font-weight: normal;">Usuário Ativo</label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">✓ Salvar Alterações</button>
                    <a href="{{ route('users.index') }}" class="btn btn-cancel" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

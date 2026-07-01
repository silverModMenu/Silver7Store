<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs de Auditoria - Silver7Store</title>
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h2 {
            font-size: 28px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            color: #666;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
        }

        table tbody tr:hover {
            background: #f8f9fa;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-login {
            background: #d4edda;
            color: #155724;
        }

        .badge-logout {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge-create {
            background: #cfe2ff;
            color: #084298;
        }

        .badge-update {
            background: #fff3cd;
            color: #664d03;
        }

        .badge-delete {
            background: #f8d7da;
            color: #842029;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #999;
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

        .pagination {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #667eea;
            font-size: 13px;
        }

        .pagination a:hover {
            background: #f0f4ff;
        }

        .pagination .active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .pagination .disabled {
            color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>🛍️ Silver7Store</h1>
        <div class="navbar-right">
            <span>Bem-vindo, <strong>{{ auth()->user()->name }}</strong></span>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('users.index') }}">Usuários</a>
            <form action="{{ route('auth.logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit">Sair</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h2>📋 Logs de Auditoria</h2>
            <a href="{{ route('audit-logs.export') }}" class="btn">📥 Exportar CSV</a>
        </div>

        <div class="info-box">
            ℹ️ Todos os acessos, ações e alterações do sistema são registrados aqui para fins de auditoria e segurança.
        </div>

        <div class="section">
            @if($logs->count() > 0)
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Data/Hora</th>
                                <th>Usuário</th>
                                <th>Ação</th>
                                <th>Descrição</th>
                                <th>IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>{{ $log->timestamp->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $log->user?->name ?? 'Sistema' }}</td>
                                    <td>
                                        @php
                                            $actionBadgeClass = 'badge-login';
                                            if (strpos($log->action, 'logout') !== false) {
                                                $actionBadgeClass = 'badge-logout';
                                            } elseif (strpos($log->action, 'create') !== false) {
                                                $actionBadgeClass = 'badge-create';
                                            } elseif (strpos($log->action, 'update') !== false) {
                                                $actionBadgeClass = 'badge-update';
                                            } elseif (strpos($log->action, 'delete') !== false) {
                                                $actionBadgeClass = 'badge-delete';
                                            }
                                        @endphp
                                        <span class="badge {{ $actionBadgeClass }}">{{ ucfirst(str_replace('_', ' ', $log->action)) }}</span>
                                    </td>
                                    <td>{{ $log->description ?? '-' }}</td>
                                    <td><code style="background: #f0f0f0; padding: 2px 6px; border-radius: 3px; font-size: 11px;">{{ $log->ip_address ?? 'N/A' }}</code></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    {{ $logs->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div class="no-data">
                    Nenhum log de auditoria encontrado.
                </div>
            @endif
        </div>
    </div>
</body>
</html>

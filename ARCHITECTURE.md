# 🏗️ Arquitetura do Sistema - Silver7Store

## Visão Geral

Silver7Store é uma aplicação monolítica construída com Laravel 10, seguindo padrões MVC (Model-View-Controller).

```
┌─────────────────────────────────────────────────────────┐
│                    Browser/Cliente                       │
└────────────────────────┬────────────────────────────────┘
                         │
                         ↓
┌─────────────────────────────────────────────────────────┐
│                   Nginx/Apache                           │
│            (Web Server - Proxy Reverso)                 │
└────────────────────────┬────────────────────────────────┘
                         │
                         ↓
┌─────────────────────────────────────────────────────────┐
│            Laravel Application (10.x)                    │
│  ┌──────────────────────────────────────────────────┐  │
│  │  Routing (routes/web.php)                        │  │
│  │    └─ Auth Routes                                │  │
│  │    └─ Dashboard Routes                           │  │
│  │    └─ Users Routes                               │  │
│  │    └─ Audit Routes                               │  │
│  └──────────────────────────────────────────────────┘  │
│  ┌──────────────────────────────────────────────────┐  │
│  │  Middleware Stack                                 │  │
│  │    └─ Authenticate                               │  │
│  │    └─ CheckRole                                  │  │
│  │    └─ CheckPermission                            │  │
│  └──────────────────────────────────────────────────┘  │
│  ┌──────────────────────────────────────────────────┐  │
│  │  Controllers                                      │  │
│  │    ├─ AuthController                             │  │
│  │    ├─ DashboardController                        │  │
│  │    └─ UserController                             │  │
│  └──────────────────────────────────────────────────┘  │
│  ┌──────────────────────────────────────────────────┐  │
│  │  Models (Eloquent ORM)                           │  │
│  │    ├─ User                                       │  │
│  │    ├─ Permission                                 │  │
│  │    └─ AuditLog                                   │  │
│  └──────────────────────────────────────────────────┘  │
│  ┌──────────────────────────────────────────────────┐  │
│  │  Views (Blade Templates)                         │  │
│  │    ├─ auth/login.blade.php                       │  │
│  │    ├─ auth/change-password.blade.php             │  │
│  │    ├─ dashboard.blade.php                        │  │
│  │    ├─ audit-logs.blade.php                       │  │
│  │    └─ users/                                     │  │
│  └──────────────────────────────────────────────────┘  │
└────────────────────────┬────────────────────────────────┘
                         │
                         ↓
┌─────────────────────────────────────────────────────────┐
│              MySQL Database                             │
│  ┌──────────────────────────────────────────────────┐  │
│  │  Tables                                          │  │
│  │    ├─ users                                      │  │
│  │    ├─ permissions                                │  │
│  │    ├─ user_permissions                           │  │
│  │    └─ audit_logs                                 │  │
│  └──────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────┘
```

---

## Estrutura de Camadas

### 1️⃣ Camada de Apresentação (Views)
- Templates Blade em `resources/views/`
- HTML/CSS/JavaScript
- Validação client-side
- Responsividade

### 2️⃣ Camada de Roteamento
- Definição de rotas em `routes/web.php`
- Grupos de rotas com middleware
- Proteção de rotas

### 3️⃣ Camada de Middleware
- Autenticação
- Verificação de papéis
- Verificação de permissões

### 4️⃣ Camada de Controladores
- Lógica de negócio
- Processamento de requisições
- Retorno de respostas

### 5️⃣ Camada de Modelos
- Interação com banco de dados
- Relacionamentos Eloquent
- Validação de dados

### 6️⃣ Camada de Banco de Dados
- Tabelas MySQL
- Índices
- Relacionamentos

---

## Fluxo de Requisição

```
1. Usuário acessa URL
        ↓
2. Nginx/Apache recebe requisição
        ↓
3. Laravel boot (bootstrap)
        ↓
4. Roteador encontra rota correspondente
        ↓
5. Middleware processa (Authenticate, CheckRole, etc)
        ↓
6. Controller processa lógica
        ↓
7. Model interage com banco de dados
        ↓
8. Dados retornam ao Controller
        ↓
9. View renderiza template
        ↓
10. HTML retorna ao navegador
```

---

## Componentes Principais

### Models (app/Models/)

#### User
- Usuários do sistema
- Relacionamento com Permission (M:M)
- Relacionamento com AuditLog (1:M)

```php
User (1) ──→ (M) Permission
User (1) ──→ (M) AuditLog
```

#### Permission
- Permissões disponíveis
- Relacionamento com User (M:M)

```php
Permission (M) ──→ (M) User
```

#### AuditLog
- Logs de auditoria
- Relacionamento com User (M:1)

```php
AuditLog (M) ──→ (1) User
```

### Controllers (app/Http/Controllers/)

#### AuthController
- `showLogin()` - Exibe formulário de login
- `login()` - Processa login
- `logout()` - Processa logout
- `showChangePasswordForm()` - Exibe formulário
- `changePassword()` - Processa mudança de senha

#### UserController
- `index()` - Lista usuários
- `create()` - Formulário de criação
- `store()` - Armazena novo usuário
- `edit()` - Formulário de edição
- `update()` - Atualiza usuário
- `destroy()` - Deleta usuário
- `resetPassword()` - Reseta senha

#### DashboardController
- `index()` - Exibe dashboard
- `auditLogs()` - Lista logs
- `exportAuditLogs()` - Exporta CSV

### Middleware (app/Http/Middleware/)

#### Authenticate
- Verifica autenticação
- Redireciona para login se necessário

#### CheckRole
- Verifica papéis do usuário
- Nega acesso se necessário

#### CheckPermission
- Verifica permissões específicas
- Nega acesso se necessário

---

## Padrões de Design

### Model-View-Controller (MVC)
- Separação de responsabilidades
- Facilita manutenção e testes

### Repository Pattern (Optional)
- Abstração do acesso aos dados
- Facilita testes unitários

### Service Layer (Optional)
- Lógica de negócio complexa
- Reutilização de código

---

## Segurança

### Autenticação
- Laravel Auth (session-based)
- Hash bcrypt para senhas
- CSRF protection

### Autorização
- Middleware CheckRole
- Middleware CheckPermission
- Verificação em modelos

### Validação
- Validação server-side
- Sanitização de inputs
- Prepared statements (Eloquent)

### Auditoria
- Logging de todas as ações
- Rastreamento de IP
- Rastreamento de User Agent

---

## Performance

### Caching
- Configurável (file, redis, memcached)
- Cache de queries
- Cache de views (possível)

### Database Optimization
- Índices em tabelas
- Eager loading de relacionamentos
- Queries otimizadas

### Session Management
- Configurável (file, redis, memcached)
- Timeout automático

---

## Deployment

```
Desenvolvimento
    ↓
Staging (teste)
    ↓
Produção (live)
```

### Ambiente de Desenvolvimento
- Debug ON
- Erro detalhado
- Hot reload

### Ambiente de Produção
- Debug OFF
- Erro genérico
- Cache habilitado
- SSL obrigatório

---

## Escalabilidade

### Horizontal
- API stateless (possível)
- Sessões em redis
- Cache distribuído

### Vertical
- Otimização de queries
- Índices de banco de dados
- Cache agressivo

---

## Monitoramento

### Logs
- `storage/logs/laravel.log`
- Rotação automática
- Diferentes níveis (debug, info, warning, error)

### Métricas
- Auditoria integrada
- Rastreamento de usuários
- Análise de performance

---

## Documentação da API

Veja [API.md](API.md) para documentação de endpoints (se aplicável).

---

## Próximas Evoluções

1. **Microserviços**: Separação em serviços independentes
2. **API REST**: Para clientes mobile/terceiros
3. **Event-Driven Architecture**: Para processamento assíncrono
4. **Message Queue**: Para jobs pesados
5. **Caching Strategy**: Redis para performance


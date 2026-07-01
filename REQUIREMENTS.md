# 📋 Requisitos do Sistema - Silver7Store

## Requisitos Mínimos

### Servidor Web
- **Servidor Web**: Apache 2.4+ com mod_rewrite OU Nginx
- **PHP**: 8.1 ou superior
- **Extensões PHP Obrigatórias**:
  - BCMath
  - Ctype
  - cURL
  - DOM
  - Fileinfo
  - Filter
  - Hash
  - Intl
  - JSON
  - Mbstring
  - OpenSSL
  - PCRE
  - PDO
  - PDO MySQL
  - Tokenizer
  - XML

### Banco de Dados
- **MySQL**: 5.7 ou superior (recomendado 8.0+)
- **OU MariaDB**: 10.3 ou superior
- **Espaço em disco**: Mínimo 100MB

### Sistema Operacional
- **Linux** (Ubuntu 18.04+, CentOS 7+, Debian 9+)
- **Windows** (Windows Server 2016+ ou Windows 10+)
- **macOS** (10.13+)

### Dependências de Desenvolvimento
- **Composer**: 2.0+
- **Git**: Para controle de versão
- **Node.js**: 14+ (se usar assets)
- **npm** ou **yarn**: Para gerenciar dependências JavaScript

---

## Configuração Recomendada (Produção)

### Hardware
- **CPU**: Mínimo 2 cores
- **RAM**: Mínimo 2GB (recomendado 4GB+)
- **Disco**: SSD de 20GB+
- **Bandwidth**: 5Mbps+

### Software
- **PHP**: 8.2 ou 8.3 (latest stable)
- **MySQL**: 8.0 LTS
- **Nginx**: 1.20+
- **Linux**: Ubuntu 22.04 LTS

### Performance
- **OPcache**: Habilitado
- **Redis**: Para cache e sessions (opcional)
- **Memcached**: Para cache distribuído (opcional)

---

## Checklist de Instalação

### ✓ Antes de Começar

- [ ] PHP 8.1+ instalado e funcionando
- [ ] MySQL 5.7+ instalado e funcionando
- [ ] Composer instalado globalmente
- [ ] Git instalado (para clonar repositório)
- [ ] Acesso root/sudo ao servidor

### ✓ Configuração do Servidor

- [ ] mod_rewrite habilitado (Apache)
- [ ] Permissões corretas em diretórios
- [ ] Document root apontando para `/public`
- [ ] SSL/TLS configurado (recomendado)

### ✓ Configuração do Banco de Dados

- [ ] Banco de dados criado
- [ ] Usuário de banco de dados criado
- [ ] Privilégios adequados atribuídos
- [ ] Conexão testada

### ✓ Configuração da Aplicação

- [ ] `.env` configurado com credenciais corretas
- [ ] `APP_KEY` gerado
- [ ] Migrations executadas
- [ ] Seeders executados
- [ ] Storage/cache com permissões corretas

---

## Variáveis de Ambiente

### Essenciais

```env
APP_NAME="Silver7Store"
APP_ENV=production  # ou development
APP_KEY=base64:...  # Gerada automaticamente
APP_DEBUG=false     # Sempre false em produção
APP_URL=https://seu-dominio.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=silver7store
DB_USERNAME=usuario_db
DB_PASSWORD=senha_segura

# Admin padrão
ADMIN_DEFAULT_USER=Silver7
ADMIN_DEFAULT_PASSWORD=senha_segura
ADMIN_DEFAULT_EMAIL=admin@seu-dominio.com
```

### Opcionais

```env
CACHE_DRIVER=file      # ou redis, memcached
SESSION_DRIVER=file    # ou redis, memcached
MAIL_DRIVER=log        # ou smtp para emails reais
LOG_LEVEL=info
```

---

## Verificação de Saúde

Depois de instalado, verifique:

1. **Acesso à aplicação**
   ```bash
   curl http://localhost:8000
   ```

2. **Banco de dados**
   ```bash
   php artisan migrate:status
   ```

3. **Permissões de arquivo**
   ```bash
   ls -la storage/
   ls -la bootstrap/cache/
   ```

4. **Logs**
   ```bash
   tail -f storage/logs/laravel.log
   ```

---

## Suporte

Para problemas de compatibilidade, consulte:
- [Documentação oficial do Laravel](https://laravel.com/docs/10.x)
- [PHP Documentation](https://www.php.net/docs.php)
- [MySQL Documentation](https://dev.mysql.com/doc/)

---

## Próximas Etapas

1. Após instalação, configure o SSL/TLS
2. Configure backups automáticos
3. Configure monitoramento e alertas
4. Configure rotação de logs
5. Implemente políticas de segurança

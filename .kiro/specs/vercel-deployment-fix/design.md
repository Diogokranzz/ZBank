# Design Document - Vercel Deployment Fix

## Overview

Este documento descreve a solução para corrigir o erro HTTP 500 que ocorre ao implantar a aplicação Laravel 11 no Vercel. O problema principal está relacionado às limitações do ambiente serverless do Vercel, que incluem sistema de arquivos read-only (exceto /tmp), falta de persistência entre requisições, e requisitos específicos de configuração.

A solução envolve:
1. Habilitar logs detalhados para diagnóstico
2. Ajustar configurações de storage e cache para ambiente serverless
3. Corrigir o processo de build para gerar todos os arquivos necessários
4. Configurar variáveis de ambiente apropriadas
5. Ajustar rotas e paths para o ambiente Vercel

## Architecture

### Componentes Principais

```
┌─────────────────────────────────────────────────────────┐
│                    Vercel Platform                       │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  ┌────────────────┐         ┌──────────────────┐       │
│  │  Static Assets │────────▶│  CDN Edge Cache  │       │
│  │  (/public)     │         └──────────────────┘       │
│  └────────────────┘                                     │
│                                                          │
│  ┌────────────────────────────────────────────┐        │
│  │         Serverless Function                 │        │
│  │  ┌──────────────────────────────────────┐  │        │
│  │  │      api/index.php                   │  │        │
│  │  │  ┌────────────────────────────────┐  │  │        │
│  │  │  │   Laravel Application          │  │  │        │
│  │  │  │                                │  │  │        │
│  │  │  │  • Bootstrap                   │  │  │        │
│  │  │  │  • Router                      │  │  │        │
│  │  │  │  • Controllers                 │  │  │        │
│  │  │  │  • Middleware                  │  │  │        │
│  │  │  └────────────────────────────────┘  │  │        │
│  │  └──────────────────────────────────────┘  │        │
│  └────────────────────────────────────────────┘        │
│                                                          │
│  ┌────────────────────────────────────────────┐        │
│  │         /tmp (writable storage)             │        │
│  │  • Session files (if needed)                │        │
│  │  • Temporary cache                          │        │
│  │  • Logs (ephemeral)                         │        │
│  └────────────────────────────────────────────┘        │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

### Fluxo de Requisição

1. Cliente faz requisição → Vercel Edge Network
2. Se for asset estático → Servido diretamente do CDN
3. Se for requisição dinâmica → Roteado para serverless function
4. api/index.php → public/index.php → Laravel Bootstrap
5. Laravel processa requisição e retorna resposta
6. Resposta enviada ao cliente

## Components and Interfaces

### 1. Build Configuration (build.sh)

**Propósito**: Preparar a aplicação durante o deploy no Vercel

**Modificações Necessárias**:
```bash
#!/bin/bash

# Install dependencies
composer install --no-dev --optimize-autoloader --no-interaction

# Generate optimized files
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build frontend assets
npm ci --production=false
npm run build

# Create necessary directories in /tmp structure
# (Vercel will use /tmp for writable storage)
```

**Justificativa**: O build deve gerar todos os arquivos de cache necessários, pois o filesystem é read-only em runtime.

### 2. API Entry Point (api/index.php)

**Propósito**: Ponto de entrada para todas as requisições dinâmicas

**Modificações Necessárias**:
```php
<?php

// Enable error reporting for debugging
if (getenv('APP_DEBUG') === 'true') {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}

// Set storage path to /tmp for Vercel
$_ENV['APP_STORAGE'] = '/tmp/storage';

// Ensure storage directories exist
$storagePath = '/tmp/storage';
$directories = [
    $storagePath,
    $storagePath . '/framework',
    $storagePath . '/framework/cache',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Load the Laravel application
require __DIR__ . '/../public/index.php';
```

**Justificativa**: Vercel só permite escrita em /tmp, então precisamos redirecionar o storage do Laravel para lá.

### 3. Application Bootstrap (bootstrap/app.php)

**Modificações**: Nenhuma modificação necessária no arquivo atual, mas precisamos garantir que ele use o storage path correto.

### 4. Vercel Configuration (vercel.json)

**Modificações Necessárias**:
```json
{
  "version": 2,
  "builds": [
    {
      "src": "api/index.php",
      "use": "vercel-php@0.7.3"
    },
    {
      "src": "package.json",
      "use": "@vercel/static-build",
      "config": {
        "distDir": "public"
      }
    }
  ],
  "routes": [
    {
      "src": "/build/(.*)",
      "dest": "/public/build/$1"
    },
    {
      "src": "/(css|js|images|fonts)/(.*)",
      "dest": "/public/$1/$2"
    },
    {
      "src": "/favicon.ico",
      "dest": "/public/favicon.ico"
    },
    {
      "src": "/robots.txt",
      "dest": "/public/robots.txt"
    },
    {
      "src": "/(.*)",
      "dest": "/api/index.php"
    }
  ],
  "env": {
    "APP_ENV": "production",
    "APP_DEBUG": "true",
    "VERCEL": "1",
    "SESSION_DRIVER": "cookie",
    "CACHE_DRIVER": "array",
    "QUEUE_CONNECTION": "sync",
    "LOG_CHANNEL": "stderr",
    "VIEW_COMPILED_PATH": "/tmp/storage/framework/views"
  },
  "functions": {
    "api/index.php": {
      "memory": 1024,
      "maxDuration": 10
    }
  }
}
```

**Justificativa**: 
- APP_DEBUG temporariamente true para diagnóstico
- LOG_CHANNEL=stderr para ver logs no Vercel
- VIEW_COMPILED_PATH aponta para /tmp
- Aumentar memory e maxDuration para evitar timeouts

### 5. Environment Variables

**Variáveis Críticas que devem estar configuradas no Vercel Dashboard**:

```env
APP_NAME="ZBank Digital"
APP_ENV=production
APP_KEY=base64:... (OBRIGATÓRIO - gerar com php artisan key:generate)
APP_DEBUG=true (temporário para debug, depois mudar para false)
APP_URL=https://seu-projeto.vercel.app

LOG_CHANNEL=stderr
LOG_LEVEL=debug

SESSION_DRIVER=cookie
CACHE_DRIVER=array
QUEUE_CONNECTION=sync

DB_CONNECTION=mysql (se usar banco)
DB_HOST=...
DB_PORT=3306
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...
```

**Justificativa**: APP_KEY é obrigatório e causa erro 500 se não estiver configurado.

## Data Models

Não há mudanças nos data models. O foco é na configuração de infraestrutura.

## Error Handling

### Estratégia de Logging

1. **Durante Diagnóstico**:
   - APP_DEBUG=true
   - LOG_CHANNEL=stderr
   - LOG_LEVEL=debug
   - display_errors=1 no PHP

2. **Em Produção** (após correção):
   - APP_DEBUG=false
   - LOG_CHANNEL=stderr (para ver no Vercel)
   - LOG_LEVEL=error
   - display_errors=0

### Pontos Comuns de Falha

| Erro | Causa | Solução |
|------|-------|---------|
| HTTP 500 genérico | APP_KEY não configurado | Configurar no Vercel Dashboard |
| Permission denied | Tentativa de escrever fora de /tmp | Redirecionar storage para /tmp |
| Class not found | Autoload não otimizado | composer install --optimize-autoloader |
| View not found | Cache de views não gerado | php artisan view:cache no build |
| Route not found | Cache de rotas desatualizado | php artisan route:cache no build |

### Debugging Steps

1. Verificar logs no Vercel Dashboard (Runtime Logs)
2. Verificar logs de build (Build Logs)
3. Testar localmente com mesmo PHP version (8.2)
4. Verificar se todas as env vars estão configuradas
5. Verificar se build.sh executou com sucesso

## Testing Strategy

### 1. Local Testing

```bash
# Simular ambiente Vercel localmente
APP_DEBUG=true \
SESSION_DRIVER=cookie \
CACHE_DRIVER=array \
LOG_CHANNEL=stderr \
php artisan serve
```

### 2. Build Testing

```bash
# Testar o script de build
bash build.sh

# Verificar se arquivos de cache foram gerados
ls -la bootstrap/cache/
ls -la storage/framework/views/
```

### 3. Vercel Preview Testing

- Fazer deploy em preview environment primeiro
- Verificar logs em tempo real
- Testar todas as rotas principais
- Verificar assets estáticos

### 4. Production Deployment

Após confirmar que preview funciona:
1. Mudar APP_DEBUG=false
2. Mudar LOG_LEVEL=error
3. Deploy para production
4. Monitorar logs por 24h

## Implementation Phases

### Phase 1: Diagnostic (Prioridade Máxima)
- Habilitar logs detalhados
- Adicionar error reporting no api/index.php
- Deploy e verificar logs para identificar causa raiz

### Phase 2: Storage Fix
- Redirecionar storage para /tmp
- Criar diretórios necessários em runtime
- Configurar VIEW_COMPILED_PATH

### Phase 3: Environment Configuration
- Verificar/configurar APP_KEY
- Ajustar variáveis de ambiente no Vercel
- Configurar drivers serverless-friendly

### Phase 4: Build Optimization
- Otimizar build.sh
- Garantir geração de todos os caches
- Testar build localmente

### Phase 5: Production Hardening
- Desabilitar debug mode
- Ajustar log levels
- Configurar memory/timeout apropriados
- Monitoramento

## Performance Considerations

- **Cold Start**: Primeira requisição pode levar 1-3s (normal em serverless)
- **Cache**: Usar array driver (em memória) para cache
- **Sessions**: Usar cookie driver para evitar dependência de storage
- **Assets**: Servidos via CDN do Vercel (rápido)
- **Database**: Usar connection pooling se possível (PlanetScale, Supabase, etc.)

## Security Considerations

- Nunca commitar .env com credenciais reais
- APP_KEY deve ser único e secreto
- APP_DEBUG=false em produção
- Usar HTTPS (Vercel fornece automaticamente)
- Validar todas as env vars antes de usar
- Limitar maxDuration para evitar custos excessivos

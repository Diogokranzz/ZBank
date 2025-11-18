# ZBank Digital

ZBank Digital é uma plataforma bancária moderna desenvolvida para demonstrar conceitos avançados de desenvolvimento web full-stack. O projeto simula um ambiente bancário completo, permitindo que usuários gerenciem suas finanças digitais através de uma interface elegante e intuitiva.

A aplicação foi construída utilizando o framework Laravel na versão 12, combinando a robustez do PHP no backend com tecnologias modernas de frontend para criar uma experiência fluida e responsiva. O design visual foi inspirado em interfaces futuristas, utilizando gradientes vibrantes, animações suaves e efeitos 3D para proporcionar uma experiência visual diferenciada.

## O que o sistema oferece

O ZBank Digital permite que usuários realizem operações bancárias essenciais de forma digital e segura. Através da plataforma, é possível criar e gerenciar cartões de crédito virtuais com diferentes categorias e limites, realizar transferências instantâneas via PIX com geração de QR Code, acompanhar o histórico completo de transações com filtros avançados, e visualizar o saldo e movimentações em tempo real através de um dashboard interativo.

O sistema conta com autenticação completa incluindo registro de novos usuários, login seguro, recuperação de senha via email e logout. Os cartões virtuais podem ser criados em três modalidades: Platinum com limite de dez mil reais, Gold com cinco mil reais, e Black com vinte mil reais. Cada cartão possui visual 3D interativo que pode ser girado para visualizar frente e verso, além de funcionalidades de bloqueio e desbloqueio instantâneo.

Para transações, o sistema implementa o PIX brasileiro com geração automática de QR Code para recebimento e interface simplificada para envio de valores. O dashboard apresenta cards informativos com saldo atual, quantidade de cartões ativos e resumo de transações recentes. Todo o histórico financeiro pode ser filtrado por tipo de operação, período específico e possui paginação para facilitar a navegação.

## Tecnologias e arquitetura

O backend foi desenvolvido em PHP versão 8.2 ou superior utilizando o framework Laravel 12. O Laravel foi escolhido por sua arquitetura MVC robusta, sistema de rotas elegante, ORM Eloquent para manipulação de banco de dados, sistema de autenticação integrado e ferramentas de segurança nativas. A aplicação segue os padrões PSR do PHP e utiliza namespaces para organização do código.

O frontend combina o sistema de templates Blade do Laravel com Tailwind CSS para estilização. O Tailwind foi escolhido por sua abordagem utility-first que permite criar interfaces customizadas rapidamente sem sair do HTML. Para interatividade, utilizamos Alpine.js, um framework JavaScript leve que adiciona reatividade aos componentes sem a complexidade de frameworks maiores. As animações e transições foram implementadas com CSS puro e classes do Tailwind.

O banco de dados utiliza MySQL versão 8.0 ou superior, aproveitando recursos modernos como JSON columns, índices otimizados e transações ACID. O schema foi projetado com relacionamentos bem definidos entre usuários, cartões, transações e logs de auditoria. As migrations do Laravel garantem versionamento e portabilidade do banco de dados.

Para o processo de build e bundling dos assets, utilizamos Vite, que oferece hot module replacement durante o desenvolvimento e otimização automática para produção. O Vite compila os arquivos CSS com PostCSS e processa o JavaScript moderno, gerando bundles otimizados com code splitting automático.

Bibliotecas adicionais incluem QRCode.js para geração de códigos QR no lado do cliente, Axios para requisições HTTP assíncronas com interceptors e tratamento de erros, e Chart.js para visualizações gráficas quando necessário.

## Stack técnica detalhada

Backend PHP e Laravel:
O Laravel 12 fornece a base da aplicação com seu sistema de rotas RESTful, controllers organizados por recurso, models Eloquent com relacionamentos, policies para autorização, service layer para lógica de negócio, requests customizados para validação, middleware para filtros de requisição e jobs para tarefas assíncronas.

Frontend e estilização:
O Blade engine processa templates server-side com sintaxe limpa e componentes reutilizáveis. O Tailwind CSS versão 3 oferece classes utilitárias para spacing, cores, tipografia, flexbox, grid, animações e responsividade. O Alpine.js adiciona reatividade com diretivas x-data, x-show, x-if, x-for, x-on e x-model.

Banco de dados:
O MySQL armazena dados em tabelas relacionais com foreign keys, índices para performance, triggers para automação e stored procedures quando necessário. O Laravel gerencia conexões, query builder, migrations, seeders e factories.

Build e tooling:
O Vite processa assets com hot reload instantâneo, tree shaking automático, lazy loading de rotas, minificação de código e geração de source maps. O PostCSS processa o Tailwind com autoprefixer, purge de CSS não utilizado e otimização de output.

Segurança:
A aplicação implementa hash bcrypt para senhas com custo configurável, proteção CSRF em formulários, rate limiting em rotas sensíveis, validação server-side obrigatória, sanitização de inputs, headers de segurança HTTP e políticas de acesso baseadas em roles.

## Requisitos

- PHP 8.2 ou superior
- Composer
- Node.js 18+ e NPM
- MySQL 8.0+
- Extensões PHP: BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

## Instalação

### 1. Clone o repositório

```bash
git clone https://github.com/seu-usuario/zbank-digital.git
cd zbank-digital
```

### 2. Instale as dependências do PHP

```bash
composer install
```

### 3. Instale as dependências do Node.js

```bash
npm install
```

### 4. Configure o ambiente

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configure o banco de dados

Edite o arquivo `.env` com suas credenciais MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=zbank_digital
DB_USERNAME=root
DB_PASSWORD=sua_senha
```

### 6. Execute as migrations

```bash
php artisan migrate
```

### 7. (Opcional) Popule o banco com dados de teste

```bash
php artisan db:seed
```

Isso criará:
- 10 usuários de teste (senha: `password`)
- 2-3 cartões por usuário
- 10-20 transações por usuário

Usuário principal de teste:
- Email: `joao@zbank.com`
- Senha: `password`

### 8. Compile os assets

Desenvolvimento:
```bash
npm run dev
```

Produção:
```bash
npm run build
```

### 9. Inicie o servidor

```bash
php artisan serve
```

Acesse: `http://localhost:8000`

## Estrutura do Projeto

```
zbank-digital/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   ├── Policies/
│   └── Services/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
└── routes/
    └── web.php
```

## Paleta de Cores

```css
--primary-purple: #8B5CF6
--primary-green: #4FC08D
--primary-cyan: #38B2AC
--dark-bg: #0F172A
--card-bg: #1E293B
--text-primary: #F1F5F9
--text-secondary: #94A3B8
```

## Segurança

O sistema implementa diversas camadas de segurança:

- Hash bcrypt (custo 12) para senhas
- Proteção CSRF em todos os formulários
- Rate limiting (5 tentativas em 15 minutos no login)
- Headers de segurança HTTP (X-Frame-Options, CSP, HSTS)
- Validação server-side obrigatória
- Policies para controle de acesso
- Sistema de auditoria com logs
- HTTPS obrigatório em produção

## Tipos de Cartão

| Tipo     | Limite      | Cor      |
|----------|-------------|----------|
| Platinum | R$ 10.000   | Roxo     |
| Gold     | R$ 5.000    | Dourado  |
| Black    | R$ 20.000   | Preto    |

## Testes

```bash
php artisan test
```

## Deploy na Vercel

O projeto está configurado para deploy na plataforma Vercel. Para fazer o deploy, siga os passos detalhados no arquivo VERCEL_DEPLOY.md.

Resumo rápido:

1. Instale a CLI da Vercel: `npm install -g vercel`
2. Configure um banco de dados MySQL externo (PlanetScale, Railway, etc)
3. Configure as variáveis de ambiente no painel da Vercel
4. Execute: `vercel --prod`

Importante: A Vercel tem limitações para aplicações PHP. Para produção completa, considere usar Laravel Forge, Heroku ou DigitalOcean.

## Comandos Úteis

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan migrate:fresh --seed
```

## Contribuindo

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/MinhaFeature`)
3. Commit suas mudanças (`git commit -m 'Adiciona MinhaFeature'`)
4. Push para a branch (`git push origin feature/MinhaFeature`)
5. Abra um Pull Request

## Licença

Este projeto está sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.

## Sobre o projeto

O ZBank Digital foi desenvolvido como um projeto educacional para demonstrar a implementação de um sistema bancário completo utilizando tecnologias web modernas. O código foi estruturado seguindo as melhores práticas de desenvolvimento, incluindo separação de responsabilidades, injeção de dependências, testes automatizados e documentação clara.

Este projeto serve como referência para desenvolvedores que desejam aprender sobre desenvolvimento full-stack com Laravel, implementação de sistemas financeiros, integração de APIs de pagamento, design de interfaces modernas e arquitetura de aplicações web escaláveis.

Importante ressaltar que este é um ambiente de demonstração e aprendizado. Para uso em produção real, seria necessário implementar camadas adicionais de segurança, compliance com regulamentações bancárias, integração com sistemas de pagamento reais, auditoria completa de todas as operações, backup e recuperação de desastres, monitoramento e alertas em tempo real, e testes de carga e performance.

O projeto está disponível sob licença MIT, permitindo uso livre para fins educacionais e comerciais com as devidas atribuições.

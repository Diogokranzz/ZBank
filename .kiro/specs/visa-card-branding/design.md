# Design Document

## Overview

Este documento descreve o design técnico para implementar a exibição consistente do logotipo VISA em todos os cartões VISA no sistema. A solução será implementada no contexto de uma aplicação Laravel com Blade templates, garantindo que todos os componentes de cartão exibam corretamente a bandeira VISA.

### Current State

Atualmente, o sistema possui:
- Modelo `Card` com campo `brand` (string) que armazena a bandeira do cartão
- Views Blade que renderizam cartões com SVG inline para logos de bandeiras (VISA, Mastercard, Elo)
- Implementação de SVG VISA existente, mas com design simplificado
- Suporte para múltiplos tipos de cartão (platinum, gold, black)

### Problem Statement

O logotipo VISA atual é renderizado como SVG inline simplificado que não representa fielmente a marca oficial VISA. Precisamos:
1. Substituir o SVG simplificado por um logotipo VISA oficial e consistente
2. Garantir que todos os cartões VISA exibam o logotipo correto
3. Manter a responsividade e performance
4. Aplicar o logotipo em todas as views que exibem cartões

## Architecture

### Component Structure

```
┌─────────────────────────────────────┐
│   Blade Views (Card Display)        │
│   - cards/modern.blade.php          │
│   - cards/index.blade.php           │
│   - dashboard/modern.blade.php      │
│   - landing/index.blade.php         │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│   Blade Component (Reusable)        │
│   - components/card-brand-logo.php  │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│   SVG Asset                          │
│   - public/images/brands/visa.svg   │
└─────────────────────────────────────┘
```

### Data Flow

1. **Card Model** → fornece `brand` field (ex: 'visa', 'mastercard', 'elo')
2. **Blade View** → passa `$card->brand` para o componente
3. **Brand Logo Component** → seleciona e renderiza o SVG apropriado
4. **SVG Asset** → exibido no frontend com estilos responsivos

## Components and Interfaces

### 1. Blade Component: `card-brand-logo`

**Purpose**: Componente reutilizável que renderiza o logotipo da bandeira baseado no tipo

**Location**: `resources/views/components/card-brand-logo.blade.php`

**Props**:
```php
@props([
    'brand' => 'visa',      // string: 'visa', 'mastercard', 'elo'
    'size' => 'default',    // string: 'small', 'default', 'large'
    'variant' => 'front'    // string: 'front' (colorido), 'back' (monocromático)
])
```

**Output**: Renderiza SVG inline ou referência a arquivo SVG

### 2. SVG Assets

**Location**: `public/images/brands/`

**Files**:
- `visa.svg` - Logotipo oficial VISA (azul #1A1F71 e amarelo #F7B600)
- `mastercard.svg` - Logotipo Mastercard (existente)
- `elo.svg` - Logotipo Elo (existente)

**VISA SVG Specifications**:
- Cores oficiais: Azul (#1A1F71) e Amarelo (#F7B600)
- Proporção: 3:1 (largura:altura)
- Viewbox: 0 0 120 40
- Formato: SVG otimizado, sem dependências externas

### 3. Updated Blade Views

**Files to Update**:
1. `resources/views/cards/modern.blade.php` - Página principal de cartões
2. `resources/views/cards/index.blade.php` - Lista de cartões (se existir)
3. `resources/views/dashboard/modern.blade.php` - Dashboard com cartões
4. `resources/views/landing/index.blade.php` - Landing page com preview de cartões

**Changes**:
- Substituir SVG inline por `<x-card-brand-logo :brand="$card->brand" />`
- Manter posicionamento e estilos existentes
- Aplicar tanto no front quanto no back do cartão

## Data Models

### Card Model (Existing)

```php
class Card extends Model
{
    protected $fillable = [
        'user_id',
        'card_number',
        'card_holder',
        'cvv',
        'expiry_date',
        'type',        // platinum, gold, black
        'brand',       // visa, mastercard, elo
        'limit',
        'current_bill',
        'is_blocked',
    ];
}
```

**No database changes required** - o campo `brand` já existe e armazena a bandeira do cartão.

### Brand Detection Logic

O sistema já possui lógica para definir a bandeira do cartão. Não é necessário implementar detecção automática baseada no número do cartão nesta fase, mas podemos adicionar como melhoria futura.

**Default Behavior**: Se `brand` for null ou vazio, usar 'visa' como padrão (conforme código existente: `($card->brand ?? 'visa')`)

## Implementation Details

### 1. VISA Logo SVG

O logotipo VISA oficial será implementado como SVG inline otimizado:

```svg
<svg viewBox="0 0 120 40" fill="none" xmlns="http://www.w3.org/2000/svg">
  <!-- V com acento amarelo -->
  <path d="M0 8 L8 8 L16 32 L24 32 L32 8 L40 8 L28 40 L12 40 Z" fill="#1A1F71"/>
  <path d="M0 8 L8 8 L12 20 L8 32 L0 32 Z" fill="#F7B600"/>
  
  <!-- I -->
  <rect x="44" y="8" width="8" height="32" fill="#1A1F71"/>
  
  <!-- S -->
  <path d="M56 16 C56 12 60 8 68 8 C76 8 80 12 80 16 L72 16 C72 14 70 12 68 12 C66 12 64 14 64 16 C64 18 66 20 68 20 L72 20 C78 20 84 24 84 32 C84 36 80 40 72 40 C64 40 60 36 60 32 L68 32 C68 34 70 36 72 36 C74 36 76 34 76 32 C76 30 74 28 72 28 L68 28 C62 28 56 24 56 16 Z" fill="#1A1F71"/>
  
  <!-- A -->
  <path d="M88 40 L96 8 L104 8 L112 40 L104 40 L102 32 L98 32 L96 40 Z M100 12 L98.5 26 L101.5 26 Z" fill="#1A1F71"/>
</svg>
```

### 2. Component Sizing

**Size Classes**:
```php
$sizes = [
    'small' => 'h-5',   // 20px height
    'default' => 'h-8', // 32px height (current)
    'large' => 'h-12'   // 48px height
];
```

### 3. Responsive Behavior

**Tailwind Classes**:
- Mobile (< 768px): `h-6 sm:h-8` - Logo menor em telas pequenas
- Tablet/Desktop: `h-8 lg:h-10` - Logo padrão
- Manter proporção automática com `width: auto`

### 4. Color Variants

**Front of Card** (colorido):
- VISA: Azul #1A1F71 + Amarelo #F7B600
- Mastercard: Vermelho #EB001B + Amarelo #F79E1B
- Elo: Branco #FFFFFF

**Back of Card** (monocromático):
- Todos os logos em branco (#FFFFFF) para contraste com o fundo do cartão

## Error Handling

### Missing Brand

```php
// Default to 'visa' if brand is null or empty
$brand = $card->brand ?? 'visa';
```

### Invalid Brand

```php
// Fallback to generic card icon if brand is not recognized
$validBrands = ['visa', 'mastercard', 'elo'];
if (!in_array($brand, $validBrands)) {
    $brand = 'visa'; // or show generic card icon
}
```

### SVG Loading Failure

- SVG é inline, não há risco de falha de carregamento
- Se componente não for encontrado, Blade mostrará erro de desenvolvimento
- Em produção, usar `@if(View::exists())` para verificação

## Testing Strategy

### Visual Testing

1. **Manual Testing**:
   - Verificar renderização em diferentes tipos de cartão (platinum, gold, black)
   - Testar em diferentes tamanhos de tela (mobile, tablet, desktop)
   - Validar cores do logo VISA (azul e amarelo)
   - Verificar posicionamento no front e back do cartão

2. **Browser Testing**:
   - Chrome, Firefox, Safari, Edge
   - Verificar suporte a SVG inline
   - Testar em modo claro e escuro (se aplicável)

### Functional Testing

1. **Component Testing**:
   - Testar componente com diferentes props
   - Verificar fallback para brand inválido
   - Validar renderização de todas as bandeiras

2. **Integration Testing**:
   - Criar cartão VISA e verificar logo
   - Verificar logo em todas as páginas que exibem cartões
   - Testar com cartões sem brand definido (deve usar 'visa' como padrão)

### Performance Testing

1. **Page Load**:
   - Medir tempo de carregamento antes e depois
   - Verificar que SVG inline não impacta performance
   - Validar que não há requisições HTTP extras

2. **Rendering**:
   - Testar renderização de múltiplos cartões (10+)
   - Verificar que SVG é reutilizado eficientemente
   - Medir tempo de renderização do componente

## Performance Considerations

### SVG Optimization

- **Inline SVG**: Evita requisições HTTP adicionais
- **Minificação**: Remover espaços e comentários desnecessários
- **Reutilização**: Mesmo SVG usado para todos os cartões VISA
- **Tamanho**: SVG otimizado < 2KB

### Caching

- Blade templates são compilados e cacheados automaticamente
- SVG inline é parte do HTML compilado
- Sem necessidade de cache adicional

### Lazy Loading

- Não aplicável para SVG inline
- Considerar lazy loading apenas se usar `<img>` tags no futuro

## Accessibility

### SVG Accessibility

```html
<svg role="img" aria-label="VISA">
  <title>VISA</title>
  <!-- SVG content -->
</svg>
```

### Color Contrast

- Logo VISA tem contraste adequado em fundos escuros
- Versão monocromática (branca) para back do cartão
- Atende WCAG 2.1 AA standards

## Migration Strategy

### Phase 1: Component Creation
1. Criar componente `card-brand-logo.blade.php`
2. Adicionar SVG assets otimizados
3. Testar componente isoladamente

### Phase 2: View Updates
1. Atualizar `cards/modern.blade.php` (principal)
2. Atualizar outras views de cartão
3. Testar cada view após atualização

### Phase 3: Validation
1. Testes visuais em todas as páginas
2. Testes de responsividade
3. Validação de performance

### Rollback Plan

- Manter SVG inline original como comentário
- Se houver problemas, reverter para SVG simplificado
- Componente pode ser desabilitado sem quebrar o sistema

## Future Enhancements

1. **Automatic Brand Detection**: Implementar detecção automática baseada no número do cartão (BIN lookup)
2. **Additional Brands**: Suporte para American Express, Discover, etc.
3. **Animated Logos**: Adicionar animações sutis ao hover
4. **Dark Mode**: Variantes de logo para modo escuro
5. **SVG Sprites**: Considerar uso de SVG sprites para melhor performance com muitas bandeiras

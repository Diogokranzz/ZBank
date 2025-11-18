# Implementation Plan

- [x] 1. Criar componente Blade reutilizável para logos de bandeiras


  - Criar arquivo `resources/views/components/card-brand-logo.blade.php`
  - Implementar lógica para aceitar props: `brand`, `size`, `variant`
  - Adicionar SVG inline otimizado para VISA com cores oficiais (#1A1F71 azul, #F7B600 amarelo)
  - Implementar lógica de fallback para brand inválido ou null (usar 'visa' como padrão)
  - Adicionar suporte para diferentes tamanhos (small, default, large) com classes Tailwind
  - Implementar variantes colorido (front) e monocromático (back)
  - Adicionar atributos de acessibilidade (role, aria-label, title)
  - _Requirements: 1.1, 1.2, 1.3, 2.2, 3.1, 4.1_



- [ ] 2. Atualizar view principal de cartões (modern.blade.php)
  - Substituir SVG inline do logo VISA no front do cartão por `<x-card-brand-logo :brand="$card->brand ?? 'visa'" size="default" variant="front" />`
  - Substituir SVG inline do logo VISA no back do cartão por `<x-card-brand-logo :brand="$card->brand ?? 'visa'" size="small" variant="back" />`
  - Manter posicionamento e estilos existentes dos logos
  - Verificar que o componente funciona com todos os tipos de cartão (platinum, gold, black)


  - _Requirements: 1.1, 1.4, 3.1_

- [ ] 3. Atualizar outras views que exibem cartões
  - Identificar todas as views que renderizam cartões (cards/index.blade.php, dashboard/modern.blade.php, landing/index.blade.php)
  - Substituir SVG inline por componente `<x-card-brand-logo>` em cada view identificada


  - Aplicar tamanhos apropriados para cada contexto (small para previews, default para cards completos)
  - Garantir consistência visual em todas as páginas
  - _Requirements: 1.4, 3.1_

- [x] 4. Implementar responsividade do logo



  - Adicionar classes Tailwind responsivas ao componente (h-6 sm:h-8 lg:h-10)
  - Testar renderização em diferentes breakpoints (mobile < 768px, tablet, desktop)
  - Ajustar tamanhos para manter legibilidade em telas pequenas
  - Verificar que a proporção do logo é mantida em todos os tamanhos
  - _Requirements: 3.1, 3.2, 3.3_

- [ ] 5. Validar implementação e realizar testes visuais
  - Testar renderização de cartões VISA em todas as páginas atualizadas
  - Verificar cores do logo VISA (azul #1A1F71 e amarelo #F7B600)
  - Validar posicionamento do logo no front e back do cartão
  - Testar com cartões sem brand definido (deve usar 'visa' como padrão)
  - Verificar responsividade em diferentes dispositivos
  - Validar acessibilidade do SVG (role, aria-label)
  - _Requirements: 1.1, 1.2, 1.3, 1.4, 3.1, 3.2, 3.3_

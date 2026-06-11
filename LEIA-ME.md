# Meu Agrônomo — Interface final (cópia fiel do protótipo)

Pacote **consolidado e definitivo**: deixa todas as páginas idênticas ao protótipo
"Meu Agronomo.html". Inclui o que faltava + todos os pacotes anteriores num só drop.

## A correção principal

O `style.css` de produção **não tinha** as classes do painel inicial — `.ma-greet`,
`.ma-cols`, `.ma-block`, `.ma-visitrow`, `.ma-activity`. As views usavam essas classes,
mas sem CSS elas caíam no visual padrão do navegador. **Era por isso que o dashboard
não ficava igual ao protótipo.** Agora elas estão portadas com os valores exatos.

Também: logo **Broto** na sidebar/topbar, **busca** "Buscar clientes, visitas…",
título na topbar, sino, link **Relatórios** na nav, sidebar sem "X"/scrollbar no desktop.

## Estrutura (copie por cima — espelha o projeto)

```
resources/css/style.css                       ← + componentes do painel + topbar + sidebar limpa
resources/css/app.css                         ← sem Bootstrap (só importa o style.css)
app/Providers/AppServiceProvider.php          ← paginação estilizada
routes/web.php                                ← rotas (inclui Relatórios)
resources/views/
  index.blade.php                             ← login (logo Broto)
  cadastro.blade.php                          ← criar conta (logo Broto)
  dashboard.blade.php                         ← logo Broto, título, busca, sino, nav Relatórios
  home.blade.php                              ← saudação + cards + 2 colunas (fiel)
  clientes/{index,create,edit,show}.blade.php
  visitas/{agendar,minhas}.blade.php
  perfil/{info,senha}.blade.php                ← perfil agora tem campo CREA
  relatorios/{index,create,edit,show}.blade.php
  relatorios/imprimir.blade.php                ← NOVO: documento PDF (A4, marca, assinatura)
app/Models/{User,Relatorio}.php
app/Http/Controllers/{HomeController,RelatorioController,ProfileController}.php
database/migrations/
  ..._create_relatorios_table.php
  ..._add_crea_to_users_table.php               ← NOVO: coluna CREA no usuário
```

## Aplicar

```powershell
$src = "$env:USERPROFILE\Downloads\interface-final"
Copy-Item "$src\app\*"       -Destination ".\app\"       -Recurse -Force
Copy-Item "$src\resources\*" -Destination ".\resources\" -Recurse -Force
Copy-Item "$src\routes\*"    -Destination ".\routes\"    -Recurse -Force
Copy-Item "$src\database\*"  -Destination ".\database\"  -Recurse -Force

php artisan migrate --force   # cria 'relatorios' (no Railway: railway run php artisan migrate --force)
npm run build
git add . ; git commit -m "ui: copia fiel do prototipo (painel, topbar, sidebar) + relatorios" ; git push
```

> Depois do deploy: **Ctrl+Shift+R** (sem cache). Se usa Railway, rode o `migrate` no
> servidor: `railway run php artisan migrate --force`.

## O que ficou idêntico ao protótipo

- **Painel inicial:** saudação (eyebrow + "Bom dia/tarde/noite" + aviso), 4 cards de
  métrica, "Próximas visitas" (data, avatar, cliente, chevron) e "Clientes recentes".
- **Topbar:** título, busca em pílula, alternar tema, sino com ponto, avatar.
- **Sidebar:** logo Broto, grupos, item ativo em sálvia, rodapé com usuário + sair.
  Sem "X" e sem scrollbar no desktop.
- **Tipografia:** Hanken Grotesk com os mesmos pesos, tracking e tamanhos.
- **Ícones:** mesmo traço (1.7–1.9), tamanhos e formas do protótipo.
- **Cores:** sálvia + neutros frios, claro e escuro, idênticos.

## Observações

- **PDF do relatório:** na tela de um relatório, o botão **"Baixar PDF"** abre um
  documento A4 limpo (cabeçalho com a marca, dados do cliente, diagnóstico,
  recomendações e linha de assinatura) — é só usar Imprimir → "Salvar como PDF".
  Rota nova: `relatorios.imprimir`.
- **CREA no perfil:** em **Meu perfil** há o campo **Registro profissional (CREA)**.
  Ao preencher, o número aparece **automaticamente** na assinatura do PDF
  (ex.: "Engenheiro Agrônomo · CREA 123456-D/GO"). Se ficar vazio, sai só o cargo.
- **Dados reais no painel:** os 4 cards puxam tudo do banco — Clientes ativos,
  Visitas agendadas (próx. 7 dias), Relatórios (+ rascunhos) e **Área acompanhada**
  (soma real de hectares dos clientes ativos). Nenhum número é fixo.
- **Login e cadastro** revisados: agora com o logo **Broto** (igual ao dashboard).
  O modo escuro foi conferido em todas as telas — login, cadastro, painel, listas e
  formulários — todos legíveis e coesos.
- **Sem dependência de Bootstrap** — removido. Login/cadastro usam classes próprias.
- Se você já aplicou pacotes anteriores (correção, ajustes, relatórios), este os
  **substitui com folga** — pode copiar tudo por cima sem medo.
- O JS do tema e do menu mobile está embutido no `dashboard.blade.php`.

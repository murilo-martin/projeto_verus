# VERUS - Plataforma de Clima Organizacional

O **VERUS** é um sistema web criado para acompanhar, analisar e evoluir o clima organizacional das empresas. A plataforma reúne um portal público, uma área de coleta de pesquisas para colaboradores e um painel gerencial com indicadores, exportação de relatórios e ferramentas administrativas.

---

## Visão Geral
- Colaboradores respondem pesquisas com escala de satisfação e podem deixar sugestões anônimas.
- Empresas acompanham indicadores em tempo real, filtram sugestões e geram relatórios em Excel ou versão para impressão.
- Administradores gerenciam perguntas do questionário, cadastro de empresas e podem zerar respostas para novos ciclos.

---

## Principais Recursos
- Pesquisa de clima com múltiplas dimensões (comunicação, liderança, reconhecimento, benefícios, entre outras).
- Anonimato opcional nas respostas dos colaboradores.
- Dashboard interativo (`relatorios.php`) com estatísticas, gráfico de distribuição e mural de sugestões.
- Exportação para Excel (`api/gerarExcel.php`) em layout tabular com cabeçalhos azuis e valores em negrito.
- Relatório preparado para impressão (`print.php` e `assets/js/print.js`).
- Painel administrativo (`administrador.php`) com:
  - CRUD de empresas (`api/puxarInfo_crud.php`, `api/editEmp.php`, `api/deleteEmp.php`).
  - Edição das perguntas do questionário (`api/editQuestion.php`).
  - Rotina para zerar respostas (`api/zerarResponses.php`).
- Autenticação diferenciada para empresas e colaboradores (`api/login.php`).

---

## Stack Tecnológica
- Back-end: PHP 7.4+ (mysqli)
- Front-end: HTML5, CSS3, JavaScript (jQuery, Bootstrap 5, Cleave.js)
- Banco de dados: MySQL 5.7+
- Recursos adicionais: Font Awesome e Bootstrap Icons

---

## Estrutura de Pastas
```
projeto_verus/
  api/                  # Endpoints PHP (login, questionários, relatórios, CRUD, exportação, etc.)
  assets/
    css/                # Estilos globais do portal
    js/                 # Scripts de interação (modais, impressão, formulários)
    images/             # Recursos gráficos
  includes/
    mysqlconecta.php    # Configuração de conexão MySQL
  relatorios/           # Relatórios gerados pelo painel (HTML/Excel)
  administrador.php     # Painel administrativo
  index.php             # Landing page e acesso ao login
  questionario.php      # Formulário principal para colaboradores
  relatorios.php        # Dashboard analítico da empresa
  print.php             # Versão amigável para impressão
  typefeedback.php      # Catálogo de tipos de feedback
  verus_db.sql          # Script SQL com estrutura e dados iniciais
  README.md
```

---

## Pré-requisitos
- PHP 7.4 ou superior com extensão `mysqli` habilitada
- MySQL 5.7 ou superior
- Servidor web (Apache recomendado) - XAMPP/WAMP/MAMP funcionam bem em ambiente local
- Navegador moderno com suporte a ES6

---

## Instalação e Configuração
1. **Clonar o repositório**
   ```bash
   git clone https://seu-repositorio/projeto_verus.git
   cd projeto_verus
   ```

2. **Configurar o virtual host (opcional)**
   - Copie a pasta para `htdocs` (XAMPP) ou diretório público equivalente.
   - Inicie Apache e MySQL no painel do servidor local.

3. **Criar o banco de dados**
   - Acesse o phpMyAdmin (ou outro cliente SQL).
   - Crie o banco `verus_db`.
   - Importe o arquivo `verus_db.sql` disponível na raiz do projeto.

4. **Atualizar credenciais de conexão**
   - Abra `includes/mysqlconecta.php`.
   - Ajuste host, usuário e senha conforme seu ambiente:
     ```php
     $server   = "127.0.0.1";
     $user     = "root";
     $password = "";
     $database = "verus_db";
     ```

5. **Acessar a aplicação**
   - No navegador, abra `http://localhost/projeto_verus`.
   - Utilize os cadastros existentes ou crie novas empresas via tela de registro.

---

## Credenciais de Teste
O script `verus_db.sql` já inclui dados de demonstração. Caso utilize o dump original:

- Empresa
  - CNPJ: `12.345.678/0001-90`
  - Senha: `123456`

- Colaborador
  - E-mail: `funcionario@empresateste.com`
  - Senha: `123456`

---

## Fluxo Básico de Uso
1. Empresa registra-se ou utiliza a credencial de exemplo.
2. Colaboradores respondem ao formulário disponível em `questionario.php` (via link compartilhado pela empresa).
3. Dashboard (`relatorios.php`) apresenta totais, média de satisfação, participação mensal, taxa de anonimato, gráfico de distribuição e sugestões.
4. Empresa pode:
   - Exportar o relatório em Excel formatado (botão "Gerar Excel" -> `api/gerarExcel.php`).
   - Gerar versão para impressão (`print.php`).
   - Navegar pelas sugestões e acompanhar feedbacks.
5. Administração central (acesso restrito) ajusta perguntas, gerencia empresas e reinicia ciclos para novos períodos.

---

## Endpoints e Scripts Importantes
- `api/login.php` - autenticação de colaboradores e empresas.
- `api/register.php` - cadastro de empresas.
- `api/questionarioAPI.php` - recebimento das respostas.
- `api/relatoriosAPI.php` - retorno de métricas para o dashboard.
- `api/gerarExcel.php` - exportação em XLS (HTML formatado com estilos).
- `api/printAPI.php` - conteúdo usado pela versão para impressão.
- `assets/js/showModal.js` - controle dos modais administrativos.
- `assets/js/print.js` - automatiza a abertura da janela de impressão.

---

## Personalização
- Perguntas do formulário: editar em `questionario.php` e ajustar a lógica na `api/questionarioAPI.php`.
- Cores e fontes: modificar variáveis em `assets/css/style.css`.
- Conteúdo institucional: personalizar textos em `index.php` e nas páginas internas.
- Novos relatórios: criar endpoints adicionais na pasta `api/` e integrar aos botões existentes.

---

## Boas Práticas Recomendadas
- Criar usuários MySQL com permissões restritas ao banco `verus_db`.
- Habilitar HTTPS e configurar cookies de sessão seguros em produção.
- Revisar queries e validações sempre que ajustar as perguntas.
- Testar a exportação para Excel após incluir novas colunas ou seções.

---

## Licença
Projeto desenvolvido para fins acadêmicos ou profissionais internos. Defina a licença apropriada antes de distribuí-lo publicamente.

---

## Suporte
Em caso de dúvidas ou sugestões:
- Abra uma issue neste repositório; ou
- Entre em contato com o time responsável pelo VERUS.

---

**VERUS** - Transformando dados de pessoas em decisões estratégicas para um ambiente de trabalho mais saudável.

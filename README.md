# VERUS - Sistema de Clima Organizacional

## Sobre o Projeto

O VERUS é um sistema completo para análise e melhoria do clima organizacional das empresas. O sistema permite que funcionários respondam questionários anônimos sobre diversos aspectos do ambiente de trabalho, e que empresas acessem relatórios detalhados e soluções personalizadas baseadas no feedback coletado.

## Características Principais

### Para Funcionários
- **Questionário Anônimo**: Sistema de pesquisa com escala de 1-5 para diferentes aspectos do clima organizacional
- **Segurança de Dados**: Garantia de anonimato e confidencialidade das respostas
- **Interface Intuitiva**: Design moderno e fácil navegação

### Para Empresas
- **Relatórios Detalhados**: Análise completa dos dados coletados
- **Soluções Personalizadas**: Recomendações baseadas no feedback real dos colaboradores
- **Análise de Tendências**: Comparação de períodos para identificar melhorias
- **Dashboard Interativo**: Visualização clara dos resultados

## Tecnologias Utilizadas

- **Frontend**: HTML5, CSS3, JavaScript, jQuery
- **Backend**: PHP 7.4+
- **Banco de Dados**: MySQL 5.7+
- **Design**: Responsivo com cores azul claro, branco e cinza claro
- **Ícones**: Font Awesome

## Estrutura do Projeto

```
projeto_verus/
├── index.php                 # Página principal
├── assets/
│   ├── css/
│   │   └── style.css         # Estilos do sistema
│   ├── js/
│   │   └── script.js         # Funcionalidades JavaScript
│   └── images/               # Imagens do projeto
├── includes/
│   └── mysqlconecta.php      # Conexão com banco de dados
├── api/
│   ├── login.php             # API de autenticação
│   ├── questionario.php      # API de questionários
│   ├── feedback.php          # API de feedback
│   └── relatorios.php        # API de relatórios
└── README.md                 # Este arquivo
```

## Instalação

### Pré-requisitos
- Servidor web (Apache/Nginx)
- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- XAMPP, WAMP ou similar (para desenvolvimento local)

### Passos para Instalação

1. **Clone ou baixe o projeto**
   ```bash
   git clone [url-do-repositorio]
   cd projeto_verus
   ```

2. **Configure o servidor web**
   - Coloque os arquivos na pasta `htdocs` do XAMPP ou pasta equivalente do seu servidor
   - Certifique-se de que o servidor web e MySQL estão rodando

3. **Configure o banco de dados**
   - Abra o phpMyAdmin ou cliente MySQL
   - O banco de dados será criado automaticamente na primeira execução
   - As tabelas serão criadas automaticamente

4. **Configure as credenciais do banco**
   - Edite o arquivo `includes/mysqlconecta.php`
   - Altere as constantes conforme necessário:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'verus_db');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```

5. **Acesse o sistema**
   - Abra o navegador e acesse: `http://localhost/projeto_verus`
   - O sistema criará automaticamente o banco de dados e as tabelas

## Configuração Inicial

### Dados de Exemplo
O sistema inclui dados de exemplo para teste:

**Empresa de Teste:**
- CNPJ: 12.345.678/0001-90
- Senha: 123456

**Funcionário de Teste:**
- Email: funcionario@empresateste.com
- Senha: 123456

### Personalização
1. **Cores**: Edite as variáveis CSS em `assets/css/style.css`
2. **Perguntas**: Modifique as perguntas do questionário em `assets/js/script.js`
3. **Soluções**: Personalize as soluções propostas no mesmo arquivo

## Funcionalidades

### 1. Tela Inicial (Home)
- Apresentação do sistema com frase de introdução
- Botões de call-to-action para login
- Design responsivo e moderno

### 2. Sistema de Login
- Login diferenciado para funcionários e empresas
- Autenticação segura com hash de senhas
- Sessões com tokens únicos

### 3. Questionário de Clima Organizacional
- 5 perguntas principais com escala 1-5:
  - Comunicação interna
  - Ambiente de trabalho
  - Reconhecimento
  - Oportunidades de crescimento
  - Equilíbrio trabalho-vida pessoal
- Campo para sugestões e comentários
- Garantia de anonimato

### 4. Relatórios e Análises
- Médias por categoria
- Distribuição de respostas
- Análise de tendências
- Sugestões mais recentes
- Recomendações personalizadas

### 5. Soluções Propostas
- Soluções baseadas no feedback real
- Planos de ação específicos
- Sistema de feedback sobre as soluções

## Banco de Dados

### Tabelas Principais

1. **empresas**: Dados das empresas cadastradas
2. **funcionarios**: Dados dos funcionários
3. **questionarios**: Respostas dos questionários
4. **feedback_solucoes**: Feedback sobre soluções propostas
5. **sessoes**: Controle de sessões dos usuários

### Estrutura Automática
O sistema cria automaticamente:
- Banco de dados `verus_db`
- Todas as tabelas necessárias
- Dados de exemplo para teste

## Segurança

- **Senhas**: Armazenadas em texto simples (não hasheadas)
- **Sessões**: Tokens únicos com expiração
- **Anonimato**: Opção de respostas anônimas
- **Validação**: Validação de dados em frontend e backend
- **SQL Injection**: Proteção com prepared statements

## API Endpoints

### Autenticação
- `POST /api/login.php` - Login de usuários

### Questionários
- `POST /api/questionario.php` - Envio de questionários

### Feedback
- `POST /api/feedback.php` - Envio de feedback sobre soluções

### Relatórios
- `GET /api/relatorios.php` - Geração de relatórios

## Personalização e Extensões

### Adicionar Novas Perguntas
1. Edite o HTML do questionário em `assets/js/script.js`
2. Adicione a coluna correspondente no banco de dados
3. Atualize a API `questionario.php`

### Novas Categorias de Soluções
1. Adicione as soluções no JavaScript
2. Crie as categorias correspondentes no banco
3. Atualize a lógica de recomendações

### Integração com IA
Para implementar funcionalidades de IA:
1. Crie novos endpoints na pasta `api/`
2. Integre com serviços de IA externos
3. Adicione análise de sentimentos nos comentários

## Suporte e Manutenção

### Logs
- Erros são registrados no log do PHP
- Verifique `error_log` do servidor para problemas

### Backup
- Faça backup regular do banco de dados
- Mantenha cópia dos arquivos de configuração

### Atualizações
- Mantenha o PHP e MySQL atualizados
- Teste em ambiente de desenvolvimento antes de produção

## Licença

Este projeto foi desenvolvido para fins educacionais e comerciais. Consulte os termos de uso para mais informações.

## Contato

Para suporte técnico ou dúvidas:
- Email: contato@verus.com.br
- Telefone: (11) 9999-9999

---

**VERUS** - Transformando informações em ações estratégicas para um clima organizacional mais saudável e produtivo.
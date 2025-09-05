<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VERUS - Clima Organizacional</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">
                <h1>VERUS</h1>
            </div>
            <nav class="nav">
                <div class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
                <ul class="nav-menu">
                    <li><a href="#home" class="nav-link">Home</a></li>
                    <li><a href="#questionario" class="nav-link">Questionário</a></li>
                    <li><a href="#solucoes" class="nav-link">Soluções</a></li>
                </ul>
            </nav>
            <div class="login-btn">
                <button class="btn-login" onclick="openLoginModal()">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Home Section -->
        <section id="home" class="hero">
            <div class="container">
                <div class="hero-content">
                    <h2>Transforme Informações em Ações Estratégicas</h2>
                    <p class="hero-text">
                        Em um mercado cada vez mais dinâmico e competitivo, compreender o clima organizacional tornou-se essencial para o sucesso e a sustentabilidade das empresas. Nosso objetivo é promover uma cultura organizacional mais saudável, produtiva e alinhada aos valores da empresa, por meio de dados reais, obtidos diretamente da experiência dos profissionais que vivenciam o dia a dia da organização.
                    </p>
                    <p class="hero-text">
                        Explore nosso sistema, aplique diagnósticos e transforme informações em ações estratégicas!
                    </p>
                    <div class="cta-buttons">
                        <button class="btn-primary" onclick="openLoginModal()">
                            <i class="fas fa-chart-line"></i> Começar Diagnóstico
                        </button>
                        <button class="btn-secondary" onclick="scrollToSection('questionario')">
                            <i class="fas fa-clipboard-list"></i> Ver Questionário
                        </button>
                    </div>
                </div>
                <div class="hero-image">
                    <i class="fas fa-users-cog"></i>
                </div>
            </div>
        </section>

        <!-- Questionário Section -->
        <section id="questionario" class="questionario-section">
            <div class="container">
                <h2>Pesquisa de Clima Organizacional</h2>
                <div class="intro-text">
                    <p>Sua participação na pesquisa é essencial para entendermos o clima organizacional atual e identificar áreas que precisam ser melhoradas. Com essas informações, poderemos criar um ambiente de trabalho mais saudável, motivador e produtivo para todos.</p>
                </div>
                <div class="questionario-container">
                    <div class="login-required">
                        <i class="fas fa-lock"></i>
                        <h3>Login Necessário</h3>
                        <p>Para acessar o questionário, faça login como funcionário ou empresa.</p>
                        <button class="btn-primary" onclick="openLoginModal()">
                            <i class="fas fa-sign-in-alt"></i> Fazer Login
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Soluções Section -->
        <section id="solucoes" class="solucoes-section">
            <div class="container">
                <h2>Soluções Propostas</h2>
                <div class="intro-text">
                    <p>Apresentamos soluções de melhorias baseadas no feedback real dos colaboradores, customizadas para resolver os pontos mais críticos identificados em nossa pesquisa.</p>
                </div>
                <div class="solucoes-container">
                    <div class="login-required">
                        <i class="fas fa-building"></i>
                        <h3>Acesso Restrito</h3>
                        <p>Esta seção está disponível apenas para empresas logadas.</p>
                        <button class="btn-primary" onclick="openLoginModal()">
                            <i class="fas fa-sign-in-alt"></i> Login Empresa
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>VERUS</h3>
                    <p>Transformando o clima organizacional através de dados reais.</p>
                </div>
                <div class="footer-section">
                    <h4>Contato</h4>
                    <p><i class="fas fa-envelope"></i> contato@verus.com.br</p>
                    <p><i class="fas fa-phone"></i> (11) 9999-9999</p>
                </div>
                <div class="footer-section">
                    <h4>Redes Sociais</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Links Úteis</h4>
                    <ul>
                        <li><a href="#" onclick="showPrivacyPolicy()">Política de Privacidade</a></li>
                        <li><a href="#" onclick="showTerms()">Termos de Uso</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 VERUS. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Login Modal -->
    <div id="loginModal" class="modal">
        <div class="modal-content" id="login-modal-content">
            <span class="close" onclick="closeLoginModal()">&times;</span>
            <h2>Escolha seu tipo de acesso</h2>
            <div class="login-options" id="login-options">
                <div class="login-option" onclick="loginAs('funcionario')">
                    <i class="fas fa-user"></i>
                    <h3>Funcionário</h3>
                    <p>Responder questionário de clima organizacional</p>
                </div>
                <div class="login-option" onclick="loginAs('empresa')">
                    <i class="fas fa-building"></i>
                    <h3>Empresa</h3>
                    <p>Acessar relatórios e soluções</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Privacy Policy Modal -->
    <div id="privacyModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closePrivacyModal()">&times;</span>
            <h2>Política de Privacidade</h2>
            <div class="policy-content">
                <h3>1. Coleta de Dados</h3>
                <p>Coletamos apenas os dados necessários para a realização da pesquisa de clima organizacional.</p>
                
                <h3>2. Anonimato</h3>
                <p>Garantimos o anonimato dos participantes da pesquisa, preservando a confidencialidade das respostas.</p>
                
                <h3>3. Uso dos Dados</h3>
                <p>Os dados coletados são utilizados exclusivamente para análise do clima organizacional e geração de relatórios.</p>
                
                <h3>4. Segurança</h3>
                <p>Implementamos medidas de segurança para proteger os dados coletados contra acesso não autorizado.</p>
            </div>
        </div>
    </div>

    <!-- Terms Modal -->
    <div id="termsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeTermsModal()">&times;</span>
            <h2>Termos de Uso</h2>
            <div class="terms-content">
                <h3>1. Aceitação dos Termos</h3>
                <p>Ao utilizar o sistema VERUS, você concorda com estes termos de uso.</p>
                
                <h3>2. Uso Responsável</h3>
                <p>O sistema deve ser utilizado de forma responsável e ética, respeitando a privacidade dos participantes.</p>
                
                <h3>3. Confidencialidade</h3>
                <p>As informações obtidas através do sistema são confidenciais e devem ser tratadas com discrição.</p>
                
                <h3>4. Limitações</h3>
                <p>O VERUS não se responsabiliza por decisões tomadas com base nos relatórios gerados pelo sistema.</p>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>

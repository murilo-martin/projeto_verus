<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VERUS - Clima Organizacional</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>

</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="navbar w-100 d-flex justify-content-space-evenly">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasDarkNavbar"
                    aria-labelledby="offcanvasDarkNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Menu</h5>
                        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav d-flex flex-column gap-3">
                            <a class="nav-text" onclick="showModals('funcionario')">
                                <li class="nav-item">Login funcionario</li>
                            </a>
                            <a class="nav-text" onclick="showModals('empresa')">
                                <li class="nav-item">Login Empresa</li>
                            </a>
                            <a class="nav-text">
                                <li class="nav-item">Categorias de Feedback</li>
                            </a>
                        </ul>
                    </div>
                </div>
                <div class="logo">
                    <h1>VERUS</h1>
                </div>
                <div class="login-btn">
                    <button class="btn-login" onclick="openLoginModal('login')">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </div>
            </nav>
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
                        Em um mercado cada vez mais dinâmico e competitivo, compreender o clima organizacional tornou-se
                        essencial para o sucesso e a sustentabilidade das empresas. Nosso objetivo é promover uma
                        cultura organizacional mais saudável, produtiva e alinhada aos valores da empresa, por meio de
                        dados reais, obtidos diretamente da experiência dos profissionais que vivenciam o dia a dia da
                        organização.
                    </p>
                    <p class="hero-text">
                        Explore nosso sistema, aplique diagnósticos e transforme informações em ações estratégicas!
                    </p>
                    <div class="cta-buttons">
                        <button class="btn-primary">
                            <i class="fas fa-chart-line"></i>Ver Tipos de Feedbacks
                        </button>
                        <button class="btn-secondary" onclick="openLoginModal('register')">
                            <i class="fas fa-clipboard-list"></i>Cadastre-se
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
            <div class="container d-flex flex-column justify-content-center align-items-center">
                <h2>Pesquisa de Clima Organizacional</h2>
                <div class="intro-text">
                    <p>Sua participação na pesquisa é essencial para entendermos o clima organizacional atual e
                        identificar áreas que precisam ser melhoradas. Com essas informações, poderemos criar um
                        ambiente de trabalho mais saudável, motivador e produtivo para todos.</p>
                </div>
                <div class="card" style="width:60%">
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <div class="login-required">
                            <i class="fas fa-lock"></i>
                            <h3>Login Necessário</h3>
                            <p>Para acessar o questionário, faça login como funcionário ou empresa.</p>
                            <button class="btn-primary" onclick="openLoginModal('login')">
                                <svg xmlns="http://www.w3.org/2000/svg" height="44px" viewBox="0 -960 960 960"
                                    width="44px">
                                    <path
                                        d="M480-120v-80h280v-560H480v-80h280q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H480Zm-80-160-55-58 102-102H120v-80h327L345-622l55-58 200 200-200 200Z" />
                                </svg>
                                Fazer Login
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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
        <div id="modal" class="modal">
            <div class="modal-content" id="login-modal-content">

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
                    <p>Garantimos o anonimato dos participantes da pesquisa, preservando a confidencialidade das
                        respostas.
                    </p>

                    <h3>3. Uso dos Dados</h3>
                    <p>Os dados coletados são utilizados exclusivamente para análise do clima organizacional e geração
                        de
                        relatórios.</p>

                    <h3>4. Segurança</h3>
                    <p>Implementamos medidas de segurança para proteger os dados coletados contra acesso não autorizado.
                    </p>
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
                    <p>O sistema deve ser utilizado de forma responsável e ética, respeitando a privacidade dos
                        participantes.</p>

                    <h3>3. Confidencialidade</h3>
                    <p>As informações obtidas através do sistema são confidenciais e devem ser tratadas com discrição.
                    </p>

                    <h3>4. Limitações</h3>
                    <p>O VERUS não se responsabiliza por decisões tomadas com base nos relatórios gerados pelo sistema.
                    </p>
                </div>
            </div>
        </div>

        <script src="assets/js/script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"></script>

</body>

</html>
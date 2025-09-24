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
                <div class="login-btn">
                    <a href="index.php" style="text-decoration: none;">
                        <button class="btn-login">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                fill="#FFFFFF">
                                <path
                                    d="m480-320 56-56-64-64h168v-80H472l64-64-56-56-160 160 160 160Zm0 240q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                            </svg>Voltar
                        </button>
                    </a>
                </div>

                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasDarkNavbar"
                    aria-labelledby="offcanvasDarkNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Menu</h5>
                        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav d-flex flex-column gap-3">
                            <a href="typefeedback.php" class="nav-text">
                                <li class="nav-item">Categorias de Feedback</li>
                            </a>
                        </ul>
                    </div>
                </div>
                <div class="logo">
                    <h1>VERUS</h1>
                </div>

            </nav>
        </div>
        </div>

    </header>
    <main>
        <section class="hero">
            <div id="carouselExampleInterval" class="carousel slide w-100" style="height:40em; box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active"data-bs-interval="10000">
                        <div class="row" style="height:40em">
                            <div class="col d-flex justify-content-center align-items-center" >AAAAAAAAAAAAAAAAAAAAAAAAAA</div>
                            <div class="col d-flex justify-content-center align-items-center">BBBBBBBBBBBBBBBBBBBBBB</div>
                        </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                        <div class="row" style="height:40em">
                            <div class="col d-flex justify-content-center align-items-center">AAAAAAAAAAAAAAAAAAAAAAAAAA</div>
                            <div class="col d-flex justify-content-center align-items-center">BBBBBBBBBBBBBBBBBBBBBB</div>
                        </div>
                    </div>
                    <div class="carousel-item">
                       <div class="row"  style="height:40em">
                            <div class="col d-flex justify-content-center align-items-center">AAAAAAAAAAAAAAAAAAAAAAAAAA</div>
                            <div class="col d-flex justify-content-center align-items-center">BBBBBBBBBBBBBBBBBBBBBB</div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>
    </main>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>
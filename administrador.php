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
    <link rel="shortcut icon" type="image/x-icon" href="logo.jpeg">
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

        <section class="panel-control">
            <div class="title-panel">Painel de Controle</div>
            <div class="d-flex align-items-center justify-content-center gap-3 w-100 h-100">
                <div class="container-feedback" onclick="showModalEditQuestion()">Trocar Perguntas</div>
                <div class="container-feedback" onclick="showModalCrud()">Controle de empresas</div>
                <div class="container-feedback" onclick="showmodalTruncate()">Zerar Relatorios</div>
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
    <div id="modal-feed" class="modal-feed">
        <div class="modal-content-feed">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="title"></h2>
            <div class="text" id="text">

            </div>
        </div>
    </div>
    <!-- Modal Alterar -->
    <div class="modal fade" id="modal_question" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content" style="max-width:1440px">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Trocar perguntas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_quest" class="needs-validation" novalidate>
                    <div class="modal-body-question" id="modalQuestion_body">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Editar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal de zerar Banco -->
    <div class="modal fade " id="modal_truncate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="max-width:1440px">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Zerar as perguntas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_zerar" class="needs-validation" novalidate>
                    <div class="modal-body" id="modalTruncate_body">
                        <p style="font-weight:bold;">Tem certeza que deseja zerar todas as respostas?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="administrador.php"><button type="button" class="btn btn-danger">Cancelar</button></a>
                        <button type="submit" class="btn btn-success">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal de gerenciamento -->
    <div class="modal fade " id="modal_crud" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content" style="max-width:1440px">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Gerenciar empresas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_crud" class="needs-validation" novalidate>
                    <div class="modal-body-crud" >
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>CNPJ</th><th>Nome da empresa</th><th>Setor</th><th>Email</th><th>Senha</th><th>Ativo</th><th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="modalcrud_body">

                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de delete -->
     <div class="modal fade " id="modal_delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Desativar empresa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_del" class="needs-validation" novalidate>
                    <div class="modal-body" id="modaldelete_body">
                        <p style="font-weight:bold;">Tem certeza que deseja desativar essa empresa?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="closeModal('del')">Cancelar</button>
                        <button type="submit" class="btn btn-success">Confirmar</button>
                    </div>
                    <input type="hidden" id="id_emp">
                </form>
            </div>
        </div>
    </div>

    <!-- Modal edit -->
     <div class="modal fade " id="modal_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar item</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_edit" class="needs-validation" novalidate>
                    <div class="modal-body" id="modalEdit_body">
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="closeModal('edit')">Cancelar</button>
                        <button type="submit" class="btn btn-success">Confirmar</button>
                    </div>
                    <input type="hidden" id="id_emp">
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="assets/js/showModal.js"></script>
</body>

</html>
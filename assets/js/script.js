// Variáveis globais
let currentUserType = null;
let currentUser = null;

// Inicialização quando o DOM estiver carregado
$(document).ready(function () {
  initializeApp();
});

// Função de inicialização
function initializeApp() {
  setupEventListeners();
  setupSmoothScrolling();
  setupMobileMenu();
  checkUserSession();
}

// Configurar event listeners
function setupEventListeners() {
  // Fechar modais ao clicar fora
  $(window).click(function (event) {
    if (event.target.classList.contains("modal")) {
      closeAllModals();
    }
  });

  // Fechar modais com ESC
  $(document).keydown(function (event) {
    if (event.key === "Escape") {
      closeAllModals();
    }
  });

  // Navegação suave
  $(".nav-link").click(function (e) {
    e.preventDefault();
    const target = $(this).attr("href");
    scrollToSection(target);
  });
}

// Configurar scroll suave
function setupSmoothScrolling() {
  $('a[href^="#"]').click(function (e) {
    e.preventDefault();
    const target = $(this).attr("href");
    scrollToSection(target);
  });
}

// Configurar menu mobile
function setupMobileMenu() {
  $(".menu-toggle").click(function () {
    $(".nav-menu").toggleClass("active");
  });

  // Fechar menu ao clicar em um link
  $(".nav-link").click(function () {
    $(".nav-menu").removeClass("active");
  });
}

// Verificar sessão do usuário
function checkUserSession() {
  const userType = localStorage.getItem("userType");
  const userData = localStorage.getItem("userData");

  if (userType && userData) {
    currentUserType = userType;
    currentUser = JSON.parse(userData);
    updateUIForLoggedUser();
  }
}

// Atualizar UI para usuário logado
function updateUIForLoggedUser() {
  if (currentUserType === "funcionario") {
    updateQuestionarioSection();
  } else if (currentUserType === "empresa") {
    updateSolucoesSection();
  }
}

// Funções de Modal
function openLoginModal(tipo) {
  typeModal(tipo);
  $("#modal").fadeIn(300);
  $("body").addClass("modal-open");
}

function typeModal(type) {
  let titulo = type == "login" ? "Acesso" : "Cadastro";
  let textoFunc =
    type == "login"
      ? "Responder questionário de clima organizacional"
      : "Cadastre-se como funcionario";
  let textoEmp =
    type == "login"
      ? "Acessar relatorios de sua emrpresa"
      : "Cadastre-se sua empresa";

  let textModal = `
            <span class="close" onclick="closeLoginModal()">&times;</span>
            <h2 id="tituloModal">Escolha seu tipo de ${titulo}</h2>
            <div class="login-options" id="login-options">
                <div class="login-option" onclick="loginAs('funcionario','${type}')">
                    <i class="fas fa-user"></i>
                    <h3>Funcionário</h3>
                    <p>${textoFunc}</p>
                </div>
                <div class="login-option" onclick="loginAs('empresa','${type}')">
                    <i class="fas fa-building"></i>
                    <h3>Empresa</h3>
                    <p>${textoEmp}</p>
                </div>
            </div>`;

  $("#login-modal-content").html(textModal);
}

function closeLoginModal() {
  $("#modal").fadeOut(300, function () {
    $("#login-modal-content").html(`
        <span class="close" onclick="closeLoginModal()">&times;</span>
            <h2 id='tituloModal'>Escolha seu tipo de acesso</h2>
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
    `);
    $("body").removeClass("modal-open");
  });
}

function closePrivacyModal() {
  $("#privacyModal").fadeOut(300);
  $("body").removeClass("modal-open");
}

function closeTermsModal() {
  $("#termsModal").fadeOut(300);
  $("body").removeClass("modal-open");
}

function closeAllModals() {
  $(".modal").fadeOut(300);
  $("body").removeClass("modal-open");
}

// Funções de Política e Termos
function showPrivacyPolicy() {
  $("#privacyModal").fadeIn(300);
  $("body").addClass("modal-open");
}

function showTerms() {
  $("#termsModal").fadeIn(300);
  $("body").addClass("modal-open");
}

// Função de login
function loginAs(userType, type) {
  currentUserType = userType;
  let modal = $("#login-options");

  if (userType === "funcionario") {
    showFuncionarioLogin(type);
    modal.removeClass("login-options");
    modal.addClass("login-options-emp");
  } else if (userType === "empresa") {
    showEmpresaLogin(type);

    modal.removeClass("login-options");
    modal.addClass("login-options-emp");
  }
}

function showModals(tipo) {
  $("#loginModal").fadeIn(300);
  $("body").addClass("modal-open");
  loginAs(tipo);
  document.getElementById("btncancel").style.display = "none";
}
let typeForm = "";
// Mostrar formulário de login para funcionário
function showFuncionarioLogin(type) {
  typeForm = type == "login" ? "Login" : "Cadastro";
  document.getElementById("tituloModal").innerHTML = "";

  const loginHTML = `
        <div class="login-form">
            <h3>${typeForm} Funcionário</h3>
            <form id="funcionarioLoginForm">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                <div class="form-actions">
                    <button type="button" id='btncancel' class="btn-primary" onclick="typeModal('${type}')">Cancelar</button>
                    <button type="submit" class="btn-secondary">Entrar</button>
                </div>
            </form>
        </div>
    `;

  const registerHTML = `
        <div class="login-form">
            <h3>${typeForm} Funcionário</h3>
            <form id="funcionarioLoginForm">
                <div class="form-group">
                    <label for="nome">nome:</label>
                    <input type="text" id="nome_regi" name="nome" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email_regi" name="email" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha_regi" name="senha" required>
                </div>
                <div class="form-group">
                    <label for="cpf">CPF:</label>
                    <input type="text" id="cpf_regi" name="cpf" required>
                </div>
                <div class="form-group">
                    <label for="cargo">Cargo:</label>
                    <input type="text" id="cargo_regi" name="cargo" required>
                </div>
                
                <div class="form-floating">
                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                        <option selected disabled></option>
                        
                        </select>
                    <label for="floatingSelect">Selecione a sua empresa</label>
                </div>
                <div class="form-actions">
                    <button type="button" id='btncancel' class="btn-primary" onclick="typeModal('${type}')">Cancelar</button>
                    <button type="submit" class="btn-secondary">Cadastrar</button>
                </div>
            </form>
        </div>
    `;
    
  if (type == "login") {
    $(".login-options").html(loginHTML);
  } else if (type == "register") {
    $(".login-options").html(registerHTML);
    new Cleave('#cpf_regi', {
                delimiters: ['.', '.', '-'],
                blocks: [3, 3, 3, 2],
                uppercase: true
            });


    $.ajax({
      url: "api/companies.php",
      method: "post",
      data: {},
      success: function (text) {
        console.log(text)
        $('#floatingSelect').html(text);
      },
    });
  }
  setupFuncionarioLoginForm(type);
}

// Mostrar formulário de login para empresa
function showEmpresaLogin(type) {
  typeForm = type == "login" ? "Login" : "Cadastro";
  document.getElementById("tituloModal").innerHTML = "";
  const loginHTML = `
        <div class="login-form">
            <h3>${typeForm} Empresa</h3>
            <form id="empresaLoginForm">
                <div class="form-group">
                    <label for="cnpj">CNPJ:</label>
                    <input type="text" id="cnpj" name="cnpj" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                <div class="form-actions">
                    <button type="button" id='btncancel' class="btn-primary" onclick="typeModal('${type}')">Cancelar</button>
                    <button type="submit" class="btn-secondary">Entrar</button>
                </div>
            </form>
        </div>
    </div>
    `;


  const registerHTML = `
        <div class="login-form">
            <h3>${typeForm} Empresa</h3>
            <form id="empresaLoginForm">
                <div class="form-group">
                    <label for="cnpj">Cnpj:</label>
                    <input type="text" id="cnpj_regi_emp" name="cnpj" required>
                </div>
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="nome" id="nome_regi_emp" name="nome" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="senha" id="senha_regi_emp" name="senha" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email_regi_emp" name="email" required>
                </div>
                <div class="form-floating">
                    <select class="form-select" id="floatingSelectEmp" aria-label="Floating label select example">
                        <option selected hidden></option>
                        <option value="ti">Tecnologia</option>
                        <option value="alimentacao">Alimentação e Bebidas</option>
                        <option value="varejo">Varejo</option>
                        <option value="financeiro">Serviços Financeiros (Bancos, Seguros)</option>
                        <option value="telecom">Telecomunicações</option>
                        <option value="turismo">Turismo e Hotelaria</option>
                        <option value="transporte">Transporte e Logística</option>
                        <option value="moda">Moda e Vestuário</option>
                        <option value="imobiliario">Imobiliário</option>
                        <option value="quimica">Química e Petroquímica</option>
                        <option value="mineracao">Mineração</option>
                        <option value="Outro">Outro</option>
                    </select>
                    <label for="floatingSelect">Selecione o seu setor</label>
                </div>
                <div class="form-actions">
                    <button type="button" id='btncancel' class="btn-primary" onclick="typeModal('${type}')">Cancelar</button>
                    <button type="submit" class="btn-secondary">Cadastrar</button>
                </div>
            </form>
        </div>
    `;
  if (type == "login") {
    $(".login-options").html(loginHTML);
    new Cleave('#cnpj', {
                delimiters: ['.', '.', '/','-'],
                blocks: [2, 3, 3, 4, 2],
                uppercase: true
            });
  } else if (type == "register") {
    $(".login-options").html(registerHTML);
new Cleave('#cnpj_regi_emp', {
                delimiters: ['.', '.', '/','-'],
                blocks: [2, 3, 3, 4, 2],
                uppercase: true
            });

    $.ajax({
      url: "api/companies.php",
      method: "post",
      data: {},
      success: function (text) {
        console.log(text)
        $('#floatingSelect').html(text);
      },
    });
  }

  setupEmpresaLoginForm(type);
}


// Configurar formulário de login do funcionário
function setupFuncionarioLoginForm(type) {
  if(type == 'login')  
    $("#funcionarioLoginForm").submit(function (e) {
    e.preventDefault();

    const email = $("#email").val();
    const senha = $("#senha").val();
    if (!email || !senha) {
      showErrorMessage("Por favor, preencha todos os campos.");
      return;
    }
    // Chamada AJAX para login
    $.ajax({
      url: "api/login.php",
      method: "POST",
      data:{
        tipo: "funcionario",
        email: email,
        senha: senha,
      },
      success: function (response) {
        
        if(response == 'sucesso'){
          // Salvar dados do usuário no localStorage
          const userData = {
            id: email, // Usando email como ID temporário
            email: email,
            tipo: 'funcionario'
          };
          localStorage.setItem('userData', JSON.stringify(userData));
          localStorage.setItem('userType', 'funcionario');
          
          closeLoginModal();
          showSuccessMessage(
            "Login realizado com sucesso! Redirecionando para o questionário..."
          );
          
          // Redirecionar para a página do questionário após 1 segundo
          setTimeout(function () {
            window.location.href = "questionario.php";
          }, 1000);

        }else if(response == 'erro'){

            showErrorMessage("Email não cadastrado");

        }else{

            showErrorMessage("Senha errada");
        }
      },
      error: function (xhr) {
        const response = JSON.parse(xhr.responseText);
        showErrorMessage(response.error || "Erro no servidor");
      },
    });
  });

  else{

    $("#funcionarioLoginForm").submit(function (e) {
    e.preventDefault();

    const cargo = $("#cargo_regi").val();
    const nome = $("#nome_regi").val();
    const email = $("#email_regi").val();
    const senha = $("#senha_regi").val();
    const cpf = $("#cpf_regi").val();
    const empresa_select= $("#floatingSelect").val();

    // Chamada AJAX para login
    $.ajax({
      url: "api/register.php",
      method: "POST",
      data:{
        tipo: "funcionario",
        email: email,
        senha: senha,
        cpf: cpf,
        empresa: empresa_select,
        cargo: cargo,
        nome: nome
      },
      success: function (response) {

        console.log(response);
          closeLoginModal();
          showSuccessMessage(
            "Cadastro realizado com SUCESSO"
          )

      },
      error: function (xhr) {
        const response = JSON.parse(xhr.responseText);
        showErrorMessage(response.error || "Erro no servidor");
      },
    });
  });

  }
}

// Configurar formulário de login da empresa
function setupEmpresaLoginForm(type) {
  
  if(type == 'login'){  
    
    $("#empresaLoginForm").submit(function (e) {
    e.preventDefault();

    const cnpj = $("#cnpj").val();
    const senha = $("#senha").val();

    if (!cnpj || !senha) {
      showErrorMessage("Por favor, preencha todos os campos.");
      return;
    }

    // Chamada AJAX para login
    $.ajax({
      url: "api/login.php",
      method: "POST",
      data: {
        tipo: "empresa",
        cnpj: cnpj,
        senha: senha,
      },
      success: function (response) {
       
          closeLoginModal();
          showSuccessMessage(
            "Login realizado com sucesso! Redirecionando para os relatórios..."
          );

          // Redirecionar para a página de relatórios após 1 segundo
          setTimeout(function () {
            window.location.href = "relatorios.php";
          }, 1000);
      },
      error: function (xhr) {
        const response = JSON.parse(xhr.responseText);
        showErrorMessage(response.error || "Erro no servidor");
      },
    });
  });
    }else{

$("#empresaLoginForm").submit(function (e) {
    e.preventDefault();

    const cnpj = $("#cnpj_regi_emp").val();
    const senha = $("#senha_regi_emp").val();
    const setor = $("#floatingSelectEmp").val();
    const nome = $("#nome_regi_emp").val();
    const email = $("#email_regi_emp").val();
    // Chamada AJAX para login
    $.ajax({
      url: "api/register.php",
      method: "POST",
      data:{
        tipo: "empresa",
        cnpj: cnpj,
        senha: senha,
        nome: nome,
        setor: setor,
        email: email
      },
      success: function (response) {
        
          closeLoginModal();
          showSuccessMessage(
            "Cadastro realizado com sucesso!"
          );

      },
      error: function (xhr) {
        const response = JSON.parse(xhr.responseText);
        showErrorMessage(response.error || "Erro no servidor");
      },
    });
  });

}
}
//Masks

// Atualizar seção do questionário
function updateQuestionarioSection() {
  const questionarioHTML = `
        <div class="questionario-content">
            <div class="questionario-intro">
                <h3>Pesquisa de Clima Organizacional</h3>
                <p>Sua participação na pesquisa é essencial para entendermos o clima organizacional atual e identificar áreas que precisam ser melhoradas. Com essas informações, poderemos criar um ambiente de trabalho mais saudável, motivador e produtivo para todos.</p>
                
                <div class="anonymity-notice">
                    <i class="fas fa-shield-alt"></i>
                    <h4>Anonimato Garantido</h4>
                    <p>Sua participação é totalmente anônima. As informações coletadas serão tratadas com confidencialidade e utilizadas apenas para análise do clima organizacional.</p>
                </div>
            </div>
            
            <form id="questionarioForm" class="questionario-form">
                <div class="question-group">
                    <h4>1. Como você avalia a comunicação interna na empresa?</h4>
                    <div class="rating-scale">
                        <label><input type="radio" name="comunicacao" value="1"> 1 - Muito insatisfeito</label>
                        <label><input type="radio" name="comunicacao" value="2"> 2 - Insatisfeito</label>
                        <label><input type="radio" name="comunicacao" value="3"> 3 - Neutro</label>
                        <label><input type="radio" name="comunicacao" value="4"> 4 - Satisfeito</label>
                        <label><input type="radio" name="comunicacao" value="5"> 5 - Muito satisfeito</label>
                    </div>
                </div>
                
                <div class="question-group">
                    <h4>2. Como você avalia o ambiente de trabalho?</h4>
                    <div class="rating-scale">
                        <label><input type="radio" name="ambiente" value="1"> 1 - Muito insatisfeito</label>
                        <label><input type="radio" name="ambiente" value="2"> 2 - Insatisfeito</label>
                        <label><input type="radio" name="ambiente" value="3"> 3 - Neutro</label>
                        <label><input type="radio" name="ambiente" value="4"> 4 - Satisfeito</label>
                        <label><input type="radio" name="ambiente" value="5"> 5 - Muito satisfeito</label>
                    </div>
                </div>
                
                <div class="question-group">
                    <h4>3. Como você avalia o reconhecimento pelo trabalho realizado?</h4>
                    <div class="rating-scale">
                        <label><input type="radio" name="reconhecimento" value="1"> 1 - Muito insatisfeito</label>
                        <label><input type="radio" name="reconhecimento" value="2"> 2 - Insatisfeito</label>
                        <label><input type="radio" name="reconhecimento" value="3"> 3 - Neutro</label>
                        <label><input type="radio" name="reconhecimento" value="4"> 4 - Satisfeito</label>
                        <label><input type="radio" name="reconhecimento" value="5"> 5 - Muito satisfeito</label>
                    </div>
                </div>
                
                <div class="question-group">
                    <h4>4. Como você avalia as oportunidades de crescimento na empresa?</h4>
                    <div class="rating-scale">
                        <label><input type="radio" name="crescimento" value="1"> 1 - Muito insatisfeito</label>
                        <label><input type="radio" name="crescimento" value="2"> 2 - Insatisfeito</label>
                        <label><input type="radio" name="crescimento" value="3"> 3 - Neutro</label>
                        <label><input type="radio" name="crescimento" value="4"> 4 - Satisfeito</label>
                        <label><input type="radio" name="crescimento" value="5"> 5 - Muito satisfeito</label>
                    </div>
                </div>
                
                <div class="question-group">
                    <h4>5. Como você avalia o equilíbrio entre trabalho e vida pessoal?</h4>
                    <div class="rating-scale">
                        <label><input type="radio" name="equilibrio" value="1"> 1 - Muito insatisfeito</label>
                        <label><input type="radio" name="equilibrio" value="2"> 2 - Insatisfeito</label>
                        <label><input type="radio" name="equilibrio" value="3"> 3 - Neutro</label>
                        <label><input type="radio" name="equilibrio" value="4"> 4 - Satisfeito</label>
                        <label><input type="radio" name="equilibrio" value="5"> 5 - Muito satisfeito</label>
                    </div>
                </div>
                
                <div class="question-group">
                    <h4>6. Sugestões e Comentários</h4>
                    <textarea name="sugestoes" placeholder="Compartilhe suas sugestões, críticas construtivas ou observações sobre o clima organizacional da empresa..." rows="5"></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-paper-plane"></i> Enviar Questionário
                    </button>
                </div>
            </form>
        </div>
    `;

  $(".questionario-container").html(questionarioHTML);
  setupQuestionarioForm();
}

// Atualizar seção de soluções
function updateSolucoesSection() {
  const solucoesHTML = `
        <div class="solucoes-content">
            <div class="solucoes-intro">
                <h3>Análise e Soluções Propostas</h3>
                <p>Com base no feedback coletado dos colaboradores, identificamos as principais áreas de melhoria e propomos as seguintes soluções:</p>
            </div>
            
            <div class="solucoes-grid">
                <div class="solucao-card">
                    <div class="solucao-header">
                        <i class="fas fa-comments"></i>
                        <h4>Comunicação Interna</h4>
                    </div>
                    <div class="solucao-content">
                        <p><strong>Problema identificado:</strong> Falta de transparência e frequência na comunicação.</p>
                        <div class="solucoes-propostas">
                            <h5>Soluções Propostas:</h5>
                            <ul>
                                <li>Implementar reuniões semanais de alinhamento</li>
                                <li>Criar newsletter interna mensal</li>
                                <li>Estabelecer canais de feedback anônimo</li>
                            </ul>
                        </div>
                        <div class="acoes-futuras">
                            <h5>Plano de Ação:</h5>
                            <p>Implementação em 30 dias com acompanhamento mensal dos resultados.</p>
                        </div>
                    </div>
                </div>
                
                <div class="solucao-card">
                    <div class="solucao-header">
                        <i class="fas fa-trophy"></i>
                        <h4>Reconhecimento</h4>
                    </div>
                    <div class="solucao-content">
                        <p><strong>Problema identificado:</strong> Falta de reconhecimento pelo trabalho realizado.</p>
                        <div class="solucoes-propostas">
                            <h5>Soluções Propostas:</h5>
                            <ul>
                                <li>Programa de reconhecimento mensal</li>
                                <li>Sistema de feedback positivo entre pares</li>
                                <li>Reuniões individuais de desenvolvimento</li>
                            </ul>
                        </div>
                        <div class="acoes-futuras">
                            <h5>Plano de Ação:</h5>
                            <p>Desenvolvimento do programa em 45 dias com lançamento em 60 dias.</p>
                        </div>
                    </div>
                </div>
                
                <div class="solucao-card">
                    <div class="solucao-header">
                        <i class="fas fa-chart-line"></i>
                        <h4>Crescimento Profissional</h4>
                    </div>
                    <div class="solucao-content">
                        <p><strong>Problema identificado:</strong> Poucas oportunidades de crescimento e desenvolvimento.</p>
                        <div class="solucoes-propostas">
                            <h5>Soluções Propostas:</h5>
                            <ul>
                                <li>Programa de mentoria interna</li>
                                <li>Plano de desenvolvimento individual</li>
                                <li>Investimento em treinamentos e cursos</li>
                            </ul>
                        </div>
                        <div class="acoes-futuras">
                            <h5>Plano de Ação:</h5>
                            <p>Desenvolvimento do programa em 90 dias com acompanhamento trimestral.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="feedback-section">
                <h4>Feedback sobre as Soluções</h4>
                <form id="feedbackForm" class="feedback-form">
                    <div class="form-group">
                        <label for="feedback">Compartilhe sua opinião sobre as soluções propostas:</label>
                        <textarea id="feedback" name="feedback" rows="4" placeholder="Sua opinião é importante para melhorarmos as propostas..."></textarea>
                    </div>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-comment"></i> Enviar Feedback
                    </button>
                </form>
            </div>
        </div>
    `;

  $(".solucoes-container").html(solucoesHTML);
  setupFeedbackForm();
}

// Configurar formulário do questionário
function setupQuestionarioForm() {
  $("#questionarioForm").submit(function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = Object.fromEntries(formData);

    // Validar se pelo menos uma pergunta foi respondida
    const hasAnswers = Object.keys(data).some(
      (key) => key !== "sugestoes" && data[key]
    );

    if (!hasAnswers) {
      showErrorMessage(
        "Por favor, responda pelo menos uma pergunta do questionário."
      );
      return;
    }

    // Preparar dados para envio
    const questionarioData = {
      funcionario_id: currentUser ? currentUser.id : null,
      empresa_id: currentUser ? currentUser.empresa_id : null,
      comunicacao: data.comunicacao || null,
      ambiente: data.ambiente || null,
      reconhecimento: data.reconhecimento || null,
      crescimento: data.crescimento || null,
      equilibrio: data.equilibrio || null,
      sugestoes: data.sugestoes || "",
      anonimo: true,
    };

    // Chamada AJAX para envio do questionário
    $.ajax({
      url: "api/questionario.php",
      method: "POST",
      contentType: "application/json",
      data: JSON.stringify(questionarioData),
      success: function (response) {
        if (response.success) {
          showSuccessMessage(
            "Questionário enviado com sucesso! Obrigado pela sua participação."
          );
          $("#questionarioForm")[0].reset();
        } else {
          showErrorMessage(response.error || "Erro ao enviar questionário");
        }
      },
      error: function (xhr) {
        const response = JSON.parse(xhr.responseText);
        showErrorMessage(response.error || "Erro no servidor");
      },
    });
  });
}

// Configurar formulário de feedback
function setupFeedbackForm() {
  $("#feedbackForm").submit(function (e) {
    e.preventDefault();

    const feedback = $("#feedback").val().trim();

    if (!feedback) {
      showErrorMessage("Por favor, escreva seu feedback.");
      return;
    }

    // Preparar dados para envio
    const feedbackData = {
      empresa_id: currentUser ? currentUser.id : null,
      funcionario_id: currentUser ? currentUser.id : null,
      feedback: feedback,
      categoria: "Geral",
      anonimo: true,
    };

    // Chamada AJAX para envio do feedback
    $.ajax({
      url: "api/feedback.php",
      method: "POST",
      contentType: "application/json",
      data: JSON.stringify(feedbackData),
      success: function (response) {
        if (response.success) {
          showSuccessMessage(
            "Feedback enviado com sucesso! Obrigado pela sua contribuição."
          );
          $("#feedbackForm")[0].reset();
        } else {
          showErrorMessage(response.error || "Erro ao enviar feedback");
        }
      },
      error: function (xhr) {
        const response = JSON.parse(xhr.responseText);
        showErrorMessage(response.error || "Erro no servidor");
      },
    });
  });
}

// Funções de navegação
function scrollToSection(sectionId) {
  const target = $(sectionId);
  if (target.length) {
    $("html, body").animate(
      {
        scrollTop: target.offset().top - 80,
      },
      800
    );
  }
}

// Funções de mensagem
function showSuccessMessage(message) {
  showMessage(message, "success");
}

function showErrorMessage(message) {
  showMessage(message, "error");
}

function showMessage(message, type) {
  const messageClass = type === "success" ? "success-message" : "error-message";
  const icon =
    type === "success" ? "fas fa-check-circle" : "fas fa-exclamation-circle";

  const messageHTML = `
        <div class="message ${messageClass}">
            <i class="${icon}"></i>
            <span>${message}</span>
        </div>
    `;

  $("body").append(messageHTML);

  setTimeout(() => {
    $(".message").fadeOut(300, function () {
      $(this).remove();
    });
  }, 3000);
}

// Logout
function logout() {
  localStorage.removeItem("userType");
  localStorage.removeItem("userData");
  currentUserType = null;
  currentUser = null;

  // Recarregar página para resetar o estado
  location.reload();
}

// Adicionar estilos CSS dinâmicos para mensagens
const messageStyles = `
    <style>
        .message {
            position: fixed;
            top: 100px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 5px;
            color: white;
            font-weight: 500;
            z-index: 3000;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideInRight 0.3s ease;
        }
        
        .success-message {
            background-color: #28a745;
        }
        
        .error-message {
            background-color: #dc3545;
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .login-form {
            text-align: left;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #333;
        }
        
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #87CEEB;
            box-shadow: 0 0 5px rgba(135, 206, 235, 0.3);
        }
        
        .form-actions {
            display: flex;
            gap: 20px;
            justify-content:center;
            margin-top: 20px;
        }
        
        .questionario-content {
            text-align: left;
        }
        
        .questionario-intro {
            margin-bottom: 40px;
        }
        
        .anonymity-notice {
            background: #f8f9fa;
            border-left: 4px solid #87CEEB;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .anonymity-notice i {
            color: #87CEEB;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }
        
        .question-group {
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        
        .question-group h4 {
            color: #333;
            margin-bottom: 15px;
        }
        
        .rating-scale {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .rating-scale label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 8px;
            border-radius: 5px;
            transition: background-color 0.2s;
        }
        
        .rating-scale label:hover {
            background-color: #e9ecef;
        }
        
        .rating-scale input[type="radio"] {
            margin: 0;
        }
        
        .question-group textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            resize: vertical;
            font-family: inherit;
        }
        
        .solucoes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin: 40px 0;
        }
        
        .solucao-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid #87CEEB;
        }
        
        .solucao-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .solucao-header i {
            font-size: 2rem;
            color: #87CEEB;
        }
        
        .solucao-header h4 {
            color: #333;
            margin: 0;
        }
        
        .solucoes-propostas,
        .acoes-futuras {
            margin: 20px 0;
        }
        
        .solucoes-propostas h5,
        .acoes-futuras h5 {
            color: #87CEEB;
            margin-bottom: 10px;
        }
        
        .solucoes-propostas ul {
            list-style: none;
            padding-left: 0;
        }
        
        .solucoes-propostas li {
            padding: 5px 0;
            position: relative;
            padding-left: 20px;
        }
        
        .solucoes-propostas li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #87CEEB;
            font-weight: bold;
        }
        
        .feedback-section {
            margin-top: 40px;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        
        .feedback-section h4 {
            color: #333;
            margin-bottom: 20px;
        }
        
        .modal-open {
            overflow: hidden;
        }
    </style>
`;

// Adicionar estilos ao head
$("head").append(messageStyles);

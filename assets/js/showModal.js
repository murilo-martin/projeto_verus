const modal_question = new bootstrap.Modal("#modal_question");
const modal_trunc = new bootstrap.Modal("#modal_truncate");
const modal_crud = new bootstrap.Modal("#modal_crud");
const modal_del = new bootstrap.Modal("#modal_delete");
const modal_edit = new bootstrap.Modal("#modal_edit");

function showModalEditQuestion() {
  modal_question.show();

  $.ajax({
    // Chama o arquivo que pega as informações
    url: "api/puxarInfo_question.php",
    // Define o method
    method: "post",
    // Valores de "input"
    success: function (data) {
      $("#modalQuestion_body").html(data);
    },
  });
}
function showModalCrud() {
  modal_crud.show();

  $.ajax({
    // Chama o arquivo que pega as informações
    url: "api/puxarInfo_crud.php",
    method: "post",
    success: function (data) {
      $("#modalcrud_body").html(data);
    },
  });
}
function showDeleteModal(id) {
  document.getElementById("id_emp").value = id;

  modal_del.show();
}
function showEditModal(id) {
  document.getElementById("id_emp").value = id;
  modal_edit.show();
  $.ajax({
    url: "api/editEmp.php",
    method: "post",
    data:{

        id: id,

    },
    success: function (data){

       $("#modalEdit_body").html(data);
    },
  });
}

function showmodalTruncate() {
  modal_trunc.show();
}
document.getElementById("form_del").addEventListener("submit", (event) => {
  event.preventDefault();

  $.ajax({
    url: "api/deleteEmp.php",
    method: "post",
    data: {
      id: document.getElementById("id_emp").value,
    },
    success: function () {
      showModalCrud()
      modal_del.hide();
      showSuccessMessage("Empresa deletada com sucesso!");

    },
  });
});
document.getElementById("form_edit").addEventListener("submit", (event) => {
  event.preventDefault();

  let cnpj = document.getElementById("cnpj_emp").value;
  let nome = document.getElementById("nome_emp").value;
  let email = document.getElementById("email_emp").value;
  let senha = document.getElementById("senha_emp").value;
  let setor = document.getElementById("setor_emp").value;
  let ativo = document.getElementById("ativo_emp").value;

  $.ajax({
    url: "api/editEmpAPI.php",
    method: "post",
    data: {
      id: document.getElementById("id_emp").value,
      cnpj_emp:cnpj,
      nome_emp:nome,
      email_emp:email,
      senha_emp:senha,
      setor_emp:setor,
      ativo_emp:ativo,

    },
    success: function () {
      showModalCrud()
      modal_edit.hide();
      showSuccessMessage("Empresa editada com sucesso!");

    },
  });
});
document.getElementById("form_zerar").addEventListener("submit", (event) => {
  event.preventDefault();

  $.ajax({
    url: "api/zerarResponses.php",
    method: "post",
    success: function () {
      showSuccessMessage("Relatorios zerados!");
      modal_trunc.hide();
    },
  });
});

document.getElementById("form_quest").addEventListener("submit", (event) => {
  event.preventDefault();

  pergunta1 = document.getElementById("pergunta-1").value;
  pergunta2 = document.getElementById("pergunta-2").value;
  pergunta3 = document.getElementById("pergunta-3").value;
  pergunta4 = document.getElementById("pergunta-4").value;
  pergunta5 = document.getElementById("pergunta-5").value;
  pergunta6 = document.getElementById("pergunta-6").value;
  pergunta7 = document.getElementById("pergunta-7").value;
  pergunta8 = document.getElementById("pergunta-8").value;
  pergunta9 = document.getElementById("pergunta-9").value;
  pergunta10 = document.getElementById("pergunta-10").value;

  $.ajax({
    url: "api/editQuestion.php",
    method: "post",
    data: {
      primeira: pergunta1,
      segunda: pergunta2,
      terceira: pergunta3,
      quarta: pergunta4,
      quinta: pergunta5,
      sexta: pergunta6,
      setima: pergunta7,
      oitava: pergunta8,
      nona: pergunta9,
      decima: pergunta10,
    },
    success: function (data) {
      showSuccessMessage("Editado com sucesso!");
      modal_question.hide();
    },
  });
});


function showmodal(titulo, texto) {
  $("#title").html(titulo);
  $("#text").html(texto);

  $("#modal-feed").css("display", "flex").hide().fadeIn(300);

  $("body").addClass("modal-open");
}
function closeModalSimple() {
  $("#modal-feed").fadeOut(300);
  $("#title").html("");
}

function closeModal(type) {
    if(type == "edit"){
        modal_edit.hide();
    }else if(type == "del"){
        modal_del.hide();
    }
}
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
$("head").append(messageStyles);

const modal_question = new bootstrap.Modal("#modal_question");

function showModalEditQuestion() {
  modal_question.show();

  $.ajax({
    // Chama o arquivo que pega as informações
    url: "api/puxarInfo_question.php",
    // Define o method
    method: "post",
    // Valores de "input"
    // Quando der certo retorna um valor
    success: function (data) {
      $("#modalQuestion_body").html(data);
    },
  });
}
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
    data:{primeira: pergunta1,
    segunda: pergunta2,
    terceira: pergunta3,
    quarta: pergunta4,
    quinta: pergunta5,
    sexta: pergunta6,
    setima: pergunta7,
    oitava: pergunta8,
    nona: pergunta9,
    decima: pergunta10},
    success: function (data) {
      console.log(data);
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
function closeModal() {
  $("#modal-feed").fadeOut(300);
  $("#title").html("");
}

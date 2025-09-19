
document.addEventListener("DOMContentLoaded", function () {
  table();
});

function table() {
  
      // Chamada AJAX para envio do questionário
      $.ajax({
        url: "api/relatoriosAPI.php",
        method: "POST",
        success: function (data) {

          $('#table').html(data)

        },
        error: function (xhr) {
          const response = JSON.parse(xhr.responseText);
          showErrorMessage(response.error || "Erro no servidor");
        },
      });
}
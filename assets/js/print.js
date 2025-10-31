
document.addEventListener("DOMContentLoaded", function () {
  printReport();
});

function printReport(){
  $.ajax({
        url: "api/printAPI.php",
        method: "POST",
        success: function (data) {

            console.log(data);
          $('#table').html(data)

        },
        error: function (xhr) {
          const response = JSON.parse(xhr.responseText);
          showErrorMessage(response.error || "Erro no servidor");
        },
      });

}
function imprimir()
{
  document.getElementById("report").style.display = "none";
  document.getElementById("back").style.display = "none";
  document.getElementById("excel").style.display = "none";

  window.print();

  location.href = "relatorios.php"

}

function gerarExcel(){

  location.href = "api/gerarExcel.php"
}

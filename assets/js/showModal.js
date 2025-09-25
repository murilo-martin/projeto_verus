
function showmodal(titulo,texto) {

  $("#title").html(titulo);
  $("#text").html(texto);

$("#modal-feed")
    .css("display", "flex")
    .hide()
    .fadeIn(300);

  $("body").addClass("modal-open");
}
function closeModal() {
  $("#modal-feed").fadeOut(300);
  $("#title").html("");
}

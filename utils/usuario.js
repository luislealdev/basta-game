var ventFrame;
var ventFrame1;
function usuario(action, id_usuario) {
  if (typeof id_usuario == "undefined") id_usuario = 0;

  switch (action) {
    case "formNew":
      $.ajax({
        url: "../../class/usuario.php",
        type: "post",
        data: { action },
        success: function (html) {
          workArea.innerHTML = html;
        },
      });
      break;
    case "formEdit":
      $.dialog({
        type: "leal",
        title: "",
        content:
          "url:../../class/usuario.php?action=" +
          action +
          "&id_usuario=" +
          id_usuario,
        columnClass: "medium",
        onContentReady: function () {
          ventFrame = this;
        },
      });
      break;
    case "insert":
      data = $("#formUsuario").serialize();
      $.ajax({
        url: "../../class/usuario.php",
        type: "post",
        data: { accion: cual },
        success: function (html) {
          workArea.innerHTML = html;
        },
      });
      return false;
    case "delete":
      // Confirmar si se desea eliminar el registro y eliminarlo
      $.confirm({
        title: "¿Estás segur@ de borrar?",
        content: "El registro: " + id,
        columnClass: "small",
        buttons: {
          confirm: function () {
            $.ajax({
              url: "../../class/usuario.php",
              type: "post",
              data: { action, id_usuario: id },
              success: function (html) {
                workArea.innerHTML = html;
                alert(
                  "Registro eliminado",
                  "El registro: " + id + " ha sido eliminado"
                );
              },
            });
          },
          cancel: function () {
            $.alert("Canceled!");
          },
        },
      });
      break;
    case "update":
      break;
    case "valiForm":
      mensaje.innerHTML = "";
      if (clave.value == clave2.value && clave.value > "") return true;
      else {
        mensaje.innerHTML = "Clave incorrrecta o duplicada";
        return false;
      }
      break;
    default:
      alert("La opcion '" + accion + "', No existe en usuarios.js");
  }
}

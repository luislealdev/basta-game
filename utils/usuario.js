var ventFrame;
var ventFrame1;
function usuario(action, id) {
  if (typeof id == "undefined") id = 0;

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

var ventFrame;
var ventFrame1;
function usuarioss(accion, id){
    if (typeof(id) == "undefined")
        id=0;

    switch (accion){
        case "formNew": break;
        case "insert": break;
        case "delete": break;
        case "update": break;
        case "valiForm":

            mensaje.innerHTML = "";
            if(clave.value == clave2.value && clave.value>"")
                return true;
            else{
                mensaje.innerHTML = "Clave incorrrecta o duplicada";
                return false;
            }
            break;
        default: alert("La opcion '"+accion+"', No existe en usuarios.js");
    }
}
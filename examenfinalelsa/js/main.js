
document.getElementById("enviar").onclick = function () {
    let num1 = document.getElementById("num1").value;
    let num2 = document.getElementById("num2").value;
    let cadena = document.getElementById("cadena").value;
    enviarDatos(num1, num2, cadena);
}


function enviarDatos(numero1, numero2, cadena){
    // Creamos la conexion asincrona 
    var xhrPost = new XMLHttpRequest();

    // Configuramos los metodos para la conexion
    xhrPost.onreadystatechange = function (){
        if (xhrPost.readyState == 4 && xhrPost.status == 200) {
            let resultado = JSON.parse(xhrPost.responseText);
            document.getElementById("resultado").style.display = "block";
            document.getElementById("respuesta").innerHTML = "<b>Numeros: </b>";
            document.getElementById("respuesta").innerHTML += "&nbsp;"+resultado.numeros+"<br>";
            document.getElementById("respuesta").innerHTML += "<b>Palabras: </b>";
            document.getElementById("respuesta").innerHTML += "&nbsp;"+resultado.palabras+"<br>";
        } 
    } 

    // Configuramos la cabecera para el envio de datos por POST
    xhrPost.open("POST", "/practicas2/pedirdatos");
    xhrPost.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhrPost.send("num1="+numero1+"&num2="+numero2+"&cadena="+cadena);
}
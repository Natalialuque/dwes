document.getElementById("pedir").addEventListener("click", (e) => {
    e.preventDefault();

    let xhr = new XMLHttpRequest();
    const respuestaDiv = document.getElementById("respuesta");
    const min = document.getElementById("min").value;
    const max = document.getElementById("max").value;
    const cadena = document.getElementById("cadena").value;

    respuestaDiv.innerHTML = "";

    xhr.responseType = "json";

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let respuesta = xhr.response;

            respuesta["numeros"].forEach(n => {
                respuestaDiv.innerHTML += `<p>Número: ${n}</p>`;
            }); 

            respuesta["palabras"].forEach(p => {
                respuestaDiv.innerHTML += `<p>Cadena: ${p}</p>`;
            });
        }
    };

    xhr.open(
        "GET",
        "/practica2/pedirdatos?min=" + min +
        "&max=" + max +
        "&cadena=" + encodeURIComponent(cadena),
        true
    );

    xhr.send();
});

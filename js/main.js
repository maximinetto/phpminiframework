const urlAgregar = "http://localhost/tip/framework/pelicula/agregarFavorito/";
const urlEliminar = "http://localhost/tip/framework/pelicula/eliminarFavorito/";

function agregarFavorito(url, idVideo){

    fetch(url + idVideo, {
        method: "GET",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
    })
    .then(function(response){
        return response.json();
    })
    .then(function(data){
        const { ok } = data;
        if(ok){
            const i = document.getElementById("agregarFavorito-" + idVideo);
            i.id = "eliminarFavorito-" + idVideo;
            i.classList.remove("far");
            i.classList.add("fas");
        }
    });
}

function eliminarFavorito(url, idVideo){
    
    fetch(url + idVideo, {
        method: "DELETE",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
    })
    .then(function(response){
        return response.json();
    })
    .then(function(data){
        const { ok } = data;
        if(ok){
            const i = document.getElementById("eliminarFavorito-" + idVideo);
            i.id = "agregarFavorito-" + idVideo;
            i.classList.remove("fas");
            i.classList.add("far");
        }
    });
}

function ejecutar(action, idVideo){
    switch(action){
        case "eliminarFavorito":
            eliminarFavorito(urlEliminar, idVideo);
        break;
        case "agregarFavorito":
            agregarFavorito(urlAgregar, idVideo);
        break;    
    }
}

let icons = document.querySelectorAll(".favorito > i");

icons.forEach(i => {
    i.addEventListener("click", (e) => {
        const id = i.id;
        const stringSplitted = id.split("-", 2);
        const action = stringSplitted[0];
        const idVideo = stringSplitted[1];
        ejecutar(action, idVideo);

    })
});
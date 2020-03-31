const urlAgregar = "http://localhost/tip/framework/pelicula/agregarFavorito/";
const urlEliminar = "http://localhost/tip/framework/pelicula/eliminarFavorito/";

function agregarFavorito(url, idVideo) {
  fetch(url + idVideo, {
    method: "GET",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json"
    }
  })
    .then(function(response) {
      return response.json();
    })
    .then(function(data) {
      const { ok } = data;
      if (ok) {
        const i = document.getElementById("agregarFavorito-" + idVideo);
        i.id = "eliminarFavorito-" + idVideo;
        i.classList.remove("far");
        i.classList.add("fas");
      }
    });
}

function eliminarFavorito(url, idVideo) {
  fetch(url + idVideo, {
    method: "DELETE",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json"
    }
  })
    .then(function(response) {
      return response.json();
    })
    .then(function(data) {
      const { ok } = data;
      if (ok) {
        const i = document.getElementById("eliminarFavorito-" + idVideo);
        i.id = "agregarFavorito-" + idVideo;
        i.classList.remove("fas");
        i.classList.add("far");
      }
    });
}

function paraVer(id_pelicula) {
  $.ajax({
    url: "/tip/framework/pelicula/agregar_lista/",
    data: { id_pelicula: id_pelicula },
    type: "POST",
    dataType: "json",
    success: function(json) {
      if (json.res == 1) {
        //todo ok
        alert(json.mensaje);
        //$('#idboton').val("Agregado");
      } else {
        alert(json.mensaje);
      }
    },
    error: function(json) {
      console.log(json);
    }
  });
  //cargarParaVer();

  //ejecutar el llamado ajax a pelicula/agregar_lista/ -> demora 1 min
  //ejecuta cargarParaVer();
  // cuando pasa 1 min, ejecutar success()
}

function cargarParaVer(id_usuario) {
  $.ajax({
    url: "/tip/framework/pelicula/ver_peliculas_mas_tarde/",
    data: { id_usuario: id_usuario },
    type: "POST",
    dataType: "json",
    success: function(json) {
      if (json.ok) {
        const films = json.films;
        let html = "";
        films.forEach(f => {
         
              html += `<a class="film-modal" href="/tip/framework/pelicula/detalles/${f.idVideo}">
              Título: ${f.title}</a>`;
        
        });

        $(".modal-body").html(html);
        // Display Modal
        $("#pverModal").modal("show");
      } else {
        alert(json.mensaje);
      }
    },
    error: function(json) {
      console.log(json);
    }
  });
}

function ejecutar(action, idVideo) {
  switch (action) {
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
  i.addEventListener("click", e => {
    const id = i.id;
    const stringSplitted = id.split("-", 2);
    const action = stringSplitted[0];
    const idVideo = stringSplitted[1];
    ejecutar(action, idVideo);
  });
});

let audiovisuales = document.getElementsByClassName("film");

for(let index = 0; index < audiovisuales.length; index++){
    let audiovisual = audiovisuales[index];
    audiovisual.addEventListener("click", event => {
        
        const idVideo = audiovisual.id;
        
        document.location = `audiovisuals?idVideo=${idVideo}`; 
       

    });
}
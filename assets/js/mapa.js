function CrearMapa() {
    const mapa = L.map('map', {
        center: [10.062907758626542, -69.36506133308706],
        zoom: 17//Nivel de altitud (zoom por defecto
    });


    //Aca se hace el llamado a la plantilla del mapa, es decir su diseño
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        //Se trata del copiright de la "capa" osea del diseño del mapa
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(mapa);


    return mapa
}

const objBaseLib = CrearMapa()
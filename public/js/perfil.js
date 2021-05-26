function getInfoJuego(idJuego) {
    $.ajax({
        'type': 'GET',
        'url': 'https://api.rawg.io/api/games/' + idJuego + '?key=f10de120cd344ca996eed2acff8560dc',
        'success': (juego) => {
            $('#imagenJuego' + idJuego).attr('src', juego.background_image);
            $('#nombreJuego' + idJuego).text(juego.name);
        }
    });
}
function mostrarFormulario() {
    $('#botonMostrar').addClass('d-none');
    $('#form').addClass('d-block');
    $('#botonMostrar').removeClass('d-block');
    $('#form').removeClass('d-none');
}

function checkJuego() {
    var url = window.location.href;

    if (url.search('juegos') != -1) {
        var idJuego = url.substring(url.lastIndexOf('/') + 1);
        $.ajax({
            'type': 'GET',
            'url': 'http://127.0.0.1:8000/juegos/check/' + idJuego,
            'success': (result) => {
                if (result == 'OK') {
                    mostrarFormulario();
                    $('#eliminar').removeClass('d-none');
                }
            }
        });
    }
}
$(document).ready(() => {
    checkJuego();
});
$(document).ready(() => {

    if (/^http:\/\/gamerforum\.herokuapp\.com:8000\/discusiones.*/.test(window.location.href)) {
        $('#navForo').removeClass('noActivo');
        $('#navNoticias').removeClass('activo');
        $('#navJuegos').removeClass('activo');
        $('#navForo').addClass('activo');
        $('#navNoticias').addClass('noActivo');
        $('#navJuegos').addClass('noActivo');
    }

    if (/^http:\/\/gamerforum\.herokuapp\.com:8000\/noticias.*/.test(window.location.href)) {
        $('#navForo').removeClass('activo');
        $('#navNoticias').removeClass('noActivo');
        $('#navJuegos').removeClass('activo');
        $('#navForo').addClass('noActivo');
        $('#navNoticias').addClass('activo');
        $('#navJuegos').addClass('noActivo');
    }

    if (/^http:\/\/gamerforum\.herokuapp\.com:8000\/juegos.*/.test(window.location.href)) {
        $('#navForo').removeClass('activo');
        $('#navNoticias').removeClass('activo');
        $('#navJuegos').removeClass('noActivo');
        $('#navForo').addClass('noActivo');
        $('#navNoticias').addClass('noActivo');
        $('#navJuegos').addClass('activo');
    }
});
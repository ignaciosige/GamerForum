$("#usuario_fechaNacimiento_day").on('change', validar);
$("#usuario_fechaNacimiento_month").on('change', validar);
$("#usuario_fechaNacimiento_year").on('change', validar);
$("#usuario_email").on('keyup', validar);
$("#usuario_nombreUsuario").on('keyup', validar);

function validar() {

    let fechaHoy = new Date();
    let diaFormulario = $('#usuario_fechaNacimiento_day').val();
    let mesFormulario = $('#usuario_fechaNacimiento_month').val();
    let anioFormulario = $('#usuario_fechaNacimiento_year').val();
    let fechaFormulario = new Date(anioFormulario, mesFormulario - 1, diaFormulario);
    let alertaFecha;
    let alertaUsuario;
    let alertaEmail;

    if (fechaFormulario.getTime() > fechaHoy.getTime()) {
        $('#alertMensajeError').addClass('d-block');
        $('#alertMensajeError').removeClass('d-none');
        $('#alertMensajeError').text('La fecha no puede ser posterior a la actual');
        $('#usuario_save').addClass('disabled');
        $('#usuario_save').attr('disabled', true);
        alertaFecha = true;
    } else {
        if (!(alertaUsuario && alertaEmail)) {
            $('#alertMensajeError').addClass('d-none');
            $('#alertMensajeError').removeClass('d-block');
            $('#usuario_save').removeClass('disabled');
            $('#usuario_save').attr('disabled', false);
        }
        alertaFecha = false;
    }

    $.ajax({
        'type': 'GET',
        'url': 'http://127.0.0.1:8000/usuarios/check/email/' + $("#usuario_email").val(),
        'success': (result) => {
            if (result == 'KO') {
                $('#alertMensajeError').addClass('d-block');
                $('#alertMensajeError').removeClass('d-none');
                $('#alertMensajeError').text('Email no disponible');
                $('#usuario_save').addClass('disabled');
                $('#usuario_save').attr('disabled', true);
                alertaEmail = true;
            } else {
                if (!(alertaFecha && alertaUsuario)) {
                    $('#alertMensajeError').addClass('d-none');
                    $('#alertMensajeError').removeClass('d-block');
                    $('#usuario_save').removeClass('disabled');
                    $('#usuario_save').attr('disabled', false);
                }
                alertaEmail = false;
            }
        }
    });

    $.ajax({
        'type': 'GET',
        'url': 'http://127.0.0.1:8000/usuarios/check/nombre/' + $("#usuario_nombreUsuario").val(),
        'success': (result) => {
            if (result == 'KO') {
                $('#alertMensajeError').addClass('d-block');
                $('#alertMensajeError').removeClass('d-none');
                $('#alertMensajeError').text('Usuario no disponible');
                $('#usuario_save').addClass('disabled');
                $('#usuario_save').attr('disabled', true);
                alertaUsuario = true;
            } else {
                if (!(alertaFecha && alertaEmail)) {
                    $('#alertMensajeError').addClass('d-none');
                    $('#alertMensajeError').removeClass('d-block');
                    $('#usuario_save').removeClass('disabled');
                    $('#usuario_save').attr('disabled', false);
                }
                alertaUsuario = false;
            }
        }
    });

}
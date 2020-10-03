$(document).ready(function () {
    
    $('#misDirecciones').click(function (e) { 
        remover_elementos_alerta_success();

        e.preventDefault();

        const id_cliente  = $("#num_cliente").val();
        const id_direcc   = $("#id_direccion").val();
        const nom_direcc  = $("#nom_direcc").val();
        const calle       = $("#calle").val();
        const num_ext     = $("#num_ext").val();
        const num_int     = $("#num_int").val();
        const colonia     = $("#colonia").val();
        const cp          = $("#cp").val();
        const ciudad      = $("#ciudad").val();
        const municipio   = $("#municipio").val();
        const estado   = $("#estado").val();
        // const estado      = $("#state :selected").val();
        const pais        = $("#pais").val();
        const entrecalles = $("#entrecalles").val();
        const referen     = $("#referencia").val();

        const datos = JSON.stringify({
            'id_direccion': id_direcc,
            'num_cliente': id_cliente,
            'nom_direcc': nom_direcc,
            'calle': calle,
            'num_ext': num_ext,
            'num_int': num_int,
            'colonia': colonia,
            'cp': cp,
            'ciudad': ciudad,
            'municipio':municipio,
            'estado': estado,
            'pais': pais,
            'entrecalles':entrecalles,
            'referencia': referen,
            'insertDir' : 'INSERTDIRECC'
        });

        const datosJSON = JSON.parse(datos);

        // console.log(datosJSON);

        $.ajax({
            type: "POST",
            url: "../CDir_envio.php",
            data: datosJSON,
            cache: false,
            dataType: "json",
            success: function (response) {
                switch (response.message) {
                    case "OK1":
                        $('#alerta').removeClass('invisible').addClass('alert-success show');
                        document.getElementById('mensaje_texto').innerHTML="Datos actualizados satisfactoriamente";
                        setTimeout(function() {
                            $("#alerta").fadeOut(2500);
                            vaciarCampos();
                            window.location.href = '../clientes/misdirecciones.php';  
                        }, 3000);
                    break;
                    case "OK2":
                        $('#alerta').removeClass('invisible').addClass('alert-success show');
                        document.getElementById('mensaje_texto').innerHTML="Datos insertados satisfactoriamente";
                        setTimeout(function() {
                            $("#alerta").fadeOut(2500);
                            vaciarCampos();
                            window.location.href = '../clientes/misdirecciones.php'; 
                        }, 3000);
                    break;
                }
            },
            error:function (response) {
                switch (response.responseJSON.message) {
                    case "ERROR1":
                        $('#alerta').removeClass('invisible').addClass('alert-danger show');
                        document.getElementById('mensaje_texto').innerHTML="No se pudo actualizar sus datos";
                        setTimeout(function() {
                            $("#alerta").fadeOut(2500);
                            vaciarCampos();
                            window.location.href = '../clientes/misdirecciones.php'; 
                        }, 3000);
                    break;
                    case "ERROR2":
                        $('#alerta').removeClass('invisible').addClass('alert-danger show');
                        document.getElementById('mensaje_texto').innerHTML="No se actualizaron sus datos";
                        setTimeout(function() {
                            $("#alerta").fadeOut(2500);
                            vaciarCampos();
                            window.location.href = '../clientes/misdirecciones.php'; 
                        }, 3000);
                    break;
                    case "ERROR3":
                        $('#alerta').removeClass('invisible').addClass('alert-danger show');
                        document.getElementById('mensaje_texto').innerHTML="No puedes agregar otra dirección";
                        setTimeout(function() {
                            $("#alerta").fadeOut(2500);
                            vaciarCampos();
                            window.location.href = '../clientes/misdirecciones.php'; 
                        }, 3000);
                    break;
                    case "ERROR4":
                        $('#alerta').removeClass('invisible').addClass('alert-danger show');
                        document.getElementById('mensaje_texto').innerHTML="Faltaron algunos datos";
                        setTimeout(function() {
                            $("#alerta").fadeOut(2500);
                            vaciarCampos();
                            window.location.href = '../clientes/misdirecciones.php'; 
                        }, 3000);
                    break;
                }
            }
        });

    });

    function remover_elementos_alerta_success() { //Funcion para las alertas
        setTimeout(function() {
            $('#alerta').removeClass('alert-success show').addClass('alerta_display invisible');
        }, 5000);
    }

    function vaciarCampos() {
        $("#num_cliente").empty();
        $("#id_direccion").empty();
        $("#nom_direcc").empty();
        $("#calle").empty();
        $("#num_ext").empty();
        $("#num_int").empty();
        $("#colonia").empty();
        $("#cp").empty();
        $("#ciudad").empty();
        $("#municipio").empty();
        $("#entrecalles").empty();
        $("#state :selected").empty();
        $("#pais").empty();
        $("#referencia").empty();
    }

    // CambiarDireccionEnvio - ReenviarUsuarioMóduloFormaEnvioDomicilio
    $('.elegirDir').click(function (e) { 
        e.preventDefault();
        const id = $(this).attr('id');
        const num_cliente  = $("#num_cliente").val();
        $.ajax({
            type: "POST",
            url: "../CDir_envio.php",
            data:{
                'elegirDireccion':'ELEGIRDIRECCION',
                id,
                num_cliente
            },
            cache: false,
            success: function (response) {
                setTimeout(function() {
                    window.location.href = "../checkout/envio.php";
                }, 1000);
            }
        });

    });
});
$(document).ready(function () {
    verProductosCarrito();

    // Eliminar producto usando la clase para obtener id
    $(".deleteCar").click(function (e) { 
        remover_elementos_alerta_success();

        e.preventDefault();

        const skuProd = $(this).attr("id");
        const id_user = $("#id_user").val();
        const id_temporal =  $("#id_temporal").val();
        bootbox.confirm({
            message: "Seguro que quiere eliminar este producto?",
            buttons: {
                confirm: {
                    label: 'Si',
                    className: 'btn-success',
                },
                cancel: {
                    label: 'Cancelar',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result) {
                    var datosCar = JSON.stringify({
                        'id_user' : id_user,
                        'id_temporal' : id_temporal,
                        'skuProd' : skuProd,
                        'deleteCarr' : 'DELETECAR'
                    });
                    var jsonDatos = JSON.parse(datosCar);
                    $.ajax({
                        type: "POST",
                        url: "../CCarrito.php",
                        data: jsonDatos,
                        cache:false,
                        dataType: "json",
                        success: function (response) {
                            switch (response.message) {
                                case "OK1":
                                    var dialog = bootbox.dialog({
                                        title: 'Por favor espere',
                                        message: '<p><i class="fa fa-spin fa-spinner"></i> Eliminando producto...</p>'
                                    });
                                    dialog.init(function(){
                                        setTimeout(function(){
                                            dialog.find('.bootbox-body').html('El producto ha sido eliminado correctamente!');
                                        }, 3000);
                                        window.location.href = '../checkout/carrito.php';
                                    });         
                                break;
                            }
                        },
                        error: function (response) {
                            switch (response.responseJSON.message) {
                                case "ERROR1":
                                    $('#alerta').removeClass('invisible').addClass('alert-danger show');
                                    document.getElementById('mensaje_texto').innerHTML="Ups! No se pudo eliminar del carrito";
                                    setTimeout(function() {
                                        $("#alerta").fadeOut(2500); 
                                    }, 3000);
                                break;
                                case "ERROR2":
                                    $('#alerta').removeClass('invisible').addClass('alert-danger show');
                                    document.getElementById('mensaje_texto').innerHTML="Ups! No existe producto";
                                    setTimeout(function() {
                                        $("#alerta").fadeOut(2500); 
                                    }, 3000);
                                break;
                                case "ERROR4":
                                    $('#alerta').removeClass('invisible').addClass('alert-danger show');
                                    document.getElementById('mensaje_texto').innerHTML="Ups! No se pudo acompletar la acción";
                                    setTimeout(function() {
                                        $("#alerta").fadeOut(2500); 
                                    }, 3000);
                                break;
                            }
                         }
                    });
                }
            }
        });
    });

    function remover_elementos_alerta_success() { //Funcion para las alertas
        setTimeout(function() {
            $('#alerta').removeClass('alert-success show').addClass('alerta_display invisible');
        }, 5000);
    }
    
    function verProductosCarrito() {
        const id_user = $("#id_user").val();
        const id_temporal =  $("#id_temporal").val();

        let datos = JSON.stringify ({
            'id_user':id_user,
            'id_temporal':id_temporal,
            'verCarrito':'VERCARRITO'
        });
        let datosJson = JSON.parse(datos);
        $.ajax({
            type: "GET",
            url: "../CCarrito.php",
            data: datosJson,
            cache:false,
            dataType: "json",
            success: function (response) {
                $('#numeroproducto').html(response.cantidadproducto);
            }
        });
    }
});
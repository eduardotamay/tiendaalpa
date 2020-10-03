$(document).ready(function () {
    verProductosCarrito();
    // Click btn-btn con id del producto para obtener los datos
    $(document).on("click","#AddCar",function (e) { 
        remover_elementos_alerta_success();
        e.preventDefault();
        const sku = document.getElementById('sku-detalle').innerHTML;
        const cantidad = $("#cantidad :selected").val();
        const id_user = $("#id_user").val();
        const id_temporal =  $("#id_temporal").val();
        
        let datos = JSON.stringify ({
            'sku':sku,
            'cantidad':cantidad,
            'id_user':id_user,
            'id_temporal':id_temporal,
            'insertCarrito':'INSERTCARRITO'
        });
        let datosJson = JSON.parse(datos);
        $.ajax({
            type: "POST",
            url: "CCarrito.php",
            data: datosJson,
            cache:false,
            dataType: "json",
            success: function (response) {
                switch (response.message) {
                    case "OK1":
                        bootbox.alert({
                            message: "Se agregó al carrito",
                            size: 'small'
                        });
                        // $('#alerta').removeClass('invisible').addClass('alert-success show');
                        // document.getElementById('mensaje_texto').innerHTML="Se agregó y actualizó su carrito";
                        // setTimeout(function() {
                        //    $("#alerta").fadeOut(2500); 
                        // }, 3000);
                        // bootbox.alert("This is the default alert!");
                    break;
                    case "OK2":
                        bootbox.dialog({
                            title: "Producto agregado",
                            message: "Se agregó el producto "+sku+" correctamente",
                            size: 'large',
                            buttons: {
                                fee: {
                                    label: 'Cerrar',
                                    className: 'btn-success'
                                }
                            },
                        });
                        // $('#alerta').removeClass('invisible').addClass('alert-success show');
                        // document.getElementById('mensaje_texto').innerHTML="Se agregó un nuevo producto";
                        // setTimeout(function() {
                        //     $("#alerta").fadeOut(2500); 
                        // }, 3000);
                    break;
                }
            },
            error: function (response) {
                switch (response.responseJSON.message) {
                    case "ERROR1":
                        $('#alerta').removeClass('invisible').addClass('alert-danger show');
                        document.getElementById('mensaje_texto').innerHTML="Ups! No se actualizó el carrito";
                        setTimeout(function() {
                            $("#alerta").fadeOut(2500); 
                        }, 3000);
                    break;
                    case "ERROR2":
                        $('#alerta').removeClass('invisible').addClass('alert-danger show');
                        document.getElementById('mensaje_texto').innerHTML="Ups! No se pudo agregar al carrito";
                        setTimeout(function() {
                            $("#alerta").fadeOut(2500); 
                        }, 3000);
                    break;
                    case "ERROR3":
                        $('#alerta').removeClass('invisible').addClass('alert-danger show');
                        document.getElementById('mensaje_texto').innerHTML="Ups! Este producto no lo tenemos en la tienda";
                        setTimeout(function() {
                            $("#alerta").fadeOut(2500); 
                        }, 3000);
                    break;
                    case "ERROR4":
                        $('#alerta').removeClass('invisible').addClass('alert-danger show');
                        document.getElementById('mensaje_texto').innerHTML="Ups! Faltaron por enviar algunos datos";
                        setTimeout(function() {
                            $("#alerta").fadeOut(2500); 
                        }, 3000);
                    break;
                }
            }
        });
        setTimeout(function() {
            document.location.reload(true);
        }, 3000);
    });
    
    // Agregar al carrito usando la clase para obtener id del prodcto
    $(".addCar").click(function(e){
        remover_elementos_alerta_success();
        e.preventDefault();
        const sku = $(this).attr("id");
        const cantidad = $(`#cantidad${sku} :selected`).val();
        const id_user = $("#id_user").val();
        const id_temporal =  $("#id_temporal").val();
        
        let datos = JSON.stringify ({
            'sku':sku,
            'cantidad':cantidad,
            'id_user':id_user,
            'id_temporal':id_temporal,
            'insertCarrito':'INSERTCARRITO'
        });
        let datosJson = JSON.parse(datos);
        $.ajax({
            type: "POST",
            url: "CCarrito.php",
            data: datosJson,
            cache:false,
            dataType: "json",
            success: function (response) { 
                switch (response.message) {
                    case "OK1":
                        bootbox.alert({
                            message: "Se agregó al carrito",
                            size: 'small'
                        });
                        //$('#alerta').removeClass('invisible').addClass('alert-success show');
                        //document.getElementById('mensaje_texto').innerHTML="Se agregó y actualizó su carrito";
                        //setTimeout(function() {
                        //    $("#alerta").fadeOut(2500); 
                        //}, 3000);
                    break;
                    case "OK2":
                        bootbox.dialog({
                            title: "Producto agregado",
                            message: "Se agregó el producto "+sku+" correctamente",
                            size: 'large',
                            buttons: {
                                fee: {
                                    label: 'Cerrar',
                                    className: 'btn-success'
                                }
                            },
                        });
                        //$('#alerta').removeClass('invisible').addClass('alert-success show');
                        //document.getElementById('mensaje_texto').innerHTML="Se agregó un nuevo producto";
                        //setTimeout(function() {
                        //    $("#alerta").fadeOut(2500); 
                        //}, 3000);
                    break;
                }
            },
            error: function (response) {
                console.log(response);
                switch (response.responseJSON.message) {
                    case "ERROR1":
                        $('#alerta').removeClass('invisible').addClass('alert-danger show');
                        document.getElementById('mensaje_texto').innerHTML="Ups! No se actualizó el carrito";
                        setTimeout(function() {
                            $("#alerta").fadeOut(2500); 
                        }, 3000);
                    break;
                    case "ERROR2":
                        $('#alerta').removeClass('invisible').addClass('alert-danger show');
                        document.getElementById('mensaje_texto').innerHTML="Ups! No se pudo agregar al carrito";
                        setTimeout(function() {
                            $("#alerta").fadeOut(2500); 
                        }, 3000);
                    break;
                    case "ERROR3":
                        $('#alerta').removeClass('invisible').addClass('alert-danger show');
                        document.getElementById('mensaje_texto').innerHTML="Ups! Este producto no lo tenemos en la tienda";
                        setTimeout(function() {
                            $("#alerta").fadeOut(2500); 
                        }, 3000);
                    break;
                    case "ERROR4":
                        $('#alerta').removeClass('invisible').addClass('alert-danger show');
                        document.getElementById('mensaje_texto').innerHTML="Ups! Faltaron por enviar algunos datos";
                        setTimeout(function() {
                            $("#alerta").fadeOut(2500); 
                        }, 3000);
                    break;
                }
            }
        });
        setTimeout(function() {
            document.location.reload(true);
        }, 3000);
    });

    function remover_elementos_alerta_success() { //Funcion para las alertas
        setTimeout(function() {
            $('#alerta').removeClass('alert-success show').addClass('alerta_display invisible');
        }, 5000);
    }

    function replaceTxt( text, busca, reemplaza ){ //Elimina comas en los precios
        while (text.toString().indexOf(busca) != -1)
            text = text.toString().replace(busca,reemplaza);
        return text;
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
            url: "CCarrito.php",
            data: datosJson,
            cache:false,
            dataType: "json",
            success: function (response) {
                $('#numeroproducto').html(response.cantidadproducto);
            }
        });
    }
});
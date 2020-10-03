$(document).ready(function() {
    $('#register_form').submit(function(e) {
        e.preventDefault();
        //Obtenemos los valores
        var name = $("input#name").val();
        var email = $("input#email").val();
        var password = $("input#password").val();

        $.ajax({
            type: "POST",
            url: 'CUsuario.php',
            cache: false,
            data: {
                register: 'Register',
                name,
                email,
                password
            },
            success: function(response) {
                // console.log(response);
                if (response = "OK") {
                    $('#alerta_ok').removeClass('hide').addClass('alert-success show');
                    setTimeout(function() {
                        $("#alerta").fadeOut(2500);
                        window.location.href = "./index.php";
                    }, 3000);
                }
            },
            error: function(response) {
                // console.log(response.responseJSON.message);
                if (response.responseJSON.message = "ERROR1") {
                    $('#alerta').removeClass('hide').addClass('alert-danger show');
                    //Limpiar form y los campos
                    document.getElementById("register_form").reset();
                    $("#name").empty();
                    $("#password").empty();
                    $("#email").empty();
                    //Focus al campo
                    $('#name').focus()
                    setTimeout(function() {
                        $("#alerta").fadeOut(2500);
                    }, 3000);
                    return false;
                }if (response.responseJSON.message = "ERROR2") {
                    $('#alerta').removeClass('hide').addClass('alert-danger show');
                    //Limpiar form y los campos
                    document.getElementById("register_form").reset();
                    $("#name").empty();
                    $("#password").empty();
                    $("#email").empty();
                    //Focus al campo
                    $('#name').focus()
                    setTimeout(function() {
                        $("#alerta").fadeOut(2500);
                    }, 3000);
                    return false;
                }
                if (response.responseJSON.message = "ERROR3") {
                    $('#alerta').removeClass('hide').addClass('alert-danger show');
                    //Limpiar form y los campos
                    document.getElementById("register_form").reset();
                    $("#name").empty();
                    $("#password").empty();
                    $("#email").empty();
                    //Focus al campo
                    $('#name').focus()
                    setTimeout(function() {
                        $("#alerta").fadeOut(2500);
                    }, 3000);
                    return false;
                }
            }

        });
    });
    
});
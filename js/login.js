$(document).ready(function() {
    $('#loginform').submit(function(e) {
        e.preventDefault();
        var email = $("input#email").val();
        //Obtenemos el valor del campo password
        var password = $("input#password").val();
        var location = $("input#location").val();
        //Construimos la variable que se guardará en el data del Ajax para pasar al archivo php que procesará los datos
        // var dataString = 'email=' + email + '&password=' + password;
        // console.log(dataString);
        $.ajax({
            type: "POST",
            url: 'CUsuario.php',
            cache: false,
            data: {
                login: 'Login',
                email,
                password,
                location
            },
            success: function(response) {
                // console.log(response.message,response.url);
                if (message = "OK") {
                    $('#alerta_ok').removeClass('hide').addClass('alert-success show');
                    setTimeout(function() {
                        $("#alerta").fadeOut(2500);
                    }, 3000);
                }
            },
            error: function(response) {
                // console.log(response.responseText);
                if (response.responseJSON.message = "ERROR1") {
                    $('#alerta').removeClass('hide').addClass('alert-danger show');
                    //Limpiar form y los campos
                    document.getElementById("loginform").reset();
                    $("#password").empty();
                    $("#email").empty();
                    //Focus al campo
                    $('#email').focus()
                    setTimeout(function() {
                        $("#alerta").fadeOut(2500);
                    }, 3000);
                    return false;
                }if (response.responseJSON.message = "ERROR2") {
                    $('#alerta').removeClass('hide').addClass('alert-danger show');
                    //Limpiar form
                    document.getElementById("loginform").reset();
                    $("#password").empty();
                    $("#email").empty();
                    //Focus al campo
                    $('#email').focus()
                    setTimeout(function() {
                        $("#alerta").fadeOut(2500);
                    }, 3000);
                    return false;
                }
            }

        });
    });
});
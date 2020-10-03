<?php
session_start(); //Iniciar sesion o reanudar
?>
<form action="pago.php" method="post">
    <div class="row" style="margin-top: 40px; background-color: #f6f6f6; border-radius: 5px; padding-top:15px;padding-bottom: 15px;">
        <div class="col-md-1 my-auto">
            <input style="margin:0 auto;" type="radio" name="envio" value="sucursal" required="">
        </div>
        <div class="col-md-2 my-auto" style="font-weight: bolder;">
           Sucursal CDMX
        </div>
        <div class="col-md-4 my-auto direccion-envio">
                <span style="font-weight:bolder;">
                    Calle: 
                </span>
                Av. Escuinapa #53,<br>
                <span style="font-weight:bolder;">
                    Col. 
                </span> 
                Pedregal de Santo Domingo,<br>
                <span style="font-weight:bolder;">
                    CP. 
                </span>
                04369, Coyoacan <br>
                <span style="font-weight:bolder;">
                    Ciudad de México, México
                </span><br>
                <a class="btn btn-secondary btn-sm" style="font-size:0.5rem; padding:4px;" href="#" role="button">
                    Como llegar
                </a>
        </div>
        <div class="col-md-3 my-auto">
            <span style="font-weight:bolder;">
                Entrega:<br>
            </span>
            1 hora hábil
        </div>
        <div class="col-md-2 my-auto">
            <span style="font-weight:bolder; color:red">
                Envío gratis
            </span>
        </div>
    </div>
    <button name="seleccion_envio" value="SUCURSAL_ALPA" class="btn btn-primary btn-sm" type="submit" style="margin-top: 25px;">
        Confirmar envío
    </button>
</form>
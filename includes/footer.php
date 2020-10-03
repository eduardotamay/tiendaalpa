<footer class="footer">
    <div class="container" style="padding-bottom: 20px;">
        <div class="row">
            <div class="col-md-3">
                <img src="https://www.tiendaalpa.com/img/alpablanco.png" style="height: 100px; margin-top: 20px;">
            </div>
            <div class="col-md-3">
                <h4>¿Cómo Funciona?</h4>
                <a href="#" class="liga-footer">Preguntas frecuentes</a><br>
                <a href="#" class="liga-footer">Formas de envío</a><br>
                <a href="#" class="liga-footer">Formas de pago</a>

            </div>
            <div class="col-md-3">
                <h4>Cuenta</h4>
                <?php if(PATH_INDEX_FOOTHER){?>
                    <a href="<?php echo PATH_INDEX_FOOTHER ?>checkout/carrito.php" class="liga-footer">Carrito</a><br>
                <?php }else{?>
                    <a href="../checkout/carrito.php" class="liga-footer">Carrito</a><br>
                <?php } if (isset($_SESSION['email'])) { ?>
                    <a href="<?php echo PATH_CAR ?>clientes/index.php" class="liga-footer">Mi cuenta</a><br>
                <?php }else{ ?>
                    <a href="<?php echo PATH_CAR ?>login.php" class="liga-footer">Mi cuenta</a><br>
                <?php } ?>
                <a href="#" class="liga-footer">Mis pedidos</a><br>
            </div>
            <div class="col-md-3">
                <h4>Contacto</h4>
                +52 55 1332 3323<br>
                soporte@autopartesalpa.com.mx<br>
                <a href="#"><img src="https://www.tiendaalpa.com/img/flogo.png" style="height: 25px; margin-right: 10px;"></a>
                <a href="#"><img src="https://www.tiendaalpa.com/img/wlogo.png" style="height: 25px; margin-left: 10px;"></a>
            </div>

        </div>

    </div>
</footer>
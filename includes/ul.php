<ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <a class="nav-link" href="#"><img src="https://www.tiendaalpa.com/img/quienessomos.png" class="imagen-menu" alt=""> Quienes
            somos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#lineas-productos">
            <img src="https://www.tiendaalpa.com/img/categorias.png" class="imagen-menu" alt="">
            Categorias
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <img src="https://www.tiendaalpa.com/img/pedidos.png" class="imagen-menu" alt="">
            Pedidos
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo PATH_CAR ?>checkout/carrito.php">
            <img src="https://www.tiendaalpa.com/img/carrito.png" class="imagen-menu" alt="">
            <span id="numeroproducto" class="badge badge-danger badge-pill" style="margin-left: -15px;margin-top: -5px; position: absolute"></span>
            Carrito
        </a>
    </li>
    <li class="nav-item dropdown">
        <?php
            if (isset($_SESSION['email'])) { //En caso de que existe una sesion
                echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    echo '<img src="https://www.tiendaalpa.com/img/cuenta.svg" class="imagen-menu" alt="">';
                    echo ucfirst($_SESSION['nombre_cliente'])." ".ucfirst($_SESSION['apellido_cliente']);
                echo '</a>';
                echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="'.PATH.'clientes/index.php">Mi cuenta</a>
                <div class="dropdown-divider"></div>
                <a title="Cerrar sesión" class="dropdown-item" href="'.PATH.'logout.php?id_t='.$id_temporal.'&id_c='.$id_cliente.'">Cerrar sesión</a>
              </div>';
            }else{
                echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    echo '<img src="https://www.tiendaalpa.com/img/cuenta.svg" class="imagen-menu" alt="">';
                    echo "Tu cuenta";
                echo '</a>';
                echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a title="Iniciar sesión" class="dropdown-item" href="'.PATH.'login.php">Iniciar sesión</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="'.PATH.'register.php">Crear cuenta</a>
              </div>';
            }
        ?>
    </li>
</ul>
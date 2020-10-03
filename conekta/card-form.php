<?php
    session_start(); //Iniciar sesion o reanudar
    if(isset($_SESSION['nombre_cliente'])){
    $pedido=$_GET['pedido'];
?>
<link rel="stylesheet" href="css/estiloCard.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
<script type="text/javascript" >
    Conekta.setPublicKey('key_F8LNor3xW5nZc1iewbzywHA');
  
    var conektaSuccessResponseHandler = function(token) {
        var $form = $("#card-form");
        //Inserta el token_id en la forma para que se envíe al servidor
        $form.append($('<input type="hidden" name="conektaTokenId" id="conektaTokenId">').val(token.id));
        $form.get(0).submit(); //Hace submit
    };
    var conektaErrorResponseHandler = function(response) {
      var $form = $("#card-form");
      $form.find(".card-errors").text(response.message_to_purchaser);
      $form.find("button").prop("disabled", false);
    };
    //jQuery para que genere el token después de dar click en submit
    $(function () {
      $("#card-form").submit(function(event) {
        event.preventDefault();
        var $form = $(this);
        // Previene hacer submit más de una vez
        $form.find("button").prop("disabled", true);
        Conekta.Token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);
        return false;
      });
    });
  </script>
<div style="background-color:#F1F1F1;" class="container">
  <div class="col1">
    <div class="card">
      <div class="front">
        <div class="type">
          <img class="bankid"/>
        </div>
        <span class="chip"></span>
        <span class="card_number">&#x25CF;&#x25CF;&#x25CF;&#x25CF; &#x25CF;&#x25CF;&#x25CF;&#x25CF; &#x25CF;&#x25CF;&#x25CF;&#x25CF; &#x25CF;&#x25CF;&#x25CF;&#x25CF; </span>
        <div style="display:flex" class="date"><span class="date_value">MM / </span><span style="color:#e1e1e1;margin-left:50px;margin-top:8px;" class="date_value_year"> YY</span></div>
        <span class="fullname">Nombre completo</span>
      </div>
      <div class="back">
        <div class="magnetic"></div>
        <div class="bar"></div>
        <span class="seccode">&#x25CF;&#x25CF;&#x25CF;</span>
      </div>
    </div>
  </div>
  <div class="col2">
    <form  action="pay-card.php" method="POST" id="card-form">
        <input name="pedido" value="<?php echo $pedido;?>" type="hidden">
        <label>Número de tarjeta</label>
        <input class="number" data-conekta="card[number]" type="text" maxlength="19" onkeypress='return event.charCode >= 48 && event.charCode <= 57'/>
        <label>Nombre del Tarjetahabiente</label>
        <input class="inputname"  data-conekta="card[name]" type="text" placeholder=""/>
        <label>Fecha de expiración</label>
        <div style="display:flex">
            <input class="expire" style="width:60px;margin-right:0px;" size="2" type="text" data-conekta="card[exp_month]" placeholder="MM /"/>
            <input class="year" style="width:70px" type="text" size="4" data-conekta="card[exp_year]" placeholder=" YY">
        </div>
        <label>Código de seguridad</label>
        <input class="ccv" data-conekta="card[cvc]" type="text" placeholder="CVC" maxlength="3" onkeypress='return event.charCode >= 48 && event.charCode <= 57'/>
        <button type="submit" class="buy"><i class="material-icons">lock</i>Pagar</button>
    </form>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="js/main-formcard.js"></script>
<?php
    }else{
        header("location:../login.php?location=".urlencode($_SERVER['REQUEST_URI']));
    }
?>
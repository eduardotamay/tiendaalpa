<!DOCTYPE html>
<html lang='en'></html>
<head>
  <meta charset='UTF-8'>
  <title>Pago con tarjeta</title>
  
</head>
<body>
  <form action="" method="POST" id="card-form">
    <span class="card-errors"></span>
    <div>
      <label>
        <span>Nombre del tarjetahabiente</span>
        <input type="text" size="20" data-conekta="card[name]">
      </label>
    </div>
    <div>
      <label>
        <span>Número de tarjeta de crédito</span>
        <input type="text" size="20" data-conekta="card[number]">
      </label>
    </div>
    <div>
      <label>
        <span>CVC</span>
        <input type="text" size="4" data-conekta="card[cvc]">
      </label>
    </div>
    <div>
      <label>
        <span>Fecha de expiración (MM/AAAA)</span>
        <input type="text" size="2" >
      </label>
      <span>/</span>
      <input type="text" size="4" data-conekta="card[exp_year]">
    </div>
    <button >Crear token</button>
  </form>
</body>


<!-- LLAVE PUBLICA
Llave para tokenizar tarjetas en el buscador del cliente.
key_F8LNor3xW5nZc1iewbzywHA
 
LLAVE PRIVADA
Llave para procesar las transacciones en tu servidor, no debe de estar publica.
key_muLvTTcfeiXgQzGwjDkGxQ -->
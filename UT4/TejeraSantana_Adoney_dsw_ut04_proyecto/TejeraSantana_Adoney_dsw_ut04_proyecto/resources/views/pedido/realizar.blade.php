<h1>Estado del pedido</h1>
<br>
@if ($procesada)
<p>Pedido realizado</p>

@elseif ($error)
<p>Ha ocurrido un error: {{$error}}</p>

@else
<p>El carrito está vacío, no se ha podido realizar</p>

@endif

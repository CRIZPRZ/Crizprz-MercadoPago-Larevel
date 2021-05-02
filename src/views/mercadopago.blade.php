<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Example checkout pro mercado pago</title>

</head>
<body>
<div class="text-center">
    <h1>Example Checkout Pro Mercado Pago</h1>
    <div>
        {{ MercadoPago::ButtonPay($preference->init_point) }}
    </div>
    <div>
        <a class="btn btn-info mt-5" href="{{ $preference->init_point }}">Personalizar Boton</a>
    </div>
</div>

</body>
</html>

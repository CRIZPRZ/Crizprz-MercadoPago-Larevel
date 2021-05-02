# Checkout PRO for Laravel by CRIZPRZ

[![Laravel 5.x](https://img.shields.io/badge/Laravel-5.x-orange.svg)](https://laravel.com/docs/5.8)
[![Laravel 6.x](https://img.shields.io/badge/Laravel-6.x-blue.svg)](https://laravel.com/docs/6.x)
[![Laravel 7.x](https://img.shields.io/badge/Laravel-7.x-red.svg)](https://laravel.com/docs/7.x)
[![Laravel 8.x](https://img.shields.io/badge/Laravel-8.x-red.svg)](https://laravel.com)
[![Latest Stable Version](https://poser.pugx.org/crizprz/pwacrizprz/v/stable)](https://packagist.org/packages/crizprz/laravelmercadopago)
[![Total Downloads](https://poser.pugx.org/crizprz/laravelmercadopago/downloads)](https://packagist.org/packages/crizprz/laravelmercadopago)
[![License](https://poser.pugx.org/composer/composer/license)](//https://packagist.org/packages/crizprz/laravelmercadopago)



This package integrates Mercado Pago's [Checkout Pro](https://www.mercadopago.com.mx/developers/es/guides/online-payments/checkout-pro/introduction) very easily

 
REQUIREMENTS
====

Composer v.2 is recommended

guzzlehttp/guzzle


## INSTALLATION

Install the package through [Composer](http://getcomposer.org/).

```bash
composer require crizprz/laravelmercadopago
```
Or add the following to your `composer.json` file :
```json
"require": {
    "crizprz/laravelmercadopago": "^1.0",
},
```

## CONFIGURATION
1. Open `config/app.php` and add this line to your Service Providers Array.
```php
crizprz\laravelmercadopago\Providers\LaravelMercadoPagoProvider::class,
```

2. Open `config/app.php` and add this line to your aliases Array.
```php
'MercadoPago' => crizprz\laravelmercadopago\Facades\MercadoPago::class,
```

3. publish the assets.
```php
php artisan vendor:publish --provider="crizprz\laravelmercadopago\Providers\LaravelMercadoPagoProvider"
```



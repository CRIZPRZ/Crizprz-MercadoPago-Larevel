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



# HOW TO USE


## Create User Test
1. To create users we must log in to [Mercado Pago developers](https://www.mercadopago.com.mx/developers/es/guides) with a real account 
2. Go to the top right section, click and select [your integrations](https://www.mercadopago.com.mx/developers/panel) 
3. once in your integrations click on test credentials, copy the Access Token and put it in the `.env` file in the variable called `ACCESS_TOKEN_MP =` 
4. paste this code somewhere in your code either in a route or a running controller, this code will print two test users, the seller and the buyer 
  ```
 use crizprz\laravelmercadopago\Facades\MercadoPago;
 
 MercadoPago::CreateUsersTest();
```
This will return an array with the two types of users, we must save these users very well since the paid market only allows creating 10 test users per account.

Note: Run only once. 

example of what the previous code returns 
```php
 array:2 [▼
  0 => array:5 [▼
    "id" => 752892812
    "nickname" => "TESTE2VYDAPX"
    "email" => "test_user_84921269@testuser.com"
    "password" => "qatest3393"
    "type User" => "seller"
  ]
  1 => array:5 [▼
    "id" => 752890064
    "nickname" => "TETE9884170"
    "email" => "test_user_45814566@testuser.com"
    "password" => "qatest6713"
    "type User" => "payer"
  ]
]
```

## create payment preference with test user 
1. login with the test user in [Mercado Pago developers](https://www.mercadopago.com.mx/developers/es/guides)
2. Go to the top right section, click and select [your integrations](https://www.mercadopago.com.mx/developers/panel)
3. create new integration fill in the form and click on create application, click on production keys, copy the Access Token and put it in the `.env` file in the variable called `ACCESS_TOKEN_MP =`

## Create Preference
1.paste the following code somewhere in your project where you want to implement the payment button 
```php
 use crizprz\laravelmercadopago\Facades\MercadoPago;

 $preference = MercadoPago::CreatePreference([
            'auto_return' => 'approved',
            'binary_mode' => true,
            'back_urls' => [
                "success" => route('mpsuccess'),
                "failure" => route('mpfailure'),
                "pending" => route('mppending')
            ],
            'notification_url' => route('webhook'),
            'items' => [
                'id' => '001',
                'title' => 'prod 1',
                'picture_url' => 'https://www.tusitio.com/images/products/prod1.jpg',
                'description' => 'this is descriptions',
                'category_id' => 'food',
                'quantity' => 1,
                'price' => 1000,
            ],
            'payment_methods' => [
                'excluded_payment_methods' => array(
                    array('id' => 'master'),
                    // array('id' => 'visa'),
                  ),
                  'excluded_payment_types' => array(
                    array('id' => 'ticket')
                  ),
                  'installments' => 12
                ],
                'payer' => [
                    'name' => 'Cristian',
                    'last_name' => 'Lira Perez',
                    'email' => 'al221711754@gmail.com',
                    'phone' => [
                        'area_code' => +52,
                        'number' => '7224738425'
                    ],
                    'address' => [
                        'zip_code' => 23492,
                        'street_name' => 'Calle cerrada de juerez',
                        'street_number' => '104'
                    ]
                ],
                'shipments' => [
                        'cost' => 100,
                ],
                'statement_descriptor' => 'Mi tienda online',

        ]);
```
2. visit the api reference, [Create a preference](https://www.mercadopago.com.mx/developers/es/reference/preferences/_checkout_preferences/post) to know what each of the properties of the array means 
3. change the array values to those of your project 

## create payment button 
1. return the variable ```$preference``` to some blade view, this variable has saved all the payment prefence
For Example 
```php 
return view('checkout',['preference' => $preference]);
```
2. in the view render the default button of the package
```php 
 {{ MercadoPago::ButtonPay($preference->init_point) }}
```
or create a custom payment button and pass it the init_point, which is stored in the $ preference variable 
For Example 
```php 
<a class="btn btn-info mt-5" href="{{ $preference->init_point }}">Pay Now</a>
```
## Test your integration 
1. read the [Test your integration](https://www.mercadopago.com.mx/developers/es/guides/online-payments/checkout-pro/test-integration#bookmark_prueba_el_flujo_de_pago) documentation to get the test cards it provides

## Payment status responses 

### payment success 

The code that is executed when returning to your website from a successful payment is in the `App\Http\Controllers\MercadoPagoController` controller in the success method 
```php 
  public function success(Request $request)
   {
    // dd($request->all());
    if ($request->status === 'approved') {
        $response = Http::get("https://api.mercadopago.com/v1/payments/{$request->payment_id}", [
            'access_token' => env('ACCESS_TOKEN_MP'),
            ])->json();

        dd($response);
    }
   }
```
the payment returns a get request to your server so we will use the Request $request where all the payment data comes, what we are interested in is the payiment_id

sample answer 
```php 
 array:11 [▼
  "collection_id" => "14694550173"
  "collection_status" => "approved"
  "payment_id" => "14694550173"
  "status" => "approved"
  "external_reference" => "null"
  "payment_type" => "credit_card"
  "merchant_order_id" => "2621979593"
  "preference_id" => "752892812-d318bf82-4eea-4748-af60-cd4ade381491"
  "site_id" => "MLM"
  "processing_mode" => "aggregator"
  "merchant_account_id" => "null"
]
```

We are going to do a get request with guzzle / huzzlehttp to find the payment that was made and thus obtain the details, such as amount, type of currency, buyer data etc ... 
```php 
 if ($request->status === 'approved') {
        $response = Http::get("https://api.mercadopago.com/v1/payments/{$request->payment_id}", [
            'access_token' => env('ACCESS_TOKEN_MP'),
            ])->json();

        dd($response);
    }
```
In the $ response variable we have all the data of the payment made successfully, with this information we can send emails, push notifications, show session messages in laravel, etc.

<?php

namespace App\Http\Controllers;

use crizprz\laravelmercadopago\Facades\MercadoPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MercadoPagoController extends Controller
{
    public function mercadopago()
    {
        $preference = MercadoPago::CreatePreference([
            'auto_return' => 'approved',

            'back_urls' => [
                "success" => route('mpsuccess'),
                "failure" => route('mpfailure'),
                "pending" => route('mppending')
            ],
            'notification_url' => route('webhook'),
            'external_reference' => 'Reference_1234',
            'items' => [
                array(
                    'id' => '001',
                    'title' => 'producto 1',
                    'picture_url' => 'https://www.tusitio.com/images/products/prod1.jpg',
                    'description' => 'descripcion producto 1',
                    'quantity' => 2,
                    'price' => 100,
                ),
                array(
                    'id' => '002',
                    'title' => 'producto 2',
                    'picture_url' => 'https://www.tusitio.com/images/products/prod1.jpg',
                    'description' => 'descripcion producto 2',
                    'quantity' => 1,
                    'price' => 1000,
                ),
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
                'binary_mode' => true,
        ]);

        // If you want to create test users, uncomment the following line
        // MercadoPago::CreateUsersTest();

        return view('mercadoPago.mercadopago',['preference' => $preference]);
    }

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

    public function failure(Request $request)
   {
    // dd($request->all());
    if ($request->status === 'rejected') {
        return 'no se pudo procesar el pago, intantalo mas tarde';
    }
   }

    public function pending(Request $request)
    {

    if ($request->status === 'pending') {
        dd($request->all());
    }
   }

   public function webhook(Request $request)
   {
    // code that you want to be executed when receiving the webhook
    return response(200);
   }
}

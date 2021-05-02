<?php

namespace crizprz\laravelmercadopago;


class MercadoPago{
      public function CreatePreference(array $data=[]) {
        // dd($data['items']);
        require __DIR__ .  '/../vendor/autoload.php';
        \MercadoPago\SDK::setAccessToken(env('ACCESS_TOKEN_MP'));
        \MercadoPago\SDK::setIntegratorId("dev_8e45bb249f5411eaae570242ac130004");
        $preference = new \MercadoPago\Preference();

        $preference->auto_return = isset($data['auto_return']) ? $data['auto_return']: '';
         $preference->back_urls = array(
            "failure" => isset($data['back_urls']['failure']) ? $data['back_urls']['failure'] : '',
            "pending" => isset($data['back_urls']['pending']) ? $data['back_urls']['pending'] : '',
            "success" => isset($data['back_urls']['success']) ? $data['back_urls']['success'] : '',
            );
        $preference->notification_url = isset($data['notification_url']) ? $data['notification_url'] : '';

        $item = new \MercadoPago\Item();
        $item->id = isset($data['items']['id']) ? $data['items']['id'] : '';
        $item->title = isset($data['items']['title']) ? $data['items']['title'] : '';
        $item->picture_url = isset($data['items']['picture_url']) ? $data['items']['picture_url'] : '';
        $item->description = isset($data['items']['description']) ? $data['items']['description'] : '';
        $item->category_id = isset($data['items']['category_id']) ? $data['items']['category_id'] : '';
        $item->quantity = $data['items']['quantity'];
        $item->unit_price = $data['items']['price'];
        $preference->items = array($item);

        $preference->payment_methods = isset($data['payment_methods']) ? $data['payment_methods'] : '';

        $payer = new \MercadoPago\Payer();
        $payer->name = isset($data['payer']['name']) ? $data['payer']['name'] : '' ;
        $payer->surname = isset($data['payer']['last_name']) ? $data['payer']['last_name'] : '' ;
        $payer->email = isset($data['payer']['email']) ? $data['payer']['email'] : '' ;
        $payer->phone = array(
            "area_code" => isset($data['payer']['phone']['area_code']) ? $data['payer']['phone']['area_code'] : '',
            "number" => isset($data['payer']['phone']['number']) ? $data['payer']['phone']['number'] : '' ,
        );

        $payer->address = array(
            "street_name" =>  isset($data['payer']['address']['street_name']) ? $data['payer']['address']['street_name'] : '' ,
            "street_number" =>  isset($data['payer']['address']['street_number']) ? $data['payer']['address']['street_number'] : '' ,
            "zip_code" =>  isset($data['payer']['address']['zip_code']) ? $data['payer']['address']['zip_code'] : '' ,
        );
        $preference->payer = $payer;
        // dd($data['shipments']['local_pickup']);
        $shipments = new \MercadoPago\Shipments();
        $shipments->mode = isset($data['shipments']['mode']) ? $data['shipments']['mode'] : '';
        $shipments->cost = isset($data['shipments']['cost']) ? $data['shipments']['cost'] : '';
        $shipments->receiver_address = array(
            'zip_code' => isset($data['shipments']['receiver_address']['zip_code']) ?  $data['shipments']['receiver_address']['zip_code']: '',
            'street_name' => isset($data['shipments']['receiver_address']['street_name']) ? $data['shipments']['receiver_address']['street_name'] : '',
            'street_number' => isset($data['shipments']['receiver_address']['street_number']) ? $data['shipments']['receiver_address']['street_number'] : '',
            'floor' => isset($data['shipments']['receiver_address']['floor']) ? $data['shipments']['receiver_address']['floor'] : '',
            'apartment' => isset($data['shipments']['receiver_address']['apartment']) ? $data['shipments']['receiver_address']['apartment'] : '',
            'city_name' => isset($data['shipments']['receiver_address']['city_name']) ? $data['shipments']['receiver_address']['city_name'] : '',
            'state_name' => isset($data['shipments']['receiver_address']['state_name']) ? $data['shipments']['receiver_address']['state_name'] : '',
            'country_name' => isset($data['shipments']['receiver_address']['country_name']) ? $data['shipments']['receiver_address']['country_name'] : '',
        );
        $preference->shipments = $shipments;

        $preference->binary_mode = isset($data['binary_mode']) ? $data['binary_mode'] : '';
        $preference->statement_descriptor = isset($data['statement_descriptor']) ? $data['statement_descriptor'] : '';

        $preference->save();

        return $preference;

        // dd($preference);
        // return $preference->id;
      }

      public function ButtonPay($preference)
      {
          echo "<a href='$preference'><img src='logoMp/mercado.jpg' style='width:100px; box-shadow: 0px 0px 5px 1px black; border-radius:20px'></a> ";
      }

      public function CreateUsersTest()
      {
        require __DIR__ .  '/../vendor/autoload.php';
        \MercadoPago\SDK::setAccessToken(env('ACCESS_TOKEN_MP'));
          $users = array();
          for ($i=0; $i < 2; $i++) {
            $body = array(
                "json_data" => array(
                "site_id" => "MLM"
                )
            );
            $result = \MercadoPago\SDK::post('/users/test_user', $body);

            $response = [
                'id' => $result['body']['id'],
                'nickname' => $result['body']['nickname'],
                'email' => $result['body']['email'],
                'password' => $result['body']['password'],
                'type User' => $i == 0 ? 'seller' : 'payer',
            ];

            array_push($users, $response);
          }

          dd($users);
      }


      public function RecivedNotification($request)
      {
        return response(200);

      }


   }

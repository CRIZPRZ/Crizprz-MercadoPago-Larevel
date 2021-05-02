<?php

namespace crizprz\laravelmercadopago\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App as FacadesApp;
use Illuminate\Foundation\Application;

class LaravelMercadoPagoProvider extends ServiceProvider
{

    public function boot()
    {
        $this->RegisterRoutes();
        $this->registerAccesTokenMp();
        $this->registerLogoMp();
        $this->registerConfig();
        $this->registerController();
        $this->registerView();
    }

    public function register()
    {
        FacadesApp::bind('mercadopago',function() {
            return new \crizprz\laravelmercadopago\MercadoPago;
         });
    }

    protected function RegisterRoutes()
    {
        if (Application::VERSION < 8) {
            $route = "/********* RUTAS CHECKOUT MERCADO PAGO *********/
Route::get('/mercadopago', 'MercadoPagoController@mercadopago')->name('mercadopago');
Route::get('/mpsuccess', 'MercadoPagoController@success')->name('mpsuccess');
Route::get('/mpfailure', 'MercadoPagoController@failure')->name('mpfailure');
Route::get('/mppending', 'MercadoPagoController@pending')->name('mppending');
Route::post('/mercado/webhook', 'MercadoPagoController@webhook')->name('webhook');";
         }else {
            $route = "/********* RUTAS CHECKOUT MERCADO PAGO *********/
Route::get('/mercadopago', [App\Http\Controllers\MercadoPagoController::class,'mercadopago'])->name('mercadopago');
Route::get('/mpsuccess', [App\Http\Controllers\MercadoPagoController::class,'success'])->name('mpsuccess');
Route::get('/mpfailure', [App\Http\Controllers\MercadoPagoController::class,'failure'])->name('mpfailure');
Route::get('/mppending', [App\Http\Controllers\MercadoPagoController::class,'pending'])->name('mppending');
Route::post('/mercado/webhook', [App\Http\Controllers\MercadoPagoController::class,'webhook'])->name('webhook');";

         }
        $doc = fopen( base_path('routes/web.php'), "r" );
        $cont = fread($doc, filesize(base_path('routes/web.php')));
        $pos = strpos($cont, $route);
        if (!$pos) {
            file_put_contents(base_path('routes/web.php'), $route, FILE_APPEND | LOCK_EX);
            return;
        }else{
            return;
        }
    }

    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../config' => config_path(),
        ], 'config');
    }

    protected function registerLogoMp()
    {
        $this->publishes([
            __DIR__.'/../assets/logoMp' => public_path('LogoMp'),
        ], 'logo');
    }



    protected function registerAccesTokenMp()
    {
        $doc = fopen( base_path('.env'), "r" );
        $cont = fread($doc, filesize(base_path('.env')));
        $pos = strpos($cont, 'ACCESS_TOKEN_MP=');
        ($pos);
        if (!$pos) {
            file_put_contents(base_path('.env'), '

ACCESS_TOKEN_MP=', FILE_APPEND | LOCK_EX);
            return;
        }else{
            return;
        }
    }

    protected function registerController()
    {
        $this->publishes([
            __DIR__.'/../Http/Controllers' => app_path('Http/Controllers')
        ], 'controller');
    }

    protected function registerView()
    {
        $this->publishes([
            __DIR__.'/../views/' => resource_path('/views/mercadoPago/'),
        ], 'view');
    }

}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    public function boot()
    {
        ini_set("memory_limit", "-1");
        // JsonResource::withoutWrapping();
        Model::shouldBeStrict(!app()->isProduction());
        Response::macro('success', function ($data = [], $message = '', $code = 200) {
            return response()->json([
                'status'    => true,
                'data'      => $data,
                'message'   => $message
            ], $code);
        });

        Response::macro('error', function ($message = '', $code = 404) {
            return response()->json([
                'status'    => false,
                'message'   => $message
            ], $code);
        });
    }
}

<?php
 
namespace App\Providers;
 
use Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response as StatusCode;
 
class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($array = []) {
            return Response::json([
                ...$array,
                'success' => true
            ], StatusCode::HTTP_OK);
        });

        Response::macro('fail', function ($array = [], $code = false) {

            $array['message'] = $array['message'] ?? 'Terjadi kesalahan ketika memproses data, silakan hubungi administrator, terimakasih.';

            return Response::json([
                ...$array,
                'success' => false
            ], $code ?: StatusCode::HTTP_EXPECTATION_FAILED);
        });

        Redirect::macro('next', function ($message = false) {

            return Redirect::to(Request::query('next', url()->previous()));

        });

        Redirect::macro('fail', function ($message = false) {

            return Redirect::back()->with('danger', $message ?: 'Terjadi kesalahan ketika memproses data, silakan hubungi administrator, terimakasih.');

        });
    }
}
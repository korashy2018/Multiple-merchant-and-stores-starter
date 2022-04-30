<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if ($this->auth->guard() == 'merchants') {
                return route('merchants_login');
            } else {
                return route('customers_login');
            }
        }
    }

    /**
     * @param $request
     * @param  array  $guards
     *
     * @return \Illuminate\Http\JsonResponse|void
     * @throws AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        if (!$request->expectsJson()) {
            throw new HttpResponseException(
                response()->json([
                    "errors" => [
                        [
                            'status' => 401,
                            'title'  => 'unauthenticated',
                            'detail' => trans('app.unauthenticated')
                        ]
                    ]
                ], 401)
            );
        }
        throw new AuthenticationException(
            'Unauthenticated.', $guards, $this->redirectTo($request)
        );
    }
}

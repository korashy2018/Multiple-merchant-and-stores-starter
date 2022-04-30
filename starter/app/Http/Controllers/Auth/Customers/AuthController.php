<?php

namespace App\Http\Controllers\Auth\Customers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:merchants', ['except' => ['login', 'register']]
        );
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth('customers')->attempt($credentials)) {
            return response()->json([
                "errors" => [
                    [
                        'status' => 401,
                        'title'  => 'unauthenticated',
                        'detail' => trans('app.unauthenticated')
                    ]
                ]
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        //Validate data
        $data = $request->only('name', 'email', 'password');

        $validator = Validator::make($data, [
            'name'     => 'required|string',
            'email'    => 'required|email|unique:customers',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, create new user
        $customer = Customer::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password)
        ]);

        //User created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Customer created successfully',
            'data'    => $customer
        ], Response::HTTP_OK);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth('customers')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth('customers')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('customers')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string  $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'data'         => auth('customers')->user(),
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('customers')->factory()->getTTL() * 60
        ]);
    }
}

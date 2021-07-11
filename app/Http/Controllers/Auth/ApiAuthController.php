<?php

namespace App\Http\Controllers\Auth;

use App\Role;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Passport\Client as OClient;

class ApiAuthController extends Controller
{
    private $client;

    public function __construct(){
        $this -> client = OClient::where('password_client', 1)->first();
    }

    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|min:14|max:14',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
//        $request['password']=Hash::make($request['password']);
//        $request['remember_token'] = Str::random(10);
        $user = User::create([
            'name' => $request -> name,
            'email'=> $request-> email,
            'phone'=> $request -> phone,
           'password' => Hash::make($request ->password),
        ]);
        $user->role()-> save(new Role(['type'=>$request-> role]));

        Log::debug('User created');
//        $token = $user->createToken('authToken')->accessToken;
//        $response = ['token' => $token];
//        return response($response);
        return $this->getTokenAndRefreshToken($request, $request->email);
    }

    public function login (Request $request) {
       if (Auth::attempt(['email' => $request->email, 'password'=>$request->password])){
           $user = User::where('email', $request->email)->first();
           return $this->getTokenAndRefreshToken($request, $user->email);
       }
        return response()->json(['error'=>'Unauthorised'], 401);
    }

    public function logout (Request $request) {
        $accessToken = Auth::user()->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update(['revoked' => true]);

        $accessToken->revoke();

        return response()->json([], 204);
    }

    public function getTokenAndRefreshToken(Request $request, $email) {
        $params = [
            'grant_type' => 'password',
            'client_id' => $this -> client -> id,
            'client_secret' => $this -> client->secret,
            'username' => $email,
            'scope' => '*',
        ];

        $request -> request -> add($params);

        $proxy = Request::create('oauth/token', 'POST');

        return Route::dispatch($proxy);
    }
}

<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthClientController extends Controller
{
    public function auth(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $client = Client::where('email', $request->email)->first();
        
        //Hash::check() - compara a senha passada no request com a senha do usuário.
        if (!$client || !Hash::check($request->password, $client->password)) {
            return response()->json(['message' => trans('messages.invalid_credentials')], 404);
        }

        $token = $client->createToken($request->device_name)->plainTextToken;

        return response()->json(['token', $token]);
    }

    public function me(Request $request)
    {
        //pega o usuário autenticado
        $client = $request->user();

        return new ClientResource($client);
    }

    public function logout(Request $request)
    {
        //pega o usuário autenticado
        $client = $request->user();

        //Revoke all token client...
        $client->tokens()->delete();

        return response()->json([], 204);
    }
}

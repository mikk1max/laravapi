<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;
class AuthController extends Controller
{
    public function register(Request $request) //rejestracja użytkownika
    { $validator = Validator::make($request->all(),[
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8'
    ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()
            ->json(['data' => $user,'access_token' => $token,
                'token_type' => 'Bearer', ]);
    }
    public function login(Request $request) //logowanie
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()
                ->json(['message' => 'Zły login lub hasło!'], 401);
        }
        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()
            ->json(['message' => 'Hi '.$user->name,
                'access_token' => $token, 'token_type' => 'Bearer', ]);
    }
// method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }
}

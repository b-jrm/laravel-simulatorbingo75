<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Validator;

use App\Models\User;
use App\Models\Token;

class AccessController extends Controller
{
    public function register(Request $request){

        $validator = Validator::make($request->all(),[
            // 'name' => 'required string max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string min:8'
        ]);

        if( $validator->fails() )
            return response()->json($validator->errors())->getContent();

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if( empty($user) )
            return response()->json([ 'msg' => 'Failed register' ])->getContent();

        $token = $user->createToken('auth_token')->plainTextToken;

        if( empty($token) )
            return response()->json([ 'msg' => 'Failed create token' ], 401 )->getContent();

        $last_token = Token::where('user_id',$user->user_id)->first();
        if( !empty($last_token) ){
            $last_token->token = $token;
            $last_token->expires_at = date('Y-m-d H:i:s', strtotime("+ 1 days"));
            $last_token->save();
        }else{
            Token::create([ 
                'user_id' => $user->user_id,
                'token' => $token,
                'expires_at' => date('Y-m-d H:i:s', strtotime("+ 1 days"))
            ]);
        }

        return response()->json([ 
            'msg' => 'Welcome, '.$user->email.'!', 
            'access' => [ 
                'type' => 'Bearer', 
                'token' => $token 
            ]
        ]);

    }

    public function login(Request $request){

        if( !Auth::attempt($request->only('email','password')) )
            return response()->json([ 'msg' => 'Unauthorized Credentials' ], 401 )->getContent();

        $user = User::where('email',$request->email)->where('verified_at','!=',null)->first();

        if( !empty($user) )
            return response()->json([ 'msg' => 'Unauthorized User' ], 401 )->getContent();

        $token = $user->createToken('auth_token')->plainTextToken;

        if( empty($token) )
            return response()->json([ 'msg' => 'Unauthorized' ], 401 )->getContent();

        $last_token = Token::where('user_id',$user->user_id)->first();
        if( !empty($last_token) ){
            $last_token->token = $token;
            $last_token->expires_at = date('Y-m-d H:i:s', strtotime("+ 1 days"));
            $last_token->save();
        }else{
            Token::create([ 
                'user_id' => $user->user_id,
                'token' => $token,
                'expires_at' => date('Y-m-d H:i:s', strtotime("+ 1 days"))
            ]);
        }

        return response()->json([ 
            'msg' => 'Authorized, '.$user->email.'!', 
            'access' => [ 
                'type' => 'Bearer', 
                'token' => $token 
            ]
        ]);

    }
}

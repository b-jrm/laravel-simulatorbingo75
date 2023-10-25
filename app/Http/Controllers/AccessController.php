<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Validator;

use App\Models\User;
use App\Models\Token;
use App\Models\Information;

class AccessController extends Controller
{
    public function register(Request $request){

        $validator = Validator::make($request->all(),[
            // 'name' => 'required string max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if( $validator->fails() )
            return response()->json(['status' => 0, 'result' => $validator->errors()])->getContent();

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if( !empty($user) && isset($request->name)){
            Information::create([
                'user_id' => $user->user_id,
                'nickname' => $request->name
            ]);
        }

        if( empty($user) )
            return response()->json([ 'status' => 0, 'result' => 'Failed register' ])->getContent();

        $token = $user->createToken('auth_token')->plainTextToken;

        if( empty($token) )
            return response()->json([ 'status' => 0, 'result' => 'Failed create token' ], 401 )->getContent();

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
            'status' => 1,
            'result' => 'Welcome, '.$user->email.'!', 
            'access' => [ 
                'type' => 'Bearer', 
                'token' => $token 
            ],
            'user' => [
                'email' => $user->email,
                'name' => $request->name?? null,
            ]
        ]);

    }

    public function login(Request $request){

        if( !Auth::attempt($request->only('email','password')) )
            return response()->json([ 'status' => 0, 'result' => 'Unauthorized Credentials' ], 401 )->getContent();

        $user = User::where('email',$request->email)->where('verified_at','!=',null)->first();

        if( empty($user) )
            return response()->json([ 'status' => 0, 'result' => 'Unauthorized User' ], 401 )->getContent();

        $token = $user->createToken('auth_token')->plainTextToken;

        if( empty($token) )
            return response()->json([ 'status' => 0, 'result' => 'Unauthorized' ], 401 )->getContent();

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
            'status' => 1,
            'result' => 'Authorized, '.$user->email.'!', 
            'access' => [ 
                'type' => 'Bearer', 
                'token' => $token 
            ]
        ]);

    }
    
    public function confirmation(Request $request){

        $user = User::where('user_id',$request->user_id)->where('verified_at',null)->first();

        if( empty($user) )
            return response()->json([ 'status' => 0, 'result' => 'Unknown or expired link' ], 401 )->getContent();

        $user->verified_at = date('Y-m-d H:i:s');
        $user->save();

        return response()->json([ 
            'status' => 1,
            'result' => 'Confirmed, '.mb_strtolower($user->email).'!', 
        ]);

    }

    public function auth(Request $request){

        $authorized = [ 
            'status' => 0,
            'result' => 'Unknown or Expired Token'
        ];

        if( $request->bearerToken() ){
            $token = Token::select(
                    'users.email',
                    'users.verified_at',
                    'informations.nickname',
                    'informations.photo',
                    'informations.firstname',
                    'informations.lastname',
                    'informations.photo',
                    'tokens.expires_at'
                )
                ->join('users', 'tokens.user_id', 'users.user_id')
                ->join('informations', 'users.user_id', 'informations.user_id')
                ->where('tokens.token',$request->bearerToken())
                ->first();

            if(!empty($token) && date('Y-m-d H:i:s') <= date('Y-m-d H:i:s', strtotime($token['expires_at']))){
                $authorized['status'] = 1;
                $authorized['result'] = 'The token is valid';
                $authorized['user'] = [
                    'email' => $token['email'],
                    'name' => $token['nickname'],
                    'firstname' => $token['firstname'],
                    'lastname' => $token['lastname'],
                    'photo' => $token['photo']
                ];
            }
        }

        return response()->json($authorized);

    }
}

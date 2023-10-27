<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Validator;

use App\Models\User;
use App\Models\Token;
use App\Models\Information;
use App\Models\Game;
use App\Models\Context;
use App\Models\Inscription;

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

        
        Token::create([ 
            'user_id' => $user->user_id,
            'token' => $token,
            'expires_at' => date('Y-m-d H:i:s', strtotime("+ 1 days"))
        ]);

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
                'verified_at' => $user->verified_at
            ]
        ]);

    }

    public function login(Request $request){
           
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        
        $remember = ($request->has('remember') ? true : false);
        
        if(!Auth::attempt($credentials, $remember))
            return response()->json([ 'status' => 0, 'result' => 'Unauthorized Credentials User' ], 401 )->getContent();
        
        
        $user = User::select(
                    'users.user_id',
                    'users.email',
                    'users.verified_at',
                    'informations.nickname'
                )
                ->leftJoin('informations','users.user_id','informations.user_id')
                ->where('users.email',$request->email)
                    ->first();

        if(empty($user))
            return response()->json([ 'status' => 0, 'result' => 'Unknown Credentials User' ], 401 )->getContent();
            
        $last_token = Token::where('user_id',$user->user_id)
                            ->where('expires_at','>',date('Y-m-d H:i:s'))
                            ->first();

        if( !empty($last_token) ){
            $token = $last_token->token;
            $last_token->expires_at = date('Y-m-d H:i:s', strtotime("+ 1 days"));
            $last_token->save();
        }else{
            $token = $user->createToken('auth_token')->plainTextToken;
            Token::create([ 
                'user_id' => $user->user_id,
                'token' => $token,
                'expires_at' => date('Y-m-d H:i:s', strtotime("+ 1 days"))
            ]);
        }

        return response()->json([ 
            'status' => 1,
            'result' => 'Authorized, '.$user->email.'!', 
            'user' => [
                'email' => $user->email,
                'name' => $user->nickname,
                'verified_at' => $user->verified_at,
            ],
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
                    'photo' => $token['photo'],
                    'verified_at' => $token['verified_at']
                ];
            }
        }

        return response()->json($authorized);

    }
    
    public function programmed(Request $request){

        $response = [ 
            'status' => 0,
            'result' => 'Without games programmed'
        ];

        $games = Context::select(
            'contexts.name',
            'games.game_id',
            'games.time_start',
            'games.max_players',
            'games.min_players',
            'games.price_bet',
            'games.price_win',
        )->join('games','contexts.context_id', 'games.context_id')
        ->where('games.time_start','>',date('Y-m-d H:i:s'))
        ->get();

        

        if(!empty($games)){
            
            $response['status'] = 1;
            $response['total'] = count($games);
            $response['result'] = 'Records success';
            $response['data'] = [];
            foreach($games as $game){
                
                $formatted = $this->formatDate($game['time_start'], '{name_day}, {day} {name_month} {year} - {hours}:{minutes}{meridiem}');
                
                $inscribed = Inscription::where('status',1)
                            ->where('game_id',$game['game_id'])
                            ->count();
                
                array_push($response['data'], [
                    'id' => $game['game_id'],
                    'name' => $game['name'],
                    'max' => $game['max_players'],
                    'min' => $game['min_players'],
                    'symbol_currency' => '$',
                    'currency' => 'COP',
                    'bet' => number_format($game['price_bet'], 2, ',', '.'),
                    'win' => number_format($game['price_win'], 2, ',', '.'),
                    'inscribed' => $inscribed,
                    'date' => $formatted,
                ]);
            }

        }

        return response()->json($response);

    }
    
}

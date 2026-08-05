<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cookie;
// use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Support\Str;

use App\Models\Mode;
use App\Models\Context;
use App\Models\Submode;
use App\Models\Coordinate;
use App\Models\Submode_coordinate;

use App\Http\Traits\Bingo75;

class SimulatorController extends Controller
{
    protected $path = 'modules.simulator.';
    protected $cookie = 'simulator';
    protected $store = 'simulator';
    protected $disk = 'simulator';
    protected $extension = 'json';
    protected $hash;

    public function render(): View
    {
        $contexts = Context::all();
        $modes = Mode::all();
        return view($this->path.'dash', compact('contexts','modes'));
    }

    public function game(Request $request): View
    {
        if( !empty($request->_st) ){
            if(Storage::disk($this->disk)->exists($request->_st.'.'.$this->extension))
                $this->hash = $request->_st;
            $config = Storage::disk($this->disk)->json($this->hash.'.'.$this->extension);
            // var_dump(json_encode($config)); exit;
        }else $config = null;
        // dd($this->path.'game');
        return view($this->path.'game', compact('config'));

    }
    
    public function game2(Request $request): View
    {
        if( !empty($request->_st) ){
            if(Storage::disk($this->disk)->exists($request->_st.'.'.$this->extension))
                $this->hash = $request->_st;
            $config = Storage::disk($this->disk)->json($this->hash.'.'.$this->extension);
        }else $config = null;
        // dd($request->all());
        return view($this->path.'game2', compact('config'));

    }

    public function game3(Request $request): View
    {
        if( !empty($request->_st) ){
            if(Storage::disk($this->disk)->exists($request->_st.'.'.$this->extension))
                $this->hash = $request->_st;
            $config = Storage::disk($this->disk)->json($this->hash.'.'.$this->extension);
        }else $config = null;
        // dd($request->all());
        return view($this->path.'game3', compact('config'));

    }

    public function sync(Request $request){
        // dd($request->all());
        if( !empty($request->storage) )
            $config = Storage::disk($this->disk)->json($request->storage.'.'.$this->extension);
        
        if( isset($config) ){
            foreach($request->sync as $name => $module){
                // if( isset($config[$name]) )
                    $config[$name] = $module;
            }
            // dd($config);
            Storage::disk($this->disk)->put($request->storage.'.'.$this->extension, json_encode($config));
        }
    }

    public function loading(Request $request)
    {
        $this->hash = $request->cookie($this->cookie);

        if( !empty($request->storage) )
            $config = Storage::disk($this->disk)->json($request->storage.'.'.$this->extension);
        
        if( isset($config) ){
            $load = $config[$request->module]?? null;
        }else{
            switch ($request[0]) {
                case 'board':
                    $load = Bingo75::board();
                    break;
                default:
                    $load = null;
                    break;
            }
        }
        echo response()->json($load)->getContent();

    }

    public function storage(Request $request)
    {
        if( !empty($request->storage) ){
            if(Storage::disk($this->disk)->exists($request->storage.'.'.$this->extension))
                $this->hash = $request->storage;
            $config = Storage::disk($this->disk)->json($this->hash.'.'.$this->extension);
        }
        echo response()->json( [ 'local' => $this->store, 'conf' => $this->hash?? null ] )->getContent();
    }

    public function forget(Request $request)
    {
        if( !empty($request->storage) ){
            $this->hash = $request->storage;
            if(Storage::disk($this->disk)->exists($this->hash.'.'.$this->extension))
                Storage::disk($this->disk)->delete($this->hash.'.'.$this->extension);
            $this->hash = null;
        }
        echo response()->json( [ 'local' => $this->store, 'conf' => $this->hash ] )->getContent();
    }

    public function start(Request $request)
    {
        // $this->hash = $request->cookie($this->cookie);
        // if( !empty($this->hash) ) // Continue game simulator from Cookie

        if( !empty($request->storage) ){
            if(Storage::disk($this->disk)->exists($request->storage.'.'.$this->extension)){
                $this->hash = $request->storage;
                $config = Storage::disk($this->disk)->json($this->hash.'.'.$this->extension);
            }
        }
            
        if( !isset($config) ){
            // Create new game simulator
            $this->hash = Str::replace('/', '', Hash::make(Str::random(10)));
            // Cookie::make($this->cookie, $this->hash, 44640);
            // Cookie::queue(Cookie::make($this->cookie, $this->hash))
            $config = $request->all();
            $config['sequence'] = array();
            $config['ranks'] = Bingo75::ranks();
            $config['cartons'] = Bingo75::cartons($request->count_cartons);
            $config['board'] = Bingo75::board();
            Storage::disk($this->disk)->put($this->hash.'.'.$this->extension, json_encode($config));
        }

        echo response()->json([ 'local' => $this->store, 'conf' => $this->hash?? null ])->getContent();
    }

    

    public function contexts(){

        return response()->json(Context::select('context_id','name','rows','columns','mode','is_with_letters')->get())->getContent();

    }

    public function modes(){

        return response()->json(Mode::all())->getContent();

    }

    public function getModes($context_id){

        return response()->json(Mode::where('context_id',$context_id)->get())->getContent();

    }

    public function getSubmodes($mode_id){

        $submodes = Submode::select(
                        'submodes.submode_id',
                        'submodes.name',
                        'contexts.mode',
                        'contexts.rows',
                        'contexts.columns'
                    )
                    ->join('modes','modes.mode_id','submodes.mode_id')
                    ->join('contexts','contexts.context_id','modes.context_id')
                    ->where('submodes.mode_id',$mode_id)->get();

        foreach($submodes as $submode){
            $submode->coordinates = $this->coordsSubmodes($submode->submode_id);
        }

        return response()->json($submodes)->getContent();

    }

    public function coordsSubmodes(Int $submode_id, Bool $json = false){

        $coordinates = Coordinate::select(
                            'coordinates.x',
                            'coordinates.y'
                        )
                        ->join('submodes_coordinates','submodes_coordinates.coordinate_id','coordinates.coordinate_id')
                        ->where('submodes_coordinates.submode_id',$submode_id)
                        ->orderBy('coordinates.coordinate_id')
                        ->get();

        return ( ($json) ? response()->json($coordinates)->getContent() : $coordinates );

    }

    public function generator(Int $count = 1): View
    {
        $cartons = Bingo75::cartons($count);
        // dd($cartons);
        return view('modules.generators.cartons75', compact('cartons'));

    }

    
    


    

    
}

<?php

namespace App\Http\Traits;

trait Simulator {

    public static function validator(){
        try{
            
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

}
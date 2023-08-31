<?php

namespace App\Http\Traits;

use Illuminate\View\View;

trait Design {
    protected static $design = 'default';
    public static function design(Array $data = [], String $name = "404"){

        $content = file_get_contents(view("designs.".self::$design.".".$name.".htm"));



        dd($content);
    }

}
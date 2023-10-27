<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Http\Traits\Design;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function formatDate($date, $format = '{year}/{month}/{day} {hours}:{minutes}:{seconds}{meridiem}, {name_day} of {name_week}'){

        $year = date('Y',strtotime($date));
        $month = date('m',strtotime($date));
        $day = date('d',strtotime($date));
        $hours = date('H',strtotime($date));
        $minutes = date('i',strtotime($date));
        $seconds = date('s',strtotime($date));
        $name_day = $this->nameDay(date('w',strtotime($date)));
        $name_month = $this->nameMonth(date('n',strtotime($date)));
        
        $meridiem = date('a',strtotime($date));

        $formatted = str_replace("{year}",$year, $format);
        $formatted = str_replace("{month}",$month, $formatted);
        $formatted = str_replace("{day}",$day, $formatted);
        $formatted = str_replace("{hours}",$hours, $formatted);
        $formatted = str_replace("{minutes}",$minutes, $formatted);
        $formatted = str_replace("{seconds}",$seconds, $formatted);
        $formatted = str_replace("{name_day}",$name_day, $formatted);
        $formatted = str_replace("{name_month}",$name_month, $formatted);
        $formatted = str_replace("{meridiem}",$meridiem, $formatted);
        
        return [
            'year' => $year, 
            'month' => $month, 
            'day' => $day, 
            'hours' => $hours, 
            'minutes' => $minutes, 
            'seconds' => $seconds, 
            'name_day' => $name_day, 
            'name_month' => $name_month, 
            'meridiem' => $meridiem, 
            'full' => $formatted
        ];

    }
    
    public function nameDay($day){
        $week = [
            'Domingo',
            'Lunes',
            'Martes',
            'Miercoles',
            'Jueves',
            'Viernes',
            'Sabado'
        ];
        return $week[$day];
    }
    
    public function nameMonth($month){
        $months = [
            0 => 'Enero',
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];
        return $months[$month];
    }

}

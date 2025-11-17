<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measure extends Model
{
    use HasFactory;

    const UNIT_SERVICE_ID = 58;


    public static function getAllMeasureDropBox(){
        return ['' => ''] + Measure::orderBy('description', 'asc')->pluck('description', 'codigo_clasificador')->all();
    }
}

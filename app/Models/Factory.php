<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Factory extends Model
{
    use HasFactory;

    public static function getAllFactoryDropBox(){
        return Factory::select('id', DB::raw("concat(name, ' (', IFNULL(origin, '-'), ')') as n_o"))->orderBy('name', 'asc')->pluck('n_o', 'id')->prepend('Seleccione Fabrica', '');
    }
}

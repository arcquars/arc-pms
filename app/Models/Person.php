<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    const GENDER_MALE = 'MALE';
    const GENDER_FEMALE = 'FEMALE';

    protected $fillable = [
        'first_name',
        'last_name_paternal',
        'last_name_maternal',
        'document_type',
        'document',
        'document_complement',
        'gender',
    ];

    protected $appends = ['fullname'];

    public function getFullnameAttribute()
    {
        $fullname = "";
        if($this->last_name_maternal){
           $fullname = $this->last_name_paternal . " " . $this->last_name_maternal . " " . $this->first_name;
        } else {
            $fullname = $this->last_name_paternal . " " . $this->first_name;
        }
        return $fullname;
    }
}

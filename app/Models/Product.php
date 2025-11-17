<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'price_reference',
        'price_minimum',
        'coste',
        'measure',
        'description',
        'active',
        'category',
        'factory',
        'filename',
        'filename500',
    ];

    public function extraSales()
    {
        return $this->hasMany(ExtraSale::class);
    }

    /**
     * Obtiene la categoría a la que pertenece el producto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getPathImageAttribute(){
        if($this->filename500){
            return $this->filename500;
        }

        return asset('img/default/sin-imagen-2-500.jpg');
    }

    public static function getAllProductsDropBox(){
        return Product::select('id', 'name')->where('active', 1)->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Seleccione producto', '');
    }
}

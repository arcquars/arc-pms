<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;

    /**
     * Obtiene los productos asociados a la categoría.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category', 'id');
    }

    /**
     * Scope a una consulta para incluir solo productos activos.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('deleted', false)->orderBy('name', 'asc');
    }


    public static function getAllCategoryDropBox(){
        return Category::select('id', 'name')->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Seleccione Categoria', '');
    }

    public static function getCategoriesAndProductsDropBox(): array
    {
        $optCategories = [];
        /** @var Category [] $categories */
        $categories = Category::active()->get();
        foreach ($categories as $category){
            $optProducts = [];
            foreach ($category->products as $product){
                $optProducts[] = ['name' => $product->name, 'id' => $product->id];
            }
            if(count($optProducts) > 0){
                $optCategories[] = [
                    'name' => $category->name,
                    'products' => $optProducts
                ];
            }
        }
        return $optCategories;
    }
}

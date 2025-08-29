<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
     protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(Categorie::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Categorie::class, 'parent_id');
    }
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(Categorie::class, 'subcategory_id');
    }
    
public function subProducts()
{
    return $this->hasMany(Product::class, 'subcategory_id');
}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'type',
        'thumbnail',
        'background_image',
        'text_zones',
        'image_zones',
        'status',
         'price',
          'subcategory_id'
    ];

    protected $casts = [
        'text_zones' => 'array',
        'image_zones' => 'array',
        'status' => 'boolean',
    ];

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }
     // Optional: Relationship with Orders
    // public function orders()
    // {
    //     return $this->hasMany(Order::class);
    // }

    public function subcategory()
{
    return $this->belongsTo(Categorie::class, 'subcategory_id');
}
}

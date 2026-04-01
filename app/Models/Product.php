<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'category', 'brand', 
        'warranty_duration', 'product_image_url', 
        'service_center_name', 'service_center_address'
    ];

    /**
     * Image path getter
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->product_image_url);
    }

    public function warranties()
    {
        return $this->hasMany(Warranty::class);
    }
}

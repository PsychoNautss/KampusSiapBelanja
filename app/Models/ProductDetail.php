<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $table = 'product_details';
    protected $fillable = ['description', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'product_detail_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    /**
     * Table name is `rating_reviews` (migration created that table).
     */
    protected $table = 'rating_reviews';
    protected $fillable = ['user_id', 'product_id', 'rating', 'review', 'province'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

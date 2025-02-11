<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'price', 'category_id', 'stock', 'discount', 'discount_start', 'discount_end'];


    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getDiscountedPriceAttribute()
    {
        if ($this->discount > 0 && $this->discount_start <= now() && $this->discount_end >= now()) {
            return $this->price - ($this->price * ($this->discount / 100));
        }
        return $this->price;
    }
    
    
}

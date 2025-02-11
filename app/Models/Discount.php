<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'discount_percent', 'valid_until'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function productCategory() {
        return $this->belongsTo(ProductCategory::class);
    }

    public function cartItem() {
        return $this->hasMany(CartItem::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'product_transaction')->withPivot('quantity');
    }
}

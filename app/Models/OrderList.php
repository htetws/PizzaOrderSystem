<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderList extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'qty', 'order_code', 'total'];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}

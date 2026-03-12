<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id_orders';

    protected $fillable = [
        'user_id', 'order_code', 'total_amount', 'status', 'payment_method', 'payment_ref', 'paid_at'
    ];

    // Relasi
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id_users');
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class, 'order_id', 'id_orders');
    }
}

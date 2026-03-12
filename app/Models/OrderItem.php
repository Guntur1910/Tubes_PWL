<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id_order_items';

    protected $fillable = [
        'order_id', 'ticket_type_id', 'quantity', 'unit_price', 'sub_total'
    ];

    // Relasi
    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'id_orders');
    }

    public function ticketType() {
        return $this->belongsTo(TicketType::class, 'ticket_type_id', 'id_ticket_types');
    }
}

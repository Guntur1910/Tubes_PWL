<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Ticket extends Model
{
    protected $table = 'tickets';
    protected $primaryKey = 'id_tickets';

    protected $fillable = [
        'order_item_id', 'user_id', 'event_id', 'ticket_type_id', 'ticket_code', 'qr_code_url', 'holder_name', 'is_used', 'used_at'
    ];

    // Relasi
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id_users');
    }

    public function event() {
        return $this->belongsTo(Event::class, 'event_id', 'id_events');
    }
}

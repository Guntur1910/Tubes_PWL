<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{
    protected $table = 'waiting_list';
    protected $primaryKey = 'id_waiting_list';

    protected $fillable = [
        'user_id', 'ticket_type_id', 'position', 'status', 'notified_at'
    ];

    // Relasi
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id_users');
    }

    public function ticketType() {
        return $this->belongsTo(TicketType::class, 'ticket_type_id', 'id_ticket_type');
    }
}

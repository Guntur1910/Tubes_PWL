<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $table = 'ticket_type';
    protected $primaryKey = 'id';

    protected $fillable = [
        'event_id', 'name', 'description', 'price', 'quota', 'sold', 'sales_start', 'sales_end'
    ];

    // Relasi
    public function event() {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function transactions() {
        return $this->hasMany(Transaction::class, 'ticket_type_id');
    }

    public function waitingLists() {
        return $this->hasMany(WaitingList::class, 'ticket_type_id');
    }
}

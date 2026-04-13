<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'name',
        'description',
        'date',
        'location',
        'quota',
        'price',
        'organizer_id'
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class, 'event_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'event_id');
    }
}
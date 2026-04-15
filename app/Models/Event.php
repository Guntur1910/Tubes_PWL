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
        'organizer_id',
        'category',
        'poster'
    ];

    // FIX: nama harus plural & konsisten
    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class, 'event_id', 'id');
    }
}
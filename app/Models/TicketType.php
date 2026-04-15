<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $table = 'ticket_type';

    protected $primaryKey = 'id_ticket_type';

    protected $fillable = [
        'event_id',
        'name',
        'description',
        'price',
        'quota',
        'sold',
        'sales_start',
        'sales_end'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
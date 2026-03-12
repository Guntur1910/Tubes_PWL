<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id_events';

    protected $fillable = [
        'organizer_id', 'category_id', 'title', 'description',
        'banner_url', 'location', 'address',
        'start_date', 'end_date', 'status'
    ];

    // Relasi
    public function organizer() {
        return $this->belongsTo(User::class, 'organizer_id', 'id_users');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id_category');
    }

    public function ticketTypes() {
        return $this->hasMany(TicketType::class, 'event_id', 'id_events');
}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{
    protected $fillable = [
        'user_id', 'ticket_type_id', 'quantity', 'status', 'notified_at', 'expires_at'
    ];

    protected $casts = [
        'notified_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }

    // Helper methods
    public function isWaiting()
    {
        return $this->status === 'waiting';
    }

    public function isNotified()
    {
        return $this->status === 'notified';
    }

    public function markAsNotified()
    {
        $this->update([
            'status' => 'notified',
            'notified_at' => now()
        ]);
    }

    public function markAsPurchased()
    {
        $this->update(['status' => 'purchased']);
    }

    public function markAsExpired()
    {
        $this->update(['status' => 'expired']);
    }
}

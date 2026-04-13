<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'transaction_id', 'ticket_code', 'qr_code_path', 'status', 'used_at'
    ];

    protected $casts = [
        'used_at' => 'datetime',
    ];

    // Relasi
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class, 'ticket_type_id');
    }

    // Helper methods
    public function isUsed()
    {
        return $this->status === 'used';
    }

    public function markAsUsed()
    {
        $this->update([
            'status' => 'used',
            'used_at' => now()
        ]);
    }

    public function generateTicketCode()
    {
        return 'TKT-' . strtoupper(substr(md5(uniqid()), 0, 8));
    }
}

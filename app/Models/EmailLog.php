<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $table = 'email_logs';
    protected $primaryKey = 'id_email_logs';

    protected $fillable = [
        'user_id', 'ticket_id', 'type', 'recipient', 'subject', 'status', 'sent_at'
    ];

    // Relasi
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id_users');
    }
}

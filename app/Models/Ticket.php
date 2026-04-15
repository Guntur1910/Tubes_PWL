<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'transaction_id',
        'ticket_code',
        'qr_code_path',
        'status',
        'used_at'
    ];

    protected $casts = [
        'used_at' => 'datetime',
    ];

    // =========================
    // RELATION
    // =========================
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // =========================
    // HELPER
    // =========================
    public function isUsed()
    {
        return $this->status === 'used';
    }



    public static function generateCode()
    {
        return 'TKT-' . strtoupper(\Illuminate\Support\Str::random(8));
    }
    public function markAsUsed()
    {
        $this->status = 'used';
        $this->used_at = now();
        $this->save();
    }
}

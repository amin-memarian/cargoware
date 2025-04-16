<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingReservation extends Model
{
    use HasFactory;

    protected $table = 'pending_reservations';

    protected $fillable = [
        'user_id',
        'agent_id',
        'load_detail_id',
        'origin',
        'destination',
        'load_weight',
        'send_at',
        'received_by_agent_at',
    ];

}

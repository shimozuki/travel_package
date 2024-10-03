<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'port_from_id',
        'port_to_id',
        'departure_date',
        'return_date',
        'price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

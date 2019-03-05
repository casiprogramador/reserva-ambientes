<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Model\Ambiente;

class Reserva extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ambiente()
    {
        return $this->belongsTo(Ambiente::class);
    }
}

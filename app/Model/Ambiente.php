<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Reserva;

class Ambiente extends Model
{
    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}

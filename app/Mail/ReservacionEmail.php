<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Model\Reserva;

class ReservacionEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $reserva;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reserva)
    {
        $this->reserva = $reserva;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@sudseguros.com')
                ->view('email_notification')
                ->subject('Reserva de Ambiente');
    }
}

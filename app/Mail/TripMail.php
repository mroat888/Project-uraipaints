<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TripMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $trip_header;
    protected $trip_detail;

    function __construct($trip_header, $trip_detail) 
    {
        $this->trip_header = $trip_header;
        $this->trip_detail = $trip_detail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->subject('This is my Test Mail Subject')
                    ->view('mail.trip_user_mail', [
                        'trip_header' => $this->trip_header,
                        'trip_detail' => $this->trip_detail,
                    ]);
    }
}

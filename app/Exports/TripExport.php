<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TripExport implements FromView
{
    protected $trip_header;

    function __construct($trip_header, $trip_sel_date, $user_head) {
        $this->trip_header = $trip_header;
        $this->trip_sel_date = $trip_sel_date;
        $this->user_head = $user_head;
    }

    public function view(): View
    {
        return view('excel.trip_report', [
            'trip_header' => $this->trip_header,
            'trip_sel_date' => $this->trip_sel_date,
            'user_head' => $this->user_head,
        ]);
    }
}

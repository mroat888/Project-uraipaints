<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TripExport implements FromView
{
    protected $trip_header;

    function __construct($trip_header) {
        $this->trip_header = $trip_header;
    }

    public function view(): View
    {
        return view('excel.trip_report', [
            'trip_header' => $this->trip_header,
        ]);
    }
}

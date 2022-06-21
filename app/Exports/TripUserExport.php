<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TripUserExport implements FromView
{
    protected $trip_header;
    protected $trip_detail;

    function __construct($trip_header, $trip_detail) {
        $this->trip_header = $trip_header;
        $this->trip_detail = $trip_detail;
    }

    public function view(): View
    {
        return view('excel.trip_user_report', [
            'trip_header' => $this->trip_header,
            'trip_detail' => $this->trip_detail,
        ]);
    }
}

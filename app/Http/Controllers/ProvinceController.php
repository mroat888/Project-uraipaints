<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvinceController extends Controller
{
    public function amphur($id){
        $data_amphurs = DB::table('amphur')
            ->where('PROVINCE_ID', $id)
            ->orderBy('AMPHUR_NAME', 'asc')
            ->select('amphur.*')->get();

        return response()->json([
            'status' => 200,
            'amphurs' => $data_amphurs
        ]);
    }

    public function district($id){
        $data_district = DB::table('district')
            ->where('AMPHUR_ID', $id)
            ->orderBy('DISTRICT_NAME', 'asc')
            ->select('district.*')->get();

        return response()->json([
            'status' => 200,
            'districts' => $data_district
        ]);
    }

    public function postcode($id){
        $data_postcode = DB::table('amphur')
            ->join('district', 'amphur.AMPHUR_ID', 'district.AMPHUR_ID')
            ->where('DISTRICT_ID', $id)
            ->orderBy('AMPHUR_NAME', 'asc')
            ->select('amphur.POSTCODE')->first();

        return response()->json([
            'status' => 200,
            'postcode' => $data_postcode
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use DataTables;

class ApiController extends Controller
{
    public function apiToken(){
        // -----  API
        // dd(env("API_LINK"));
        $response = Http::post(env("API_LINK").'api/auth/login', [
            'username' => env("API_USER"),
            'password' => env("API_PASS"),
        ]);
        $res = $response->json();
        $api_token = $res['data'][0]['access_token'];

        return $api_token;
    }

    public function getAllSellers(){
        $api_token = $this->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers');
        $res_api = $response->json();
        return $res_api;
    }

    public function fetch_subgroups($id){

        $api_token = $this->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/subgroups/');
        $res_api = $response->json();
        $subgroups = array();
        foreach($res_api['data'] as $value){
            if($value['group_id'] == $id){
                $subgroups[] = [
                    'identify' => $value['identify'],
                    'name' => $value['name'],
                    'group_id' => $value['group_id']
                ];
            }
        }
        return response()->json([
            'status' => 200,
            'id' => $id,
            'subgroups' => $subgroups
        ]);

    }

    public function fetch_pdglists($id){

        $api_token = $this->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/pdglists/');
        $res_api = $response->json();
        $pdglists = array();
        foreach($res_api['data'] as $value){
            if($value['sub_code'] == $id){
                $pdglists[] = [
                    'identify' => $value['identify'],
                    'name' => $value['name'],
                    'sub_code' => $value['sub_code']
                ];
            }
        }
        return response()->json([
            'status' => 200,
            'id' => $id,
            'pdglists' => $pdglists
        ]);

    }

    public function fetch_amphur_api($id){

        $api_token = $this->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/provinces/'.$id.'/amphures/');
        $res_api = $response->json();
        $amphures = array();
        foreach($res_api['data'] as $value){
            $amphures[] = [
                'identify' => $value['identify'],
                'name_thai' => $value['name_thai'],
                'province_id' => $value['province_id']
            ];
        }

        return response()->json([
            'status' => 200,
            'id' => $id,
            'amphures' => $res_api
        ]);
    }


    public function fetch_products($id){

        $api_token = $this->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/products?productlist_id='.$id);
        $res_api = $response->json();
        $products = array();
        foreach($res_api['data'] as $value){
            if($value['list_code'] == $id){
                $products[] = [
                    'identify' => $value['identify'],
                    'name' => $value['name'],
                ];
            }
        }
        return Datatables::of($products)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['name'];
        })
        ->make(true);
    }

    //-- สำหรับ Seller--
    public function fetch_provinces_products($id){

        $api_token = $this->apiToken();
        $path_search = "/sellers/".Auth::user()->api_identify."/pdglists/".$id."/provinces";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        $res_api = $response->json();
        $provinces = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $provinces[] = [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                    'region_id' => $value['region_id']
                ];
            }
        }

        return response()->json([
            'status' => 200,
            'id' => $id,
            'provinces' => $provinces
        ]);
    }

    public function fetch_amphur_products($pdgid, $id){

        $api_token = $this->apiToken();
        $path_search = "/sellers/".Auth::user()->api_identify."/pdglists/".$pdgid."/amphures?province_id=".$id;
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        $res_api = $response->json();
        $provinces = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $amphures[] = [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                    'province_id' => $value['province_id']
                ];
            }
        }

        return response()->json([
            'status' => 200,
            'id' => $id,
            'amphures' => $amphures
        ]);
    }

    public function fetch_datatable_customer_sellers($pdgid,$pvid,$ampid){
        $api_token = $this->apiToken();
        $path_search = "sellers/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers?province_id=".$pvid."&amphoe_id=".$ampid;
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                ];
            }
        }

        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->make(true);
    }

    public function fetch_datatable_customer_sellers_pdglist($pdgid){
        $api_token = $this->apiToken();
        $path_search = "sellers/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                ];
            }
        }

        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->make(true);

    }

    public function fetch_datatable_customer_sellers_pdglist_pvid($pdgid, $pvid){
        $api_token = $this->apiToken();
        $path_search = "sellers/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers?province_id=".$pvid;
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                ];
            }
        }

        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->make(true);
    }
    //-- จบ สำหรับ Seller--


    /**
     *
     */

    //-- สำหรับ Leader--

    public function fetch_provinces_products_leaders($id){

        $api_token = $this->apiToken();
        $path_search = "/saleleaders/".Auth::user()->api_identify."/pdglists/".$id."/provinces";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        $res_api = $response->json();
        $provinces = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $provinces[] = [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                    'region_id' => $value['region_id']
                ];
            }
        }

        return response()->json([
            'status' => 200,
            'id' => $id,
            'provinces' => $provinces
        ]);
    }

    public function fetch_amphur_products_leaders($pdgid, $id){

        $api_token = $this->apiToken();
        $path_search = "/saleleaders/".Auth::user()->api_identify."/pdglists/".$pdgid."/amphures?province_id=".$id;
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        $res_api = $response->json();
        $provinces = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $amphures[] = [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                    'province_id' => $value['province_id']
                ];
            }
        }

        return response()->json([
            'status' => 200,
            'id' => $id,
            'amphures' => $amphures
        ]);
    }

    public function fetch_datatable_customer_leaders($pdgid,$pvid,$ampid){
        $api_token = $this->apiToken();
        $path_search = "saleleaders/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers?province_id=".$pvid."&amphoe_id=".$ampid;
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                ];
            }
        }
        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->make(true);
    }

    public function fetch_datatable_customer_leaders_pdglist($pdgid){
        $api_token = $this->apiToken();
        $path_search = "saleleaders/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                ];
            }
        }

        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->make(true);
    }

    public function fetch_datatable_customer_leaders_pdglist_pvid($pdgid, $pvid){
        $api_token = $this->apiToken();
        $path_search = "saleleaders/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers?province_id=".$pvid;
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                ];
            }
        }
        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->make(true);
    }
    //-- จบ สำหรับ Leader--


    /**
     *
     */

    //-- สำหรับ Header--

    public function fetch_provinces_products_headers($id){

        $api_token = $this->apiToken();
        $path_search = "/saleheaders/".Auth::user()->api_identify."/pdglists/".$id."/provinces";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        $res_api = $response->json();
        $provinces = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $provinces[] = [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                    'region_id' => $value['region_id']
                ];
            }
        }

        return response()->json([
            'status' => 200,
            'id' => $id,
            'provinces' => $provinces
        ]);
    }

    public function fetch_amphur_products_headers($pdgid, $id){

        $api_token = $this->apiToken();
        $path_search = "/saleheaders/".Auth::user()->api_identify."/pdglists/".$pdgid."/amphures?province_id=".$id;
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        $res_api = $response->json();
        $provinces = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $amphures[] = [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                    'province_id' => $value['province_id']
                ];
            }
        }

        return response()->json([
            'status' => 200,
            'id' => $id,
            'amphures' => $amphures
        ]);
    }

    public function fetch_datatable_customer_headers($pdgid,$pvid,$ampid){
        $api_token = $this->apiToken();
        $path_search = "saleheaders/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers?province_id=".$pvid."&amphoe_id=".$ampid;
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                ];
            }
        }


        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->make(true);
    }

    public function fetch_datatable_customer_headers_pdglist($pdgid){
        $api_token = $this->apiToken();
        $path_search = "saleheaders/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                ];
            }
        }

        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->make(true);
    }

    public function fetch_datatable_customer_headers_pdglist_pvid($pdgid, $pvid){
        $api_token = $this->apiToken();
        $path_search = "saleheaders/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers?province_id=".$pvid;
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                ];
            }
        }


        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->make(true);
    }
    //-- จบ สำหรับ Header--

    //-- สำหรับ Header--

    public function fetch_provinces_products_admin($id){

        $api_token = $this->apiToken();
        $path_search = "/provinces";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        $res_api = $response->json();
        $provinces = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $provinces[] = [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                    'region_id' => $value['region_id']
                ];
            }
        }

        return response()->json([
            'status' => 200,
            'id' => $id,
            'provinces' => $provinces
        ]);
    }

    public function fetch_amphur_products_admin($id){

        $api_token = $this->apiToken();
        $path_search = "/provinces/".$id."/amphures";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        $res_api = $response->json();
        $provinces = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $amphures[] = [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                    'province_id' => $value['province_id']
                ];
            }
        }

        return response()->json([
            'status' => 200,
            'id' => $id,
            'amphures' => $amphures
        ]);
    }

    public function fetch_datatable_customer_admin($ampid){
        $api_token = $this->apiToken();
        $path_search = "amphures/".$ampid."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                ];
            }
        }

        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->make(true);
    }

    // public function fetch_datatable_customer_headers_pdglist($pdgid){
    //     $api_token = $this->apiToken();
    //     $path_search = "saleheaders/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers";
    //     $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
    //     $res_api = $response->json();
    //     $customer = array();
    //     foreach($res_api['data'] as $value){
    //         $customer[] = [
    //             'identify' => $value['identify'],
    //             'title' => $value['title'],
    //             'name' => $value['name'],
    //         ];
    //     }
    //     return Datatables::of($customer)
    //     ->addIndexColumn()
    //     ->editColumn('identify',function($row){
    //         return $row['identify'];
    //     })
    //     ->editColumn('name',function($row){
    //         return $row['title']." ".$row['name'];
    //     })
    //     ->make(true);
    // }

    public function fetch_datatable_customer_admin_pdglist_pvid($pvid){
        $api_token = $this->apiToken();
        $path_search = "provinces/".$pvid."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                ];
            }
        }
        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->make(true);
    }

    //-- จบ สำหรับ Header--






}

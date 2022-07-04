<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use DataTables;

class ApiController extends Controller
{
    private $expire_time;
    private $api_token;

    private function keepAPIToken($token)
    {
        $pathToken = storage_path("/api");

        if ($token != '') {
            $data = ['token' => $token];

            if (!file_exists($pathToken)) {
                mkdir(storage_path("/api"), 0777, true);
            }

            file_put_contents($pathToken."/token.json", json_encode($data));
        }
    }

    private function loginAPI()
    {
        $response = Http::post(env("API_LINK").'api/auth/login', [
            'username' => env("API_USER"),
            'password' => env("API_PASS"),
        ]);
        $res = $response->json();

        $this->api_token = $res['data'][0]['access_token'];
        $this->expire_time = $res["data"][0]["expire_time"];

        $this->keepAPIToken($this->api_token);
    }

    private function checkTokenValid($token)
    {
        $response = Http::withToken($token)->get(env("API_LINK").'api/auth/token-expired');
        $res = $response->json();
        $code = $res["code"];

        if ($code == 200) {
            //token can be uses and keep datatime token for check refresh
            $this->expire_time = $res["data"][0]["expire_time"]; 
            $this->api_token = $token;

            $diffM = (strtotime($this->expire_time) -time()) / 60;
            
            //Age token less than 15 minute refresh new token
            if ($diffM < 15) {
                $response = Http::withToken($token)->post(env("API_LINK").'api/auth/refresh');
                $res = $response->json();
                $code = $res["code"];

                if ($code == 200) {
                    $this->expire_time = $res["data"][0]["expire_time"];
                    $this->api_token = $res["data"][0]["access_token"]; 

                    $this->keepAPIToken($this->api_token);
                    return true;
                } else {
                    return false;
                } 
            }
        } else {
            $this->loginAPI();
            
            return true;
        }
    }

    public function getAPIToken()
    {
        $pathToken = storage_path("api/token.json");

        if ($this->api_token == '') {
            if (file_exists($pathToken)) {
                $result = json_decode(file_get_contents($pathToken, true));

                $this->checkTokenValid($result->token);
            } else {
                $this->loginAPI();
            }
        } else {
            $this->checkTokenValid($this->api_token);
        }
    }
    
    public function apiToken(){
        // -----  API
        // dd(env("API_LINK"));
        // $response = Http::post(env("API_LINK").'api/auth/login', [
        //     'username' => env("API_USER"),
        //     'password' => env("API_PASS"),
        // ]);
        // $res = $response->json();
        // $api_token = $res['data'][0]['access_token'];

        $this->getAPIToken();

        return $this->api_token;
    }

    public function getAllSellers(){
        $api_token = $this->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers');
        $res_api = $response->json();
        return $res_api;
    }

    public function fetch_subgroups($id){

        $api_token = $this->apiToken();

        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/subgroups/', [
            'sortorder' => 'DESC',
            'group_id' => $id
        ]);
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
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/pdglists/',[
            'sortorder' => 'DESC',
            'subgroup_id' => $id,
        ]);
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

    public function fetch_amphur_api($path,$id){
        if($path != "admin"){
            $path_search = "/".$path."/".Auth::user()->api_identify."/amphures?province_id=".$id;
        }else{
            $path_search = "/provinces/".$id."/amphures/";
        }
        $api_token = $this->apiToken();
        //$response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/provinces/'.$id.'/amphures/');   
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);   
        $res_api = $response->json();
        $amphures = array();
        foreach($res_api['data'] as $value){
            if($value['province_id'] == $id){
                $amphures[] = [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                    'province_id' => $value['province_id']
                ];
            }
        }

        // dd($amphures);

        return response()->json([
            'status' => 200,
            'id' => $id,
            'amphures' => $amphures
        ]);
    }

    public function fetch_products($id){

        //-- ดึงแบบ API
        $api_token = $this->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/products?sort_by=product_code",[
            'productlist_id' => $id
        ]);

        $res_api = $response->json();
        $products = array();
        if($res_api['code'] == 200){
            
            foreach($res_api['data'] as $value){
                if($value['list_code'] == $id){
                    $products[] = [
                        'identify' => $value['identify'],
                        'name' => $value['name'],
                        'url_image' => $value['url_image'],
                        'pack_unit' => $value['pack_unit'],
                        'pack_ratio' => $value['pack_ratio'],
                    ];
                }
            }
        }

        return Datatables::of($products)
        ->addIndexColumn()
        ->editColumn('url_image',function($row){
            if($row['url_image'] != ""){
                $img = "<img src='".$row['url_image']."' style='width:100%'>";
            }else{
                $img = "";
            }
            return $img;
        })
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
         /**
         * ดึงแบบ API
         */
        // $api_token = $this->apiToken();
        // $path_search = "/sellers/".Auth::user()->api_identify."/pdglists/".$id."/provinces";
        // $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        // $res_api = $response->json();
        // $provinces = array();

        // if($res_api['code'] == 200){
        //     foreach($res_api['data'] as $value){
        //         $provinces[] = [
        //             'identify' => $value['identify'],
        //             'name_thai' => $value['name_thai'],
        //             'region_id' => $value['region_id']
        //         ];
        //     }
        // }

         /**
         * ดึงจากฐานข้อมูล และแปลงเป็น Array เพื่อไม่ต้องแก้ไขหน้า view
         */
        $api_provinces = DB::table('api_provinces')
        ->join('api_customers', 'api_customers.province_id', 'api_provinces.identify')
        ->leftJoin('api_customer_to_pdglist', 'api_customer_to_pdglist.customers_identify', 'api_customers.identify')
        ->where('api_customer_to_pdglist.pdglist_identify', $id)
        ->select('api_provinces.*')
        ->groupBy('api_provinces.identify')
        ->get();

        foreach($api_provinces as $value){
            $provinces[] = [
                'identify' => $value->identify,
                'name_thai' => $value->name_thai,
                'region_id' => $value->region_id
            ];
        }

        return response()->json([
            'status' => 200,
            'id' => $id,
            'provinces' => $provinces
        ]);
    }

    public function fetch_amphur_products($pdgid, $id){
        /**
         * ดึงแบบ API
         */
        // $api_token = $this->apiToken();
        // $path_search = "/sellers/".Auth::user()->api_identify."/pdglists/".$pdgid."/amphures?province_id=".$id;
        // $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        // $res_api = $response->json();
        // $provinces = array();

        // if($res_api['code'] == 200){
        //     foreach($res_api['data'] as $value){
        //         $amphures[] = [
        //             'identify' => $value['identify'],
        //             'name_thai' => $value['name_thai'],
        //             'province_id' => $value['province_id']
        //         ];
        //     }
        // }

        /**
         * ดึงจากฐานข้อมูล และแปลงเป็น Array เพื่อไม่ต้องแก้ไขหน้า view
         */
        $api_amphures = DB::table('api_amphures')
        ->join('api_customers', 'api_customers.amphoe_id', 'api_amphures.identify')
        ->leftJoin('api_customer_to_pdglist', 'api_customer_to_pdglist.customers_identify', 'api_customers.identify')
        ->where('api_customer_to_pdglist.pdglist_identify', $pdgid)
        ->where('api_amphures.province_id', $id)
        ->select('api_amphures.*')
        ->groupBy('api_amphures.identify')
        ->get();

        $amphures = array();

        foreach($api_amphures as $value){
            $amphures[] = [
                'identify' => $value->identify,
                'name_thai' => $value->name_thai,
                'province_id' => $value->province_id
            ];
        }

        return response()->json([
            'status' => 200,
            'id' => $id,
            'amphures' => $amphures
        ]);
    }

    public function fetch_datatable_customer_sellers($pdgid,$pvid,$ampid){
        /**
         * ดึงแบบ API
         */
        // $api_token = $this->apiToken();
        // $path_search = "sellers/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers";
        // $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search,[
        //     'province_id' => $pvid,
        //     'amphoe_id' => $ampid
        // ]);
        // $res_api = $response->json();
        // $customer = array();

        // if($res_api['code'] == 200){
        //     foreach($res_api['data'] as $value){
        //         $customer[] = [
        //             'identify' => $value['identify'],
        //             'title' => $value['title'],
        //             'name' => $value['name'],
        //             'amphoe_name' => $value['amphoe_name'],
        //             'province_name' => $value['province_name'],
        //             'telephone' => $value['telephone'],
        //             'mobile' => $value['mobile']
        //         ];
        //     }
        // }

        /**
         * ดึงจากฐานข้อมูล และแปลงเป็น Array เพื่อไม่ต้องแก้ไขหน้า view
         */

        $customer = array();
        $api_customers = DB::table('api_customers')
            ->leftJoin('api_customer_to_pdglist', 'api_customer_to_pdglist.customers_identify', 'api_customers.identify')
            ->where('api_customer_to_pdglist.pdglist_identify', $pdgid)
            ->where('api_customers.province_id', $pvid)
            ->where('api_customers.amphoe_id', $ampid)
            ->get();
        foreach($api_customers as $value){
            $customer[] = [
                'identify' => $value->identify,
                'title' => $value->title,
                'name' => $value->name,
                'amphoe_name' => $value->amphoe_name,
                'province_name' => $value->province_name,
                'telephone' => $value->telephone,
                'mobile' => $value->mobile
            ];
        } 

        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
        })
        ->make(true);
    }

    public function fetch_datatable_customer_sellers_pdglist($pdgid){
        /**
         * ดึงแบบ API
         */
        // $api_token = $this->apiToken();
        // $path_search = "sellers/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers";
        // $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        // $res_api = $response->json();
        // $customer = array();

        // if($res_api['code'] == 200){
        //     foreach($res_api['data'] as $value){
        //         $customer[] = [
        //             'identify' => $value['identify'],
        //             'title' => $value['title'],
        //             'name' => $value['name'],
        //             'amphoe_name' => $value['amphoe_name'],
        //             'province_name' => $value['province_name'],
        //             'telephone' => $value['telephone'],
        //             'mobile' => $value['mobile']
        //         ];
        //     }
        // }

        /**
         * ดึงจากฐานข้อมูล และแปลงเป็น Array เพื่อไม่ต้องแก้ไขหน้า view
         */
        $customer = array();

        $api_customers = DB::table('api_customers')
            ->leftJoin('api_customer_to_pdglist', 'api_customer_to_pdglist.customers_identify', 'api_customers.identify')
            ->where('api_customer_to_pdglist.pdglist_identify', $pdgid)
            ->get();
        foreach($api_customers as $value){
            $customer[] = [
                'identify' => $value->identify,
                'title' => $value->title,
                'name' => $value->name,
                'amphoe_name' => $value->amphoe_name,
                'province_name' => $value->province_name,
                'telephone' => $value->telephone,
                'mobile' => $value->mobile
            ];
        } 

        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
        })
        ->make(true);

    }

    public function fetch_datatable_customer_sellers_pdglist_pvid($pdgid, $pvid){
        /**
         * ดึงแบบ API
         */
        // $api_token = $this->apiToken();
        // $path_search = "sellers/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers";
        // $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search,[
        //     'province_id' => $pvid,
        // ]);
        // $res_api = $response->json();
        // $customer = array();

        // if($res_api['code'] == 200){
        //     foreach($res_api['data'] as $value){
        //         $customer[] = [
        //             'identify' => $value['identify'],
        //             'title' => $value['title'],
        //             'name' => $value['name'],
        //             'amphoe_name' => $value['amphoe_name'],
        //             'province_name' => $value['province_name'],
        //             'telephone' => $value['telephone'],
        //             'mobile' => $value['mobile']
        //         ];
        //     }
        // }

        /**
         * ดึงจากฐานข้อมูล และแปลงเป็น Array เพื่อไม่ต้องแก้ไขหน้า view
         */

        $customer = array();

        $api_customers = DB::table('api_customers')
            ->leftJoin('api_customer_to_pdglist', 'api_customer_to_pdglist.customers_identify', 'api_customers.identify')
            ->where('api_customer_to_pdglist.pdglist_identify', $pdgid);

            if($pvid != ""){
                $api_customers = $api_customers->where('api_customers.province_id', $pvid);
            }
            
            $api_customers = $api_customers->get();

        foreach($api_customers as $value){
            $customer[] = [
                'identify' => $value->identify,
                'title' => $value->title,
                'name' => $value->name,
                'amphoe_name' => $value->amphoe_name,
                'province_name' => $value->province_name,
                'telephone' => $value->telephone,
                'mobile' => $value->mobile
            ];
        } 

        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
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
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
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
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
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
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
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
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
        })
        ->make(true);
    }

    public function fetch_datatable_customer_leaders_pdglist_pvid($pdgid, $pvid){
        $api_token = $this->apiToken();
        $path_search = "saleleaders/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search,[
            'province_id' => $pvid,
        ]);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
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
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
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
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
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
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
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
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
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
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
        })
        ->make(true);
    }

    public function fetch_datatable_customer_headers_pdglist_pvid($pdgid, $pvid){
        $api_token = $this->apiToken();
        $path_search = "saleheaders/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search,[
            'province_id' => $pvid,
        ]);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
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
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
        })
        ->make(true);
    }
    //-- จบ สำหรับ Header--

    //-- สำหรับ Admin--

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
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
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
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
        })
        ->make(true);
    }

    public function fetch_datatable_customer_admin_pdglist($pdgid){
        $api_token = $this->apiToken();
        $path_search = "pdglists/".$pdgid."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $key => $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
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
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
        })
        ->make(true);
    }

    public function fetch_datatable_customer_admin_pdglist_pvid($pvid){
        $api_token = $this->apiToken();
        $path_search = "provinces/".$pvid."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();
        
        if($res_api['code'] == 200){
            foreach($res_api['data'] as $key => $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
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
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
        })
        ->make(true);
    }

    //-- จบ สำหรับ Admin--



    /**
     *  --- ดึงข้อมูลจาก API ลงฐานข้อมูลระบบ
     */

    public function api_fetch_provinces(){ //-- ดึงจังหวัด
        DB::beginTransaction();
        try {
            $api_token = $this->apiToken();
            $path_search = "provinces";
            $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
            $res_api = $response->json();
            
            if($res_api['code'] == 200){
                foreach($res_api['data'] as $api_key => $api_value){
                    $api_provinces = DB::table('api_provinces')->where('identify', $api_value['identify'])->first();
                    if(is_null($api_provinces)){
                        DB::table('api_provinces')
                        ->insert([
                            'identify'  => $api_value['identify'],
                            'name_thai' => $api_value['name_thai'],
                            'region_id' => $api_value['region_id']
                        ]);
                    }else{
                        DB::table('api_provinces')
                        ->where('identify', $api_value['identify'])
                        ->update([
                            'name_thai' => $api_value['name_thai'],
                            'region_id' => $api_value['region_id']
                        ]);
                    }
                }
            }
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกข้อมูลได้',
            ]);
        }
    }

    public function api_fetch_amphures(){ //-- ดึง อำเภอ
        DB::beginTransaction();
        try {
            $api_token = $this->apiToken();
            $path_search = "amphures";
            $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
            $res_api = $response->json();
            
            if($res_api['code'] == 200){
                foreach($res_api['data'] as $api_key => $api_value){
                    $api_provinces = DB::table('api_amphures')->where('identify', $api_value['identify'])->first();
                    if(is_null($api_provinces)){
                        DB::table('api_amphures')
                        ->insert([
                            'identify'  => $api_value['identify'],
                            'name_thai' => $api_value['name_thai'],
                            'province_id' => $api_value['province_id']
                        ]);
                    }else{
                        DB::table('api_amphures')
                        ->where('identify', $api_value['identify'])
                        ->update([
                            'name_thai' => $api_value['name_thai'],
                            'province_id' => $api_value['province_id']
                        ]);
                    }
                }
            }
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกข้อมูลได้',
            ]);
        }
    }


    public function fetch_customer_province_api($pid){ //-- ดึง ลูกค้าอ้างอิงที่จังหวัด (ใช้ในระบบทริป)

        switch  (Auth::user()->status){
            case 1 :    $path_search = 'sellers/'.Auth::user()->api_identify.'/customers';
                break;
            case 2 :    $path_search = 'saleleaders/'.Auth::user()->api_identify.'/customers';
                break;
            case 3 :    $path_search = 'saleheaders/'.Auth::user()->api_identify.'/customers';
                break;
            case 4 :    $path_search = 'customers';
                break;
        }

        $api_token = $this->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search,[
            'sortorder' => 'DESC',
            'province_id' => $pid
        ]);
        $res_api = $response->json();

        if($res_api['code'] == 200){
            $customer_api = $res_api['data'];
        }
        return response()->json([
            'status' => 200,
            'customer_api' => $customer_api
        ]);
        
    }
    

    public function api_fetch_customers(){ //-- ดึง ลูกค้า
        DB::beginTransaction();
        try {
            $api_token = $this->apiToken();
            $path_search = "customers";
            $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
            $res_api = $response->json();
            
            if($res_api['code'] == 200){
                DB::table('api_customers')->delete();
                foreach($res_api['data'] as $api_key => $api_value){
                    $api_provinces = DB::table('api_customers')->where('identify', $api_value['identify'])->first();
                    if(is_null($api_provinces)){
                        DB::table('api_customers')
                        ->insert([
                            'identify'  => $api_value['identify'],
                            'title' => $api_value['title'],
                            'name' => $api_value['name'],
                            'address1' => $api_value['address1'],
                            'adrress2' => $api_value['adrress2'],
                            'postal_id' => $api_value['postal_id'],
                            'telephone' => $api_value['telephone'],
                            'mobile' => $api_value['mobile'],
                            'contact' => $api_value['contact'],
                            'regional_id' => $api_value['regional_id'],
                            'province_id' => $api_value['province_id'],
                            'amphoe_id' => $api_value['amphoe_id'],
                            'regional_name' => $api_value['regional_name'],
                            'province_name' => $api_value['province_name'],
                            'amphoe_name' => $api_value['amphoe_name'],
                            'focusdate' => $api_value['focusdate'],
                            'InMonthDays' => $api_value['InMonthDays'],
                            'TotalDays' => $api_value['TotalDays'],
                            'TotalCampaign' => $api_value['TotalCampaign'],
                            'TotalLimit' => $api_value['TotalLimit'],
                            'TotalAmount' => $api_value['TotalAmount'],
                            'DiffAmt' => $api_value['DiffAmt'],
                            'SellerCode' => $api_value['SellerCode'],
                            'image_url' => $api_value['image_url'],
                        ]);
                    }else{
                        DB::table('api_customers')
                        ->where('identify', $api_value['identify'])
                        ->update([
                            'identify'  => $api_value['identify'],
                            'title' => $api_value['title'],
                            'name' => $api_value['name'],
                            'address1' => $api_value['address1'],
                            'adrress2' => $api_value['adrress2'],
                            'postal_id' => $api_value['postal_id'],
                            'telephone' => $api_value['telephone'],
                            'mobile' => $api_value['mobile'],
                            'contact' => $api_value['contact'],
                            'regional_id' => $api_value['regional_id'],
                            'province_id' => $api_value['province_id'],
                            'amphoe_id' => $api_value['amphoe_id'],
                            'regional_name' => $api_value['regional_name'],
                            'province_name' => $api_value['province_name'],
                            'amphoe_name' => $api_value['amphoe_name'],
                            'focusdate' => $api_value['focusdate'],
                            'InMonthDays' => $api_value['InMonthDays'],
                            'TotalDays' => $api_value['TotalDays'],
                            'TotalCampaign' => $api_value['TotalCampaign'],
                            'TotalLimit' => $api_value['TotalLimit'],
                            'TotalAmount' => $api_value['TotalAmount'],
                            'DiffAmt' => $api_value['DiffAmt'],
                            'SellerCode' => $api_value['SellerCode'],
                            'image_url' => $api_value['image_url'],
                        ]);
                    }
                }
            }
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกข้อมูลได้',
            ]);
        }
    }

    public function api_fetch_pdglists(){ // ดึงสินค้า pdglists
        DB::beginTransaction();
        try {
            $api_token = $this->apiToken();
            $path_search = "pdglists";
            $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
            $res_api = $response->json();
            
            if($res_api['code'] == 200){
                foreach($res_api['data'] as $api_key => $api_value){
                    $api_provinces = DB::table('api_pdglists')->where('identify', $api_value['identify'])->first();
                    if(is_null($api_provinces)){
                        DB::table('api_pdglists')
                        ->insert([
                            'identify'  => $api_value['identify'],
                            'name' => $api_value['name'],
                            'sub_code' => $api_value['sub_code'],
                        ]);
                    }else{
                        DB::table('api_pdglists')
                        ->where('identify', $api_value['identify'])
                        ->update([
                            'identify'  => $api_value['identify'],
                            'name' => $api_value['name'],
                            'sub_code' => $api_value['sub_code'],
                        ]);
                    }
                }
            }
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Yes. Success.!',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 404,
                'message' => 'Database Not Save.!',
            ]);
        }
    }

    public function api_customer_to_pdglist(){ // ดึง ข้อมูลลูกค้า เปรียเทียบ สินค้าที่ซื้อ
        DB::beginTransaction();
        try {
            $api_token = $this->apiToken();
            DB::table('api_customer_to_pdglist')->delete(); //-- ลบข้อมูลออกทั้งหมด

            $path_search = "customer-productlists";
            $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
            $res_api = $response->json();

            // dd($res_api);

            if($res_api['code'] == 200){
                foreach($res_api['data'] as $api_key => $api_value){
                    DB::table('api_customer_to_pdglist')
                    ->insert([
                        'customers_identify' => $api_value['identify'],
                        'pdglist_identify'  => $api_value['pdlist_id'],
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Yes. Success.!',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 404,
                'message' => 'Database Not Save.!',
            ]);
        }
    }


    /**
     * --- จบการดึง ดึงข้อมูลจาก API ลงฐานข้อมูลระบบ
     */


    public function fetch_campaignpromotes($year){

        $api_token = $this->apiToken();

        $path_search = "campaignpromotes";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search,[
            'years' => $year
        ]);
        $res_api = $response->json();

        // dd($res_api);

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $key => $value){
                $campaignpromotes[] = [
                    'campaign_id' => $value['campaign_id'],
                    'description' => $value['description'],
                    'fromdate' => $value['fromdate'],
                    'todate' => $value['todate'],
                    'remark' => $value['remark'],
                    'Product' => $value['Product'],
                    'Seller' => $value['Seller'],
                    'Target' => $value['Target'],
                    'Sales' => $value['Sales'],
                    'Diff' => $value['Diff']
                ];
            }
        }
        return response()->json([
            'status' => 200,
            'campaignpromotes' => $campaignpromotes,
            'message' => 'Yes. Success.!',
        ]);

    }

}
